<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUser\DataTable\AppUsersDataTable;
use App\Modules\AppUser\Http\Resources\AppUserReferralRequestResource;
use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserReferralRequest;
use App\Modules\CoinManagement\Models\UserCoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;


class AppUserController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppUsersDataTable $dataTable)
    {
        return $dataTable->render("AppUser::app-user-list");
        // return view("AppUser::app-user-list");
    }
    public function view($user)
    {
        $appUser = AppUser::findOrFail($user);

        return view("AppUser::app-user-view", compact('appUser'));
        // return view("AppUser::app-user-list");
    }
    public function apiUserDetails()
    {

        return response()->json([
            'status' => true,
            'data' => new AppUserResource(auth()->user()),
        ]);
    }
    public function apiUserProfileUpdate(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric',
            'referral_id' => 'nullable|string|max:255',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }
        if ($request->referral_id) {

            $r_ck = AppUser::where('user_id', $request->referral_id)->first();
            if (!$r_ck) {
                return response([
                    'status' => false,
                    'message' => 'Referral user not exist. Please check referral id.',
                ]);
            }

            $r_count = AppUser::where('referral_id', $request->referral_id)->count();

            $max_referral_user = Helper::get_config('max_referral_user') ?? 0;
            if ($r_count >= $max_referral_user) {
                return response([
                    'status' => false,
                    'message' => 'Referral user\'s on max limit.',
                ]);
            }
        }

        $user = AppUser::find(auth()->id());
        $user->name = $request->name;
        if (!$user->referral_id) {
            $user->referral_id = $request->referral_id;
        }
        $user->mobile = $request->mobile;
        if ($user->update()) {
            return response()->json([
                'status' => true,
                'data' =>  $user,
                'message' => 'Profile updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ]);
        }


        // return view("AppUser::app-user-list");
    }
    public function apiUserProfilePhotoUpdate(Request $request)
    {
        $rules = [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '-' . auth()->id() . '.' . $image->getClientOriginalExtension();

            $image = ImageManager::imagick()->read($image);
            $image->resize(300, 200);

            // $resizedImage = Image::make($image)
            //     ->resize(300, 300, function ($constraint) {
            //         $constraint->aspectRatio(); // Maintain aspect ratio
            //     });
            $img_path = 'images/profile/' . $filename;
            $path = Storage::disk('public')->put($img_path, (string) $image->encode()); // Store the resized image


            // Resize the image
            // $resizedImage = Image::make($image)->resize(300, 300, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->encode('jpg');

            // Store the image in the public disk
            // Storage::disk('public')->put($imagePath, $resizedImage);

            AppUser::where('id', auth()->id())->update([
                'photo' => $img_path
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Image uploaded successfully',
                'path' => asset('storage/' . $img_path),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Image upload failed'
        ], 422);


        // return view("AppUser::app-user-list");
    }
    public function apiUserTotalCoin()
    {
        $coin = UserCoin::where('app_user_id', auth()->id())->value('coin') ?? 0;
        return response()->json([
            'status' => true,
            'coin' => $coin,
        ]);
        // return view("AppUser::app-user-list");
    }
    public function apiMyReferral()
    {

        $users = AppUser::where('referral_id', auth()->id())->get();
        return response()->json([
            'status' => true,
            'referral_users' => AppUserResource::collection($users),
        ]);
        // return view("AppUser::app-user-list");
    }
    public function apiMyReferralRequest()
    {

        $users = AppUserReferralRequest::where('requested_app_user_id', auth()->id())->get();
        return response()->json([
            'status' => true,
            'referral_requests' => AppUserReferralRequestResource::collection($users),
        ]);
        // return view("AppUser::app-user-list");
    }
}
