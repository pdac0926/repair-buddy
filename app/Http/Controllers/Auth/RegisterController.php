<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phoneNumber' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                    'confirmed'
                ],
            ],
            [
                'password.regex' => 'Please make sure your password includes at least one uppercase letter, one lowercase letter, one digit, and one special character (e.g., @, #, $).',
                'contactNumber.regex' => 'Please ensure that your contact number starts with "09" and consists of exactly 11 digits.',
            ]
        );

        Session::put('sessionRegisterDriverData', $request->all());
        return redirect(route('register.certificate'))->with('info', 'Ensure to submit your valid certificates. Thank you.');
    }

    public function showRegisterCertificate()
    {
        $registerSessionData = Session::get('sessionRegisterDriverData');
        if (empty($registerSessionData)) {
            return back()->with('warning', 'Complete the registration form before proceeding. Your accurate information ensures a smooth process. Thank you.');
        }

        return view('auth.register-certificates');
    }

    public function storeRegisterCertificate(Request $request, User $userModel)
    {
        $request->validate([
            'driverAvatar' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
            'privacyPolicy' => ['accepted'],
            'driversLicensePhoto' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
        ]);
        $registerSessionData = Session::get('sessionRegisterDriverData');
        $avatar = $request->file('driverAvatar')->store('profiles', 'public');

        $registerSessionData['password'] = Hash::make($registerSessionData['password']);

        $data = [
            'role' => 'driver',
            'privacyPolicy' => true,
            'status' => false,
            'avatar' => $avatar
        ];

        $mergeData = array_merge($data, $registerSessionData);

        $driversLicense = $request->file('driversLicensePhoto')->store('driverFiles', 'public');

        $user = $userModel->create($mergeData);
        if ($user) {
            $user->driverInfo()->create([
                'driversLicensePhoto' => $driversLicense,
            ]);

            Session::forget('sessionRegisterDriverData');
            return redirect(route('welcome'))->with('success', 'Thank you for registering! We\'ll review your information and notify you once approved. Your patience is appreciated.');
        }
    }
}
