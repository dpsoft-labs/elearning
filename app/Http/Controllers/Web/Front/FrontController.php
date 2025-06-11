<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\BlogComment;
use App\Models\Team;
use App\Models\Question;
use App\Models\Contact;
use App\Models\SeoPage;
use Illuminate\Support\Str;
use App\Models\Admission;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\User;
use Nafezly\Payments\Classes\KashierPayment;
use Nafezly\Payments\Classes\StripePayment;
class FrontController extends Controller
{
    public function index(Request $request)
    {
        $seoPage = SeoPage::getBySlug('/');
        $questions = Question::all();
        $team_members = Team::all();
        return view(theme('front.index'), compact('seoPage', 'questions', 'team_members'));
    }


    public function about(Request $request)
    {
        $seoPage = SeoPage::getBySlug('about');
        return view(theme('front.about'), compact('seoPage'));
    }

    public function blog(Request $request)
    {
        $seoPage = SeoPage::getBySlug('blog');
        $query = Blog::orderByDesc('id');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // فلترة حسب التصنيف
        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->paginate(5);
        $popular_posts = Blog::orderByRaw('RAND()')->limit(3)->get();
        $categories = BlogCategory::whereHas('blogs')->get();

        return view(theme('front.blog'), compact('posts', 'categories', 'popular_posts', 'seoPage'));
    }

    public function blogDetails(Request $request, $slug)
    {
        $seoPage = SeoPage::getBySlug('blog-post');
        $post = Blog::where('slug', $slug)->first();
        $related_posts = Blog::where('blog_category_id', $post->blog_category_id)->where('id', '!=', $post->id)->orderByDesc('id')->limit(3)->get();
        return view(theme('front.blog_details'), compact('post', 'related_posts', 'seoPage'));
    }

    public function blogReply(Request $request)
    {
        // التحقق من تسجيل دخول المستخدم
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // التحقق من صحة البيانات
        $request->validate([
            'content' => 'required|string',
            'blog_id' => 'required|exists:blogs,id',
            'parent_id' => 'nullable|exists:blog_comments,id'
        ]);

        // إنشاء تعليق جديد
        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->user_id = auth()->user()->id;
        $comment->content = $request->content;

        // إذا كان هناك parent_id فهو رد على تعليق
        if ($request->parent_id) {
            $comment->parent_id = $request->parent_id;
        }

        $comment->save();

        return back()->with('success', __('l.Comment added successfully'));
    }

    public function team(Request $request)
    {
        $seoPage = SeoPage::getBySlug('team');
        $team_members = Team::all();
        return view(theme('front.team'), compact('team_members', 'seoPage'));
    }

    public function faqs(Request $request)
    {
        $seoPage = SeoPage::getBySlug('faq');
        $questions = Question::all();
        return view(theme('front.questions'), compact('questions', 'seoPage'));
    }

    public function contact(Request $request)
    {
        $seoPage = SeoPage::getBySlug('contact');
        return view(theme('front.contact'), compact('seoPage'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'nullable|string',
            'phone' => 'required|string',
            'details' => 'required|string',
        ]);

        $search = Contact::where('ip', $request->ip())->orderByDesc('id')->first();

        if ($search && (strtotime($search->created_at." +60 minutes") > time())) {
            return redirect()->back()->with('error', __('l.Error can not send more than 1 message every hour'));
        }

        $contact = Contact::create([
            'ip' => $request->ip(),
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'details' => $request->details,
            'status' => 0,
        ]);

        \App\Jobs\ContactsJob::dispatch($contact);

        return redirect()->back()->with('success', __('l.Message sent successfully'));
    }

    public function terms(Request $request)
    {
        $seoPage = SeoPage::getBySlug('terms');
        return view(theme('front.terms'), compact('seoPage'));
    }

    public function privacy(Request $request)
    {
        $seoPage = SeoPage::getBySlug('privacy');
        return view(theme('front.privacy'), compact('seoPage'));
    }

    public function subscribe(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->input('email');
        $subscriber->is_active = 1;
        $subscriber->unsubscribe_token = Str::random(32);
        $subscriber->save();

        return redirect()->back()->with('success', __('l.Subscriber added successfully'));
    }

    public function verify($payment, Request $request){
        // if($payment == 'kashier'){
            $payment = new KashierPayment();
        // } elseif($payment == 'stripe'){
        //     $payment = new StripePayment();
        // }

        $response = $payment->verify($request);
        $invoice = Invoice::where('pid', $response['payment_id'])->first();

        if($response['success'] == 'true'){
            $invoice->status = 'paid';
            $invoice->paid_at = now();
            $invoice->save();

            return redirect()->route('dashboard.users.invoices-show', ['invoice_id' => encrypt($invoice->id)])->with(['success' => 'Payment verified successfully.']);
        } else {
            $invoice->status = 'failed';
            $invoice->save();
            return redirect()->route('dashboard.users.invoices-show', ['invoice_id' => encrypt($invoice->id)])->with(['error' => 'Payment failed please try again.']);
        }
    }

