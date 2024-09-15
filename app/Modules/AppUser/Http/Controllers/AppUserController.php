<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Modules\AppUser\DataTable\AppUsersDataTable;
use App\Modules\AppUser\Http\Resources\AppUserReferralRequestResource;
use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserReferralRequest;
use App\Modules\AppUserBalance\Models\DepositLog;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',

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


           // $user = AppUser::find(auth()->id());

            // Check if a previous photo exists and delete it
            // if ($user->photo) {
            //     Storage::disk('public')->delete($user->photo);
            // }

            $manager = new ImageManager(['driver' => 'imagick']);

            $image = $manager->make($image)->resize(200, 200);

            $img_path = 'images/profile/' . $filename;
            $path = Storage::disk('public')->put($img_path, (string) $image->encode()); // Store the resized image

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
    public function apiGetReferralByUser(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',

        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        $users = AppUser::where('referral_id', $request->user_id)->get();
        return response()->json([
            'status' => true,
            'referral_users' => AppUserResource::collection($users),
        ]);
        // return view("AppUser::app-user-list");
    }

    public function apiPasswordResetForm(Request $request)
    {
        // dd('asdas');

        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$tokenData) {
            return response()->view('errors.404', [], 404);
        }

        return view('auth.api-reset-password')->with(
            ['token' => $tokenData->token, 'email' => $tokenData->email]
        );
    }
    public function apiPasswordReset(Request $request)
    {
        // dd('asdas');

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $tokenData = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid token or email']);
        }

        $user = AppUser::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return view('auth.api-reset-password-success')->with('status', 'Password has been reset.');
    }

    public function appUserLogin()
    {


        return view('frontend.auth.login');
    }
    public function appUserLoginStore(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        // Attempt to authenticate the user using the 'appuser' guard
        if (Auth::guard('appuser')->attempt($request->only('email', 'password'))) {
            // Authentication passed, redirect to the intended page or a default page
            return redirect()->route('user.profile'); // Replace with your intended route
        }

        // Authentication failed, redirect back with input and error message
        return back()->withInput()->withErrors(['email' => 'Invalid credentials.']);
    }
    public function register()
    {

        return view('frontend.auth.register');
    }
    public function registerStore(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:app_users,email',
            'user_id' => 'required|digits:10|unique:app_users,user_id',
            'password' => 'required|confirmed|min:6|max:255',
            'referral_id' => 'nullable|digits:10'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }
        if ($request->referral_id) {
            $ck_referral = AppUser::where('user_id', $request->referral_id)->first();
            if (!$ck_referral) {
                $validate->errors()->add(
                    'referral_id', 'Referral user not found!'
                );
                return redirect()->back()->withInput()->withErrors($validate);

            }

            $user_ref_ck = AppUser::where('referral_id', $request->referral_id)->get();
            $chk_value= Helper::get_config('max_referral_user')??5;
            if (count($user_ref_ck) >= $chk_value) {
                $validate->errors()->add(
                    'referral_id', 'Referral user over limit. Please use others referral code !'
                );
                return redirect()->back()->withInput()->withErrors($validate);

            }
        }
        $transactionFail = false;
        DB::beginTransaction();
        try {

            $app_user = new AppUser();
            $app_user->name = $request->name;
            $app_user->email = $request->email;
            $app_user->user_id = $request->user_id;
            $app_user->password = Hash::make($request->password);
            if ($app_user->save()) {
                if ($request->referral_id) {
                    $referral_request = new AppUserReferralRequest();
                    $referral_request->app_user_id = $app_user->id;
                    $referral_request->requested_app_user_id = $ck_referral->id;
                    $referral_request->status = 1;
                    if (!$referral_request->save()) {
                        $transactionFail = true;
                    }
                }
                $amount = Helper::get_config('registration_bonus') ?? 0;
                $user_coin_create = new UserCoin();
                $user_coin_create->app_user_id = $app_user->id;
                //  $coin_setting
                $user_coin_create->coin = $amount;
                if ($user_coin_create->save()) {
                    $u_c_details = new UserCoinDetail();
                    $u_c_details->source = 'INITIAL';
                    $u_c_details->coin_type = 'ADD';
                    $u_c_details->user_coin_id = $user_coin_create->id;
                    $u_c_details->coin = $amount;
                    if (!$u_c_details->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }


            if ($transactionFail) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error','Something went wrong!');

            } else {

                DB::commit();
                return redirect()->route('user.login')->with('success','Registration successfully. Please Login.');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error',$th->getMessage());

        }
        //return view('frontend.auth.register');
    }
    public function appUserProfile()
    {
        // dd('profile');
        return view('frontend.auth.profile');
    }
    public function appUserDashboard()
    {
        // dd('profile');
        return view('frontend.dashboard');
    }
    public function appUserDeposit()
    {
        $methods = PaymentMethod::where('status',1)->get();
        return view('frontend.deposit.deposit_page',compact('methods'));
    }
    public function appUserDepositHistory()
    {
        $deposits = DepositLog::orderBy('status')->get();
        return view('frontend.deposit.deposit_history_page',compact('deposits'));
    }
    public function appUserDepositMethodSubmit(Request $request)
    {
        $request->validate([
            'method'=>'required|numeric',
            'amount'=>'required|numeric',
            'transaction_fee'=>'required|numeric'
        ]);

        $method = PaymentMethod::findOrFail($request->method);
        $transaction_fee = ($request->amount / 1000)*$method->transaction_fee;
        $data = [
            'method'=>$method,
            'amount'=>$request->amount,
            'transaction_fee'=>$transaction_fee
        ];
        return view('frontend.deposit.deposit_final_page')->with($data);


    }
    public function appUserDepositFinalSubmit(Request $request)
    {

        //  dd($request->all());
        $request->validate([
            'method'=>'required|numeric',
            'amount'=>'required|numeric',
            'transaction_id'=>'required|string|max:255'
        ]);

        $method = PaymentMethod::findOrFail($request->method);

        $amount = $request->amount;
        $charge =  ($request->amount / 1000)*$method->transaction_fee;
        $total = $amount + $charge;

        $log = new DepositLog();
        $log->payment_method_id = $method->id;
        $log->app_user_id = auth()->id();
        $log->deposit_date = now();
        $log->amount = $amount;
        $log->charge = $charge;
        $log->total = $total;
        $log->transaction_id = $request->transaction_id;
        $log->creator = 'user';
        $log->created_by = auth()->id();
        $log->status = 1;
        if($log->save()){
            return redirect()->route('user.deposit.history')->with('success','Deposit request submited successfully.');
        }else{
            return redirect()->back()->with('error','Something went wrong.');
        }
    }
    public function appUserLogout(Request $request)
    {
        // Auth::guard('appuser')->logout();
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home'); // Replace with your desired route


    }

    public function appUserWithdraw()
    {
        $methods = PaymentMethod::where('status',1)->get();
        return view('frontend.withdraw.withdraw_page',compact('methods'));
    }

    public function appUserWithdrawMethodSubmit(Request $request)
    {
        $request->validate([
            'method'=>'required|numeric',
            'amount'=>'required|numeric',
            'transaction_fee'=>'required|numeric'
        ]);

        $method = PaymentMethod::findOrFail($request->method);
        $transaction_fee = ($request->amount / 1000)*$method->transaction_fee;
        $data = [
            'method'=>$method,
            'amount'=>$request->amount,
            'transaction_fee'=>$transaction_fee
        ];
        return view('frontend.deposit.deposit_final_page')->with($data);


    }
}
