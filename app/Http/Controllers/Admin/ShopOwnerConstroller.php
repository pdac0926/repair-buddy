<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopOwnerInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopOwnerConstroller extends Controller
{
    public function __construct()
    {
        $this->middleware(['isAdmin', 'auth']);
    }

    public function index()
    {
        $shopOwners = User::where('role', 'shopOwner')->orderBy('created_at', 'desc')->get();

        return view('admin-authenticated.owner.index', compact('shopOwners'));
    }

    public function viewAddShopOwner()
    {
        return view('admin-authenticated.owner.add');
    }

    public function storeAddShopOwner(Request $request, User $shopOwner)
    {
        $shopOwnerValidate = $request->validate(
            [
                'firstName' => ['required', 'string', 'max:15'],
                'middleName' => ['nullable', 'string', 'max:15'],
                'lastName' => ['required', 'string', 'max:15'],
                'address' => ['required', 'string', 'max:70'],
                'permitNumber' => ['required', 'numeric', 'digits_between:8,12'],
                'expiration' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{4}$/'],
                'avatar' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
                'permit' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
                'shopName' => ['required', 'string', 'max:40'],
                'shopPhone' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/',
                    'digits:11'
                ],
                'shopAddress' => ['required', 'string', 'max:255'],
                'shopLong' => ['required', 'numeric', 'between:-180,180'],
                'shopLat' => ['required', 'numeric', 'between:-90,90'],
                'shopDescription' => ['required', 'string', 'max:1000'],
                'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
                'phoneNumber' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/',
                    'digits:11'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/',
                    'confirmed'
                ],
            ],
            [
                'firstName.max' => 'The first name must not exceed 15 characters.',
                'middleName.max' => 'The middle name must not exceed 15 characters.',
                'lastName.max' => 'The last name must not exceed 15 characters.',
                'permitNumber.digits_between' => 'The permit number should be between 8 to 12 digits.',
                'expiration.regex' => 'The expiration date must be in the format MM/YYYY (e.g., 05/2025).',
                'expiration.after_or_equal' => 'The expiration date must be today or in the future.',
                'shopPhone.regex' => 'Please ensure that your shop phone number starts with "09" and contains exactly 11 digits.',
                'shopPhone.digits' => 'Shop phone number must be exactly 11 digits.',
                'shopLong.between' => 'Longitude should be between -180 and 180 degrees.',
                'shopLat.between' => 'Latitude should be between -90 and 90 degrees.',
                'shopDescription.max' => 'Shop description should not exceed 1000 characters.',
                'email.unique' => 'This email is already taken. Please use another email address.',
                'phoneNumber.regex' => 'Please ensure that your contact number starts with "09" and contains exactly 11 digits.',
                'phoneNumber.digits' => 'Your contact number must be exactly 11 digits.',
                'password.regex' => 'Password must include at least one uppercase letter, one digit, and one special character (e.g., @, #, $, etc.).',
            ]
        );



        $avatarName = $request->file('avatar')->store('profiles', 'public');
        $permitName = $request->file('permit')->store('permit', 'public');

        $shopOwnerValidate['password'] = Hash::make($shopOwnerValidate['password']);
        $shopOwnerValidate['avatar'] = $avatarName;
        $shopOwnerValidate['permit'] = $permitName;

        $data = [
            'role' => 'shopOwner',
            'privacyPolicy' => true,
            'status' => true
        ];

        $user = $shopOwner->create(array_merge($data, $shopOwnerValidate));
        if ($user) {
            $user->shopOwnerInfo()->create([
                'shopName' => $shopOwnerValidate['shopName'],
                'shopPhone' => $shopOwnerValidate['shopPhone'],
                'shopAddress' => $shopOwnerValidate['shopAddress'],
                'shopLong' => $shopOwnerValidate['shopLong'],
                'shopLat' => $shopOwnerValidate['shopLat'],
                'shopDescription' => $shopOwnerValidate['shopDescription'],
                'permit' => $shopOwnerValidate['permit'],
                'permitNumber' => $shopOwnerValidate['permitNumber'],
                'expiration' => $shopOwnerValidate['expiration'],
            ]);

            return redirect(route('admin.shop.owners'))->with('success', 'Successful Addition of ' . $shopOwnerValidate['firstName'] . ' as owner of ' . $shopOwnerValidate['shopName']);
        }
    }

    // edit shop owner
    public function viewEditShopOwner($id)
    {
        $shopOwner = User::findOrFail($id);

        return view('admin-authenticated.owner.edit', compact('shopOwner'));
    }

    public function updateShopOwner($id, Request $request)
    {
        $owner = User::findOrFail($id);
        $shopOwnerValidate = $request->validate(
            [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'shopName' => ['required'],
                'shopPhone' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/'
                ],
                'shopAddress' => ['required'],
                'shopLong' => ['required'],
                'shopLat' => ['required'],
                'shopDescription' => ['required'],
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
            if (!empty($request->file('avatar'))) {
                $avatarName = $request->file('avatar')->store('profiles', 'public');
                $shopOwnerValidate['avatar'] = $avatarName;
            }

            if ($request->input('password') !== 'Laravel@123') {
                $shopOwnerValidate['password'] = Hash::make($shopOwnerValidate['password']);
            } else {
                unset($shopOwnerValidate['password']);
            }

            $data = [
                'role' => 'shopOwner',
                'privacyPolicy' => true,
                'status' => true
            ];

            $user = $owner->update(array_merge($data, $shopOwnerValidate));

            if ($user) {
                $owner->shopOwnerInfo()->update([
                    'shopName' => $shopOwnerValidate['shopName'],
                    'shopPhone' => $shopOwnerValidate['shopPhone'],
                    'shopAddress' => $shopOwnerValidate['shopAddress'],
                    'shopLong' => $shopOwnerValidate['shopLong'],
                    'shopLat' => $shopOwnerValidate['shopLat'],
                    'shopDescription' => $shopOwnerValidate['shopDescription']
                ]);

                return back()->with('success', 'Successful update of ' . $shopOwnerValidate['firstName'] . ' as owner of ' . $shopOwnerValidate['shopName']);
            }

            return redirect()->back()->with('error', 'Failed to update user credentials.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // approval
    public function approveShopOwner($id, User $user)
    {
        $shopOwner = $user->findOrFail($id);

        $shopOwner->update([
            'status' => ($shopOwner->status == true ? false : true)
        ]);

        return back()->with('success', $shopOwner->firstName . ($shopOwner->status == true ? ' has been approved.' : ' has move to pending.'));
    }

    // deletion
    public function deleteShopOwner($id, User $user)
    {
        $shopOwner = $user->findOrFail($id);
        $shopOwner->delete();
        return redirect(route('admin.shop.owners'))->with('success', $shopOwner->firstName . ' has been remove permanently.');
    }
}