    public function kashierWebhook(Request $request)
    {
        $raw_payload = file_get_contents('php://input');
        $json_data = json_decode($raw_payload, true);
        $data_obj = $json_data['data'];
        $event = $json_data['event'];
        sort($data_obj['signatureKeys']);
        $headers = getallheaders();
        // Lower case all keys
        $headers = array_change_key_case($headers);
        $kashierSignature = $headers['x-kashier-signature'];
        $data = [];
        foreach ($data_obj['signatureKeys'] as $key) {
            $data[$key] = $data_obj[$key];
        }

        $paymentApiKey = config('nafezly-payments.KASHIER_IFRAME_KEY');
        $queryString = http_build_query($data, $numeric_prefix = "", $arg_separator = '&', $encoding_type = PHP_QUERY_RFC3986);
        $signature = hash_hmac('sha256',$queryString, $paymentApiKey, false);;
        if ($signature == $kashierSignature) {
            if($data_obj['status'] == 'SUCCESS'){

                $invoice = Invoice::where('pid', $data_obj['merchantOrderId'])->first();

                if ($invoice->status != 'paid') {
                    $invoice->status = 'paid';
                    $invoice->save();
                }

            }

            echo 'valid signature';
            http_response_code(200);
        } else {
            \App\Models\Setting::createOrUpdate([
                'option' => 'kashier_webhook',
                'value' => '0'
            ]);

           echo 'invalid signature';
           die();
        }
    }

    public function admission(Request $request)
    {
        $seoPage = SeoPage::getBySlug('admission');
        $countries = Country::all();

        $admission_status = \App\Models\Setting::where('option', 'admission_status')->first()->value;

        if ($admission_status != 1) {
            return redirect(404);
        }

        return view(theme('front.admission'), compact('seoPage', 'countries'));
    }

    public function admissionStore(Request $request)
    {
        $request->validate([
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'national_id' => 'required|string|max:255',
            'certificate_type' => 'required|in:azhary,languages,general',
            'school_name' => 'required|string|max:255',
            'graduation_year' => 'required|string|max:4',
            'grade_percentage' => 'required|numeric|min:0|max:100',
            'grade_evaluation' => 'required|string|max:255',
            'academic_section' => 'required|in:science,math',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:255',
            'parent_job' => 'required|string|max:255',
            'student_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'certificate_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'national_id_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'parent_national_id_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $admission = new Admission();

        // المعلومات الشخصية
        $admission->en_name = $request->en_name;
        $admission->ar_name = $request->ar_name;
        $admission->email = $request->email;
        $admission->phone = $request->phone;
        $admission->address = $request->address;
        $admission->city = $request->city;
        $admission->country = $request->country;
        $admission->gender = $request->gender;
        $admission->date_of_birth = $request->date_of_birth;
        $admission->nationality = $request->nationality;
        $admission->national_id = $request->national_id;

        // معلومات التعليم
        $admission->certificate_type = $request->certificate_type;
        $admission->school_name = $request->school_name;
        $admission->graduation_year = $request->graduation_year;
        $admission->grade_percentage = $request->grade_percentage;
        $admission->grade_evaluation = $request->grade_evaluation;
        $admission->academic_section = $request->academic_section;

        // معلومات الوالدين
        $admission->parent_name = $request->parent_name;
        $admission->parent_phone = $request->parent_phone;
        $admission->parent_job = $request->parent_job;

        // رفع الصور
        $admission->student_photo = upload_to_public($request->file('student_photo'), 'images/admissions/students');
        $admission->certificate_photo = upload_to_public($request->file('certificate_photo'), 'images/admissions/certificates');
        $admission->national_id_photo = upload_to_public($request->file('national_id_photo'), 'images/admissions/national_ids');
        $admission->parent_national_id_photo = upload_to_public($request->file('parent_national_id_photo'), 'images/admissions/parent_national_ids');

        $admission->status = 'pending';
        $admission->save();

        return redirect()->back()->with(['success' => __('front.admission_sent_successfully'), 'admission' => $admission]);
    }

    public function admissionShow(Request $request)
    {
        $admission = Admission::find($request->id);
        if (!$admission) {
            return redirect()->back()->with('error', __('front.admission_not_found'));
        }

        return view(theme('front.admission-show'), compact('admission'));
    }

}
