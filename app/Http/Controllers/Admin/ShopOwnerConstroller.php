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
        $shopOwners = User::where('role', 'shopOwner')->get();
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
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'avatar' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
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

        $shopOwnerValidate['password'] = Hash::make($shopOwnerValidate['password']);
        $shopOwnerValidate['avatar'] = $avatarName;

        $data = [
            'role' => 'shopOwner',
            'privacyPolicy' => true,
            'status' => true
        ];

        $mergeData = array_merge($data, $shopOwnerValidate);

        $user = $shopOwner->create($mergeData);
        if ($user) {
            $user->shopOwnerInfo()->create([
                'shopName' => $shopOwnerValidate['shopName'],
                'shopPhone' => $shopOwnerValidate['shopPhone'],
                'shopAddress' => $shopOwnerValidate['shopAddress'],
                'shopLong' => $shopOwnerValidate['shopLong'],
                'shopLat' => $shopOwnerValidate['shopLat'],
                'shopDescription' => $shopOwnerValidate['shopDescription']
            ]);

            return redirect(route('admin.shop.owners'))->with('success', 'Successful Addition of '. $shopOwnerValidate['firstName'] .' as owner of ' . $shopOwnerValidate['shopName']);
        }

    }

    // edit shop owner
    public function viewEditShopOwner($id) {
        $shopOwner = User::findOrFail($id);

        return view('admin-authenticated.owner.edit', compact('shopOwner'));
    }
}
