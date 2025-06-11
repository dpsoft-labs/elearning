<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Setting;
use App\Jobs\Welcome_mailJob;
use App\Models\Country;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $countries = Country::all();
        $canRegister = Setting::where('option', 'can_any_register')->value('value');

        if ($canRegister != 1) {
            return redirect()->route('login')->with('error', 'Registration is not allowed');
        }

        return view(theme('auth.register'), ["countries" => $countries]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:30'],
            'lastname' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => 'required|string|max:20',
            'address' => 'string|max:255',
            'state' => 'string|max:30',
            'city' => 'string|max:30',
            'zip_code' => 'string|max:25',
            'country' => 'string|max:30',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $phone = str_replace(' ', '', $request['phone']);
        $phone = '+'.$request['phone_code'].$phone;

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $phone,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        $emailSetting = Setting::where('option', 'emailVerified')->value('value');
        if ($emailSetting == true) {
            event(new Registered($user));
        } else {
            $username = $request->firstname;
            $email = $request->email;
            Welcome_mailJob::dispatch($username, $email);
        }

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
