<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Models\MechanicInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MechanicController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isOwner']);
    }

    public function index()
    {
        $mechanics = User::join('mechanic_infos', 'users.id', '=', 'mechanic_infos.user_id')
            ->where('users.role', 'mechanic')
            ->where('mechanic_infos.mechanicShopOwnerId', Auth::id())
            ->get(['users.*', 'mechanic_infos.id as mechanic_id', 'mechanic_infos.mechanicAddress', 'mechanic_infos.mechanicPhone', 'mechanic_infos.mechanicAvailability']);

        return view('shopOwner.index', compact('mechanics'));
    }

    public function addMechanics()
    {
        return view('shopOwner.add');
    }

    public function storeMechanics(Request $request, User $mechanic)
    {
        $mechanicValidate = $request->validate(
            [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'avatar' => ['required', 'image', 'mimes:jpg,png', 'max:2048'],
                'mechanicPhone' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/'
                ],
                'mechanicAddress' => ['required'],
                'mechanicRating' => ['required'],
                'phoneNumber' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/'
                ],
            ],
            [
                'contactNumber.regex' => 'Please ensure that contact number starts with "09" and consists of exactly 11 digits.',
            ]
        );

        $avatarName = $request->file('avatar')->store('profiles', 'public');

        $mechanicValidate['avatar'] = $avatarName;

        $data = [
            'role' => 'mechanic',
            'privacyPolicy' => true,
            'status' => true,
            'email' => $this->generateEmail()
        ];

        $user = $mechanic->create(array_merge($data, $mechanicValidate));
        if ($user) {
            $user->mechanicInfo()->create([
                'mechanicShopOwnerId' => Auth::id(),
                'mechanicAddress' => $mechanicValidate['mechanicAddress'],
                'mechanicPhone' => $mechanicValidate['mechanicPhone'],
                'mechanicRating' => $mechanicValidate['mechanicRating'],
            ]);

            return redirect(route('shop.owners.mechanics'))->with('success', 'Successful Added ' . $mechanicValidate['firstName'] . ' as mechanic.');
        }
    }

    protected function generateEmail()
    {
        $randomString = bin2hex(random_bytes(5));
        return "user" . $randomString . "@example.com";
    }

    // edit
    public function editMechanics($id)
    {
        $user = User::findOrFail($id);
        $mechanics = $user->join('mechanic_infos', 'users.id', '=', 'mechanic_infos.user_id')
            ->where('users.role', 'mechanic')
            ->where('mechanic_infos.mechanicShopOwnerId', Auth::id())
            ->first(['users.*', 'mechanic_infos.mechanicAddress', 'mechanic_infos.mechanicPhone']);

        return view('shopOwner.edit', compact('mechanics'));
    }

    // update mechanics
    public function updateMechanics($id, Request $request)
    {
        $owner = User::findOrFail($id);
        $shopOwnerValidate = $request->validate(
            [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'mechanicPhone' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/'
                ],
                'mechanicAddress' => ['required'],
                'phoneNumber' => [
                    'required',
                    'numeric',
                    'regex:/^09\d{9}$/'
                ],
            ],
            [
                'contactNumber.regex' => 'Please ensure that your contact number starts with "09" and consists of exactly 11 digits.',
            ]
        );
        if (!empty($request->file('avatar'))) {
            $avatarName = $request->file('avatar')->store('profiles', 'public');
            $shopOwnerValidate['avatar'] = $avatarName;
        }

        $data = [
            'role' => 'mechanic',
            'privacyPolicy' => true,
            'status' => true
        ];

        $user = $owner->update(array_merge($data, $shopOwnerValidate));

        if ($user) {
            $owner->mechanicInfo()->update([
                'mechanicAddress' => $shopOwnerValidate['mechanicAddress'],
                'mechanicPhone' => $shopOwnerValidate['mechanicPhone'],
            ]);

            return back()->with('success', 'Successful update of ' . $shopOwnerValidate['firstName'] . ' as mechanic.');
        }

        return redirect()->back()->with('error', 'Failed to update user credentials.');
    }

    public function updateMechanicsAvailability($id, Request $request, MechanicInfo $mechanicInfos)
    {
        $fields = $request->validate(['mechanicAvailability' => ['required']]);

        $mechanicInfo = $mechanicInfos->findOrFail($id);

        $updateAvailability = $mechanicInfo->update([
            'mechanicAvailability' => $fields['mechanicAvailability']
        ]);

        if (!$updateAvailability) {
            return back()->with('error', 'An error occurred.');
        }

        return back()->with('success', 'Successful update');
    }
}
