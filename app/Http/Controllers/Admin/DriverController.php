<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isAdmin', 'auth']);
    }

    public function index()
    {
        $drivers = User::where('role', 'driver')->orderBy('created_at', 'desc')->get();
        return view('admin-authenticated.driver.index', compact('drivers'));
    }

    public function viewAddDriver()
    {
        return view('admin-authenticated.driver.add');
    }

    public function storeAddDriver(Request $request, User $driver)
    {
        $driverValidate = $request->validate(
            [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'avatar' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
                'driversLicensePhoto' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
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

        $avatarName = $request->file('avatar')->store('profiles', 'public');
        $driversLicensePhoto = $request->file('driversLicensePhoto')->store('driverFiles', 'public');

        $driverValidate['password'] = Hash::make($driverValidate['password']);
        $driverValidate['avatar'] = $avatarName;

        $data = [
            'role' => 'driver',
            'privacyPolicy' => true,
            'status' => true
        ];

        $user = $driver->create(array_merge($data, $driverValidate));
        if ($user) {
            $user->driverInfo()->create([
                'driversLicensePhoto' => $driversLicensePhoto,
            ]);

            return redirect(route('admin.drivers'))->with('success', 'Successful Added ' . $driverValidate['firstName'] .' as a Driver');
        }
    }

    // edit shop owner
    public function viewEditDriver($id)
    {
        $driver = User::findOrFail($id);

        return view('admin-authenticated.driver.edit', compact('driver'));
    }

    public function updateDriver($id, Request $request)
    {
        $driver = User::findOrFail($id);
        $driverValidate = $request->validate(
            [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
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

        try {

            if (!empty($request->file('avatar'))){
                $avatarName = $request->file('avatar')->store('profiles', 'public');
                $driverValidate['avatar'] = $avatarName;
            }

            if ($request->input('password') !== 'Laravel@123') {
                $driverValidate['password'] = Hash::make($driverValidate['password']);
            } else {
                unset($driverValidate['password']);
            }

            $data = [
                'role' => 'driver',
                'privacyPolicy' => true,
                'status' => true
            ];

            $user = $driver->update(array_merge($data, $driverValidate));

            if (!empty($request->file('driversLicensePhoto')) || !empty($request->file('driverCertificatePhoto'))) {
                $driversLicensePhoto = $request->file('driversLicensePhoto')->store('driverFiles', 'public');

                if ($user) {
                    $driver->driverInfo()->update([
                        'driversLicensePhoto' => $driversLicensePhoto,
                    ]);
                    return back()->with('success', 'Successful update ' . $driverValidate['firstName'] . ' with License and certificate.');
                }
            }else{
                return back()->with('success', 'Successful update ' . $driverValidate['firstName']);
            }

            

            return redirect()->back()->with('error', 'Failed to update user credentials.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // approval
    public function approveDriver($id, User $user) {
        $driver = $user->findOrFail($id);

        $driver->update([
            'status' => ($driver->status == true ? false : true) 
        ]);

        return back()->with('success', $driver->firstName . ($driver->status == true ? ' has been approved.' : ' has move to pending.'));
    }

    // deletion
    public function deleteDriver($id, User $user) {
        $driver = $user->findOrFail($id);
        $driver->delete();
        return redirect(route('admin.drivers'))->with('success', $driver->firstName . ' has been remove permanently.');
    }
}
