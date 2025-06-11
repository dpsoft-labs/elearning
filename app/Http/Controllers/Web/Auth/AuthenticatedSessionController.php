<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view(theme('auth.login'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $ip = $request->ip();
        $key = 'login_attempts:' . $ip;
        $maxAttempts = Setting::where('option', 'max_attempts')->first()->value;

        // التحقق من سجل المحاولات الحالي
        $attempts = Cache::get($key . ':attempts', 0);
        $lockoutTime = Cache::get($key . ':lockout_time', 0);

        if ($lockoutTime > time()) {
            // إذا كان هناك حظر ساري، نعيد الرسالة مع الوقت المتبقي
            $remainingTime = $lockoutTime - time();
            return redirect()->back()->withErrors([
                'limit' => __('l.Too many login attempts. Please try again in :minutes minutes.',
                    ['minutes' => ceil($remainingTime / 60)])
            ]);
        }

        try {
            // البحث عن المستخدم بالبريد الإلكتروني
            $user = \App\Models\User::where('email', $request->email)->first();

            // إذا لم يتم العثور على المستخدم بالبريد الإلكتروني، نبحث عن رقم الهاتف
            if (!$user) {
                // البحث عن رقم الهاتف في قاعدة البيانات
                $phoneInput = $request->email;

                // البحث عن المستخدم الذي رقم هاتفه يحتوي على الرقم المدخل
                $user = \App\Models\User::where('phone', 'LIKE', '%' . $phoneInput . '%')->first();
            }

            if (!$user) {
                throw new \Exception('Invalid credentials');
            }

            // التحقق مما إذا كان المستخدم قد قام بتفعيل 2FA
            if ($user && !empty($user->google2fa_secret)) {
                // تخزين بيانات المستخدم في الجلسة مؤقتاً
                session([
                    'auth.2fa.user_id' => $user->id,
                    'auth.2fa.remember' => $request->has('remember'),
                ]);

                // إعادة التوجيه إلى صفحة إدخال رمز 2FA
                return redirect()->route('2fa.challenge');
            }

            // إذا لم يكن 2FA مفعلاً، قم بتسجيل الدخول مباشرة
            $request->authenticate();

            Cache::forget($key . ':attempts'); // مسح عدد المحاولات بعد النجاح
            Cache::forget($key . ':lockout_time'); // مسح وقت الحظر بعد النجاح

            $remember = $request->has('remember') ? true : false;

            if($remember == true){
                $email = $request->email;
                $password = $request->password;
                $expiry = time() + 60 * 60 * 24 * 30; // مثال: صلاحية الملف لمدة 30 يومًا
                $hashedPassword = encrypt($password);

                setcookie('remember_user', $email, $expiry, "/");
                setcookie('remember_pass', $hashedPassword, $expiry, "/");
            } else {
                // حذف الكوكيز بتعيين وقت انتهاء الصلاحية في الماضي
                setcookie('remember_user', '', time() - 3600, "/");
                setcookie('remember_pass', '', time() - 3600, "/");
            }

            $request->session()->regenerate();
            return redirect()->intended(route('home', absolute: false));

        } catch (\Exception $e) {
            $newAttempts = $attempts + 1;
            $remainingAttempts = $maxAttempts - $newAttempts;

            if ($remainingAttempts > 0) {
                // لم يتجاوز الحد الأقصى بعد
                Cache::put($key . ':attempts', $newAttempts, now()->addMinutes(10)); // حفظ عدد المحاولات
                return redirect()->back()->withErrors([
                    'email' => __('l.Invalid credentials. You have :attempts attempts remaining.',
                        ['attempts' => $remainingAttempts])
                ]);
            }

            // إذا تجاوز الحد الأقصى، نبدأ فترة الحظر
            $lockoutTimeInSeconds = 600; // 10 دقائق
            if ($newAttempts >= $maxAttempts + 1) {
                $lockoutTimeInSeconds = 1800; // 30 دقيقة
            } elseif ($newAttempts >= $maxAttempts + 2) {
                $lockoutTimeInSeconds = 3600; // ساعة
            }

            Cache::put($key . ':attempts', $newAttempts, now()->addMinutes(10)); // حفظ عدد المحاولات
            Cache::put($key . ':lockout_time', time() + $lockoutTimeInSeconds, now()->addSeconds($lockoutTimeInSeconds)); // حفظ وقت الحظر

            return redirect()->back()->withErrors([
                'limit' => __('l.Too many login attempts. Please try again in :minutes minutes.',
                    ['minutes' => ceil($lockoutTimeInSeconds / 60)])
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
