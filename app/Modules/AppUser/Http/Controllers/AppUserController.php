<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Modules\AppUser\DataTable\AppUsersDataTable;
use App\Modules\AppUser\Http\Resources\AppUserReferralRequestResource;
use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Http\Resources\DepositHistoryResource;
use App\Modules\AppUser\Http\Resources\WithdrawHistoryResource;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserReferralRequest;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\AppUserBalance\Models\DepositLog;
use App\Modules\AppUserBalance\Models\LevelIncomeLog;
use App\Modules\AppUserBalance\Models\WithdrawLog;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use App\Modules\Website\Http\Resources\OwnWebsiteResourse;
use App\Modules\Website\Models\OwnWebsite;
use App\Modules\Website\Models\OwnWebsiteVisitLog;
use App\Modules\Website\Models\Website;
use App\Modules\Website\Models\WebsiteVisitLog;
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

        $deposites = DepositLog::where('app_user_id', $appUser->id)->orderBy('status')->get();
        $withdraws = WithdrawLog::where('app_user_id', $appUser->id)->orderBy('status')->get();
        $user_coin = UserCoin::where('app_user_id', $appUser->id)->first();
        $user_coin_details = UserCoinDetail::where('user_coin_id', $user_coin->id)->get();
        $user_members = AppUser::where('referral_id', $appUser->user_id)->get();
        return view("AppUser::app-user-view", compact('appUser', 'deposites', 'withdraws', 'user_coin_details', 'user_members'));
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
    public function apiUserTotalBalance()
    {
        $balance = auth()->user()->balance->balance ?? 0;
        return response()->json([
            'status' => true,
            'balance' => $balance,
        ]);
        // return view("AppUser::app-user-list");
    }
    public function apiUserTotalStar()
    {
        $star = auth()->user()->balance->star ?? 0;
        return response()->json([
            'status' => true,
            'star' => $star,
        ]);
        // return view("AppUser::app-user-list");
    }
    public function apiUserAllStar()
    {
        $star = auth()->user()->balance->star ?? 0;
        $balance = auth()->user()->balance->balance ?? 0;
        $coin = UserCoin::where('app_user_id', auth()->id())->value('coin') ?? 0;
        $deposit = auth()->user()->deposit->sum('amount') ?? 0;
        $withdraw = auth()->user()->withdraw->sum('amount') ?? 0;
        return response()->json([
            'status' => true,
            'star' => $star,
            'balance' => $balance,
            'coin' => $coin,
            'deposit' => $deposit,
            'withdraw' => $withdraw,
        ]);
        // return view("AppUser::app-user-list");
    }
    public function apiMyReferral()
    {

        $users = AppUser::where('referral_id', auth()->user()->user_id)->get();
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
    public function apiMyReferralRequestChangeStatus(Request $request, $id)
    {
        $rules = [
            'status' => 'required|in:ACCEPT,REJECT',

        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        $r_request = AppUserReferralRequest::where(['requested_app_user_id' => auth()->id(), 'id' => $id])
            ->where('status', 1)->first();
        if (!$r_request) {
            return response()->json([
                'status' => false,
                'message' => 'Request not found.',
            ]);
        }

        if ($request->status == 'ACCEPT') {
            $total_ref = AppUser::where('referral_id', auth()->user()->user_id)->count();
            if ($total_ref >= 5) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have maximum referral user. You can not added more.',
                ]);
            }

            $user = AppUser::find($r_request->app_user_id);
            if ($user->referral_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'User already added on another user. Please reject this request.',
                ]);
            }
            $user->referral_id = auth()->user()->user_id;
            if ($user->update()) {
                $r_request->type = 'ACCEPT';
                $r_request->status = 0;
                $r_request->update();
            }
            return response()->json([
                'status' => true,
                'referral_users' => 'User added as your referral.',
            ]);
        }

        if ($request->status == 'REJECT') {

            $r_request->type = 'REJECT';
            $r_request->status = 0;
            $r_request->update();
            return response()->json([
                'status' => true,
                'referral_users' => 'User referral request canceled.',
            ]);
        }

        return response()->json([
            'status' => false,
            'referral_users' => 'Something went wrong.',
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

        return view('frontend.auth.reset-password')->with(
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

        return view('frontend.auth.reset-password-success')->with('status', 'Password has been reset.');
    }

    public function appUserLogin()
    {

        return view('frontend.auth.login');
    }

    public function appUserLoginStore(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|min:6',
        ]);
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'user_id';

        if (Auth::guard('appuser')->attempt([$loginField => $request->input('email'), 'password' => $request->input('password'), 'status' => 1])) {

            return redirect()->route('user.dashboard');
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
                    'referral_id',
                    'Referral user not found!'
                );
                return redirect()->back()->withInput()->withErrors($validate);
            }

            if ($ck_referral->user_type != 2) {
                $user_ref_ck = AppUser::where('referral_id', $request->referral_id)->get();
                $chk_value = Helper::get_config('max_referral_user') ?? 5;
                if (count($user_ref_ck) >= $chk_value) {
                    $validate->errors()->add(
                        'referral_id',
                        'Referral user over limit. Please use others referral code !'
                    );
                    return redirect()->back()->withInput()->withErrors($validate);
                }
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
                //User Coin Create
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
                //User Balance Create
                $balance = new AppUserBalance();
                $balance->app_user_id = $app_user->id;
                $balance->balance = 0;
                $balance->star = 0;
                if (!$balance->save()) {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }


            if ($transactionFail) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Something went wrong!');
            } else {

                DB::commit();
                return redirect()->route('user.login')->with('success', 'Registration successfully. Please Login.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
        //return view('frontend.auth.register');
    }
    public function appUserProfile()
    {
        // dd('profile');
        $user = auth()->user();
        // dd($user);
        return view('frontend.auth.profile', compact('user'));
    }
    public function appUserProfileUpdate(Request $request)
    {
        $request->validate([
            "mobile" => 'nullable|numeric',
            "photo" => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        $user = AppUser::find(auth()->id());
        $user->mobile = $request->mobile;

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '-' . auth()->id() . '.' . $image->getClientOriginalExtension();

            // Check if a previous photo exists and delete it
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $manager = new ImageManager(['driver' => 'imagick']);

            $image = $manager->make($image)->resize(200, 200);

            $img_path = 'images/profile/' . $filename;
            $path = Storage::disk('public')->put($img_path, (string) $image->encode()); // Store the resized image
            $user->photo = $img_path;
        }
        if ($user->save()) {
            return redirect()->back()->with('success', 'Profile Updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Something went wrong.');
        }
    }
    public function appUserDashboard()
    {
        // dd('profile');
        return view('frontend.dashboard');
    }
    public function appUserDeposit()
    {
        $methods = PaymentMethod::where('status', 1)->get();
        return view('frontend.deposit.deposit_page', compact('methods'));
    }
    public function appUserDepositHistory()
    {
        $deposits = DepositLog::where('app_user_id', auth()->id())->orderBy('status')->get();
        return view('frontend.deposit.deposit_history_page', compact('deposits'));
    }
    public function appUserDepositFinalSubmit(Request $request)
    {

        //  dd($request->all());
        $request->validate([
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
        } else {
            return redirect()->back()->with('error', 'Password is incorrect.');
        }

        $method = PaymentMethod::findOrFail($request->method);

        $amount = $request->amount;
        $charge =  ($request->amount / 1000) * $method->transaction_fee;
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
        if ($log->save()) {
            return redirect()->route('user.deposit.history')->with('success', 'Deposit request submited successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
    public function apiDepositStore(Request $request)
    {
        //  dd($request->all());

        $rules = [
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }


        if (Hash::check($request->password, auth()->user()->password)) {
        } else {
            return response()->json([
                'status' => false,
                'message' =>  'Password is incorrect.'
            ]);
            // return redirect()->back()->with('error', 'Password is incorrect.');
        }

        $method = PaymentMethod::findOrFail($request->method);

        $amount = $request->amount;
        $charge =  ($request->amount / 1000) * $method->transaction_fee;
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
        if ($log->save()) {
            return response()->json([
                'status' => true,
                'message' =>  'Deposit request submited successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' =>  'Something went wrong.'
            ]);
        }
    }


    public function apiDepositHistory()
    {

        $deposits = DepositLog::where('app_user_id', auth()->id())->orderBy('status')->get();
        return response(DepositHistoryResource::collection($deposits));
    }

    public function apiWithdrawStore(Request $request)
    {
        //  dd($request->all());

        $rules = [
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
            'account_no' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }


        if (Hash::check($request->password, auth()->user()->password)) {
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Password is incorrect.',
            ]);
        }

        $method = PaymentMethod::findOrFail($request->method);

        $amount = $request->amount;
        // $charge =  ($request->amount / 1000) * $method->transaction_fee;
        $charge =  0;
        $total = $amount + $charge;


        $transactionFail = false;
        DB::beginTransaction();



        $u_balance = AppUserBalance::where('app_user_id', auth()->id())->first();
        if (!$u_balance) {
            return response()->json([
                'status' => false,
                'message' => 'You dont have enough balance.',
            ]);
        }

        try {
            $log = new WithdrawLog();
            $log->payment_method_id = $method->id;
            $log->app_user_id = auth()->id();
            $log->withdraw_date = now();
            $log->amount = $amount;
            $log->charge = $charge;
            $log->total = $total;
            $log->account_no = $request->account_no;
            // $log->transaction_id = $request->transaction_id;
            $log->creator = 'user';
            $log->created_by = auth()->id();
            $log->status = 1;
            if ($log->save()) {
                $u_balance->balance -= $amount;
                if ($u_balance->update()) {
                    $app_user_balance_detail = new AppUserBalanceDetail();
                    $app_user_balance_detail->app_user_balance_id =  $u_balance->id;
                    $app_user_balance_detail->source = 'WITHDRAW';
                    $app_user_balance_detail->balance_type = 'SUB';
                    $app_user_balance_detail->balance = $amount;
                    $app_user_balance_detail->withdraw_log_id = $log->id;
                    if (!$app_user_balance_detail->save()) {
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
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Withdraw request submited successfully.',
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' =>  $th->getMessage(),
            ]);
        }
    }


    public function apiWithdrawHistory()
    {

        $deposits = WithdrawLog::where('app_user_id', auth()->id())->orderBy('status')->get();
        return response(WithdrawHistoryResource::collection($deposits));
    }





    public function appUserWithdrawHistory()
    {
        $withdraws = WithdrawLog::where('app_user_id', auth()->id())->orderBy('status')->get();

        return view('frontend.withdraw.withdraw_history_page', compact('withdraws'));
    }
    public function appUserDepositMethodSubmit(Request $request)
    {
        $request->validate([
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
            'transaction_fee' => 'required|numeric'
        ]);

        $method = PaymentMethod::findOrFail($request->method);
        $transaction_fee = ($request->amount / 1000) * $method->transaction_fee;
        $data = [
            'method' => $method,
            'amount' => $request->amount,
            'transaction_fee' => $transaction_fee
        ];
        return view('frontend.deposit.deposit_final_page')->with($data);
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
        $methods = PaymentMethod::where('status', 1)->get();
        return view('frontend.withdraw.withdraw_page', compact('methods'));
    }

    public function appUserWithdrawMethodSubmit(Request $request)
    {
        $request->validate([
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
            'transaction_fee' => 'required|numeric'
        ]);


        // dd($request->all());
        if (!isset(auth()->user()->balance) || (auth()->user()->balance->balance < $request->amount)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough balance.');
        }

        if (!isset(auth()->user()->balance->star) || (auth()->user()->balance->star < 1)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough star for withdraw. Please buy star first.');
        }

        $withdraw_limit = Helper::get_star_withdraw_limit(auth()->user()->balance->star);

        $total_withdraw = auth()->user()->withdraw->sum('amount');
        if ($withdraw_limit < ($total_withdraw + $request->amount)) {
            return redirect()->back()->withInput()->with('error', "Your withdraw limit is {$withdraw_limit}. Please buy star for increment withdraw limit.");
        }


        $method = PaymentMethod::findOrFail($request->method);
        $transaction_fee = ($request->amount / 1000) * $method->transaction_fee;
        $transaction_fee = 0;
        $data = [
            'method' => $method,
            'amount' => $request->amount,
            'transaction_fee' => $transaction_fee
        ];
        return view('frontend.withdraw.withdraw_final_page')->with($data);
    }
    public function appUserWithdrawFinalSubmit(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
            'account_no' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
        } else {
            return redirect()->back()->with('error', 'Password is incorrect.');
        }

        $method = PaymentMethod::findOrFail($request->method);

        $amount = $request->amount;
        // $charge =  ($request->amount / 1000) * $method->transaction_fee;
        $charge =  0;
        $total = $amount + $charge;


        $transactionFail = false;
        DB::beginTransaction();



        $u_balance = AppUserBalance::where('app_user_id', auth()->id())->first();
        if (!$u_balance) {

            return redirect()->back()->with('error', 'You dont have enough balance.');
        }

        try {
            $log = new WithdrawLog();
            $log->payment_method_id = $method->id;
            $log->app_user_id = auth()->id();
            $log->withdraw_date = now();
            $log->amount = $amount;
            $log->charge = $charge;
            $log->total = $total;
            $log->account_no = $request->account_no;
            // $log->transaction_id = $request->transaction_id;
            $log->creator = 'user';
            $log->created_by = auth()->id();
            $log->status = 1;
            if ($log->save()) {
                $u_balance->balance -= $amount;
                if ($u_balance->update()) {
                    $app_user_balance_detail = new AppUserBalanceDetail();
                    $app_user_balance_detail->app_user_balance_id =  $u_balance->id;
                    $app_user_balance_detail->source = 'WITHDRAW';
                    $app_user_balance_detail->balance_type = 'SUB';
                    $app_user_balance_detail->balance = $amount;
                    $app_user_balance_detail->withdraw_log_id = $log->id;
                    if (!$app_user_balance_detail->save()) {
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
                return redirect()->back()->with('error', 'Something went wrong.');
            } else {
                DB::commit();
                return redirect()->route('user.withdraw.history')->with('success', 'Withdraw request submited successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function appUserChangePassword()
    {
        return view('frontend.auth.change_password');
    }
    public function appUserChangePasswordAction(Request $request)
    {

        $request->validate([
            "present_password" => 'required|string',
            "password" =>  'required|string|confirmed|min:6|max:20',
        ]);
        // dd(Auth::user());

        // Check if the current password matches the one stored in the database
        if (!Hash::check($request->present_password, Auth::user()->password)) {
            return back()->withErrors(['present_password' => 'Present password does not match']);
        }

        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Password changed successfully!');
    }

    public function appUserReferralRequest()
    {


        $r_requests = AppUserReferralRequest::where('requested_app_user_id', auth()->id())->where('status', 1)->get();
        $total_ref = AppUser::where('referral_id', auth()->user()->user_id)->count();

        return view('frontend.referral.request', compact('r_requests', 'total_ref'));
    }
    public function appUserReferralRequestAccept($id)
    {
        $r_request = AppUserReferralRequest::where(['requested_app_user_id' => auth()->id(), 'id' => $id])
            ->where('status', 1)->first();
        if (!$r_request) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
        if (auth()->user()->user_type != 2) {
            $total_ref = AppUser::where('referral_id', auth()->user()->user_id)->count();
            if ($total_ref >= 5) {
                return redirect()->back()->with('error', 'You have maximum referral user. You can not added more.');
            }
        }
        $user = AppUser::find($r_request->app_user_id);
        if ($user->referral_id) {
            return redirect()->back()->with('error', 'User already added on another user. Please reject this request.');
        }
        $user->referral_id = auth()->user()->user_id;
        if ($user->update()) {
            $r_request->type = 'ACCEPT';
            $r_request->status = 0;
            $r_request->update();
        }
        return redirect()->back()->with('success', 'User added as your referral.');
    }
    public function appUserReferralRequestCancel($id)
    {
        $r_request = AppUserReferralRequest::where(['requested_app_user_id' => auth()->id(), 'id' => $id])
            ->where('status', 1)->first();
        if (!$r_request) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $r_request->type = 'REJECT';
        $r_request->status = 0;
        $r_request->update();

        return redirect()->back()->with('success', 'User referral request canceled.');
    }
    public function appUserReferralMemberList()
    {
        $users = AppUser::where('referral_id', auth()->user()->user_id)->get();

        return view('frontend.referral.member_list', compact('users'));
    }
    public function appUserReferralMemberDetail($id)
    {
        $user = AppUser::find($id);
        $users = AppUser::where('referral_id', $user->user_id)->get();

        return view('frontend.referral.member_list', compact('users'));
    }
    public function appUserAddYouself()
    {
        if (auth()->user()->referral_id) {
            return redirect()->back()->with('error', 'You can\'t add you referral.');
        }
        return view('frontend.referral.add_yourself');
    }
    public function appUserAddYouselfStore(Request $request)
    {

        $request->validate([
            'user_id' => 'required|numeric'
        ]);

        $ck_user = AppUser::where('user_id', $request->user_id)->first();
        if (!$ck_user) {
            return redirect()->back()->withInput()->with('error', 'User not found.');
        }


        if ($ck_user->id == auth()->id()) {
            return redirect()->back()->withInput()->with('error', 'You can\'t add yourself.');
        }

        $r_users_ck = AppUser::where('referral_id', $ck_user->user_id)->count();
        $max_count = Helper::get_config('max_referral_user') ?? 0;
        if ($r_users_ck >= $max_count) {
            return redirect()->back()->withInput()->with('error', 'This user already have maximum referral user.');
        }

        $ids =  Helper::get_all_referral_user_ids();
        if (in_array($request->user_id, $ids)) {
            return redirect()->back()->withInput()->with('error', 'You can not add this user.');
        }

        $data = new AppUserReferralRequest();
        $data->app_user_id = auth()->id();
        $data->requested_app_user_id = $ck_user->id;
        $data->status = 1;
        if ($data->save()) {
            return redirect()->route('user.member_list')->with('success', 'Referral request success. Please wait for approve.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
    public function appUserRoutingList()
    {


        return view('frontend.website.routing_list');
    }
    public function appUserWebVisitingList()
    {

        $website_visit_logs = OwnWebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => auth()->id()])->pluck('own_website_id');
        // dd($website_visit_logs);
        $websites = OwnWebsite::where('status', 1)->whereNotIn('id', $website_visit_logs)->get();
        // dd($websites);
        return view('frontend.website.web_visiting_list', compact('websites'));
    }
    public function appUserWebsiteList()
    {

        $website_visit_logs = WebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => auth()->id()])->pluck('website_id');
        // dd($website_visit_logs);
        $websites = Website::where('status', 1)->whereNotIn('id', $website_visit_logs)->get();


        return view('frontend.website.website_list', compact('websites'));
    }
    public function apiOwnWebsiteList()
    {
        $website_visit_logs = OwnWebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => auth()->id()])->pluck('own_website_id');
        // dd($website_visit_logs);
        $websites = OwnWebsite::where('status', 1)->whereNotIn('id', $website_visit_logs)->get();
        // dd($websites);
        // return view('frontend.website.web_visiting_list', compact('websites'));
        return response([
            'status' => true,
            'datas' => OwnWebsiteResourse::collection($websites)
        ]);
    }
    public function apiRoutingWebsiteList()
    {
        $website_visit_logs = WebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => auth()->id()])->pluck('website_id');
        // dd($website_visit_logs);
        $websites = Website::where('status', 1)->whereNotIn('id', $website_visit_logs)->get();

        return response([
            'status' => true,
            'datas' => $websites
        ]);
    }
    public function appUserWebsiteVisitCount(Website $website)
    {

        $website_visit_log = WebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => auth()->id(), 'website_id' => $website->id])
            ->first();
        if ($website_visit_log) {
            $message = 'This website not available for today.';
        } else {


            $transactionFail = false;

            DB::beginTransaction();

            try {

                $website_visit_log_store = new WebsiteVisitLog();
                $website_visit_log_store->website_id = $website->id;
                $website_visit_log_store->app_user_id = auth()->id();
                $website_visit_log_store->date = now();
                $website_visit_log_store->coin = $website->coin;
                if ($website_visit_log_store->save()) {
                    $user_coin = UserCoin::where('app_user_id', auth()->id())->first();
                    if (!$user_coin) {
                        $user_coin = new UserCoin();
                        $user_coin->app_user_id = auth()->id();
                        $user_coin->coin = $website->coin;
                    } else {
                        $user_coin->coin += $website->coin;
                    }
                    if ($user_coin->save()) {
                        $u_c_details = new UserCoinDetail();
                        $u_c_details->source = 'WEBSITE';
                        $u_c_details->coin_type = 'ADD';
                        $u_c_details->user_coin_id = $user_coin->id;
                        $u_c_details->website_id = $website->id;
                        $u_c_details->coin = $website->coin;
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

                    $message = 'Something went wrong.';
                } else {
                    DB::commit();
                    $message = 'Website visit success. Coin added on your account.';
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                $message = $th->getMessage();
            }
        }

        return redirect()->route('user.website_list')->with('success', $message);
    }
    public function appUserWebVisitCount(Request $request, OwnWebsite $website)
    {
        $rules = [
            "other_user" => 'required|numeric',
            "other_visiting_id" =>  'required|numeric',
            "other_url" => 'required|string',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first()
            ]);
        }

        $user = AppUser::find($request->other_user);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ]);
        }

        if ($request->other_user && $request->other_visiting_id) {
            $transactionFail = false;
            DB::beginTransaction();
            try {
                $web_visit_log = OwnWebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => $request->other_user, 'own_website_id' => $request->other_visiting_id])
                    ->first();

                if ($web_visit_log) {
                    $message = 'This coin already avail today. Please try Tomorrow';

                    return response()->json([
                        'status' => false,
                        'message' => $message
                    ]);
                } else {

                    $website_visit_log_store = new OwnWebsiteVisitLog();
                    $website_visit_log_store->own_website_id = $website->id;
                    $website_visit_log_store->app_user_id = $user->id;
                    $website_visit_log_store->date = now();
                    $website_visit_log_store->coin = $website->coin;
                    if ($website_visit_log_store->save()) {
                        $user_coin = UserCoin::where('app_user_id', $user->id)->first();
                        if (!$user_coin) {
                            $user_coin = new UserCoin();
                            $user_coin->app_user_id = $user->id;
                            $user_coin->coin = $website->coin;
                        } else {
                            $user_coin->coin += $website->coin;
                        }
                        if ($user_coin->save()) {
                            $u_c_details = new UserCoinDetail();
                            $u_c_details->source = 'OWNWEBSITE';
                            $u_c_details->coin_type = 'ADD';
                            $u_c_details->user_coin_id = $user_coin->id;
                            $u_c_details->own_website_id = $website->id;
                            $u_c_details->coin = $website->coin;
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

                        $message = 'Something went wrong.';
                        return response()->json([
                            'status' => false,
                            'message' => $message
                        ]);
                    } else {
                        DB::commit();
                        $message = 'Website visit success. Coin added on your account.';
                        return response()->json([
                            'status' => true,
                            'message' => $message
                        ]);
                    }
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                $message = $th->getMessage();
                return response()->json([
                    'status' => false,
                    'message' => $message
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Somehing went wrong.'
            ]);
        }





        dd($request->all());
        // $website_visit_log = WebsiteVisitLog::where(['date' => now()->format('Y-m-d'), 'app_user_id' => auth()->id(), 'website_id' => $website->id])
        // ->first();

    }

    public function appUserTransferType()
    {

        return view('frontend.transfer.transfer_type');
    }

    public function appUserIncome()
    {


        // $gains = LevelIncomeLog::where(['type'=>'GAIN','app_user_id'=>auth()->id()])->orderBy('level_number')->get()->groupBy('level_number');
        // $losses = LevelIncomeLog::where(['type'=>'LOSS','app_user_id'=>auth()->id()])->orderBy('level_number')->get()->groupBy('level_number');
        // dd($gains,$losses);
        return view('frontend.income.income');
    }

    public function getUserByUserId(Request $request)
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

        $app_user = AppUser::where('user_id', $request->user_id)->first();
        if ($app_user) {
            return response()->json([
                'status' => true,
                'data' => $app_user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ]);
        }
    }
    public function getUserByUserIdForAddYourself(Request $request)
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

        $app_user = AppUser::where('user_id', $request->user_id)->first();
        if ($app_user) {
            return response()->json([
                'status' => true,
                'data' => $app_user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ]);
        }
    }

    public function appUserSupport()
    {
        return view('frontend.user_support');
    }
    public function apiUserMemberCountByLevel()
    {
        $user_ids = [auth()->user()->user_id];
        $data = [];
        // for ($i = 1; $i <= 10; $i++) {
        //     if (count($user_ids) > 0) {
        //         $users = AppUser::whereIn('referral_id', $user_ids)->pluck('user_id');
        //         $arr = [
        //             'level' => $i,
        //             'total' => count($users),
        //         ];
        //         array_push($data, $arr);
        //         $user_ids = $users;
        //     } else {
        //         $arr = [
        //             'level' => $i,
        //             'total' => 0,
        //         ];
        //         array_push($data, $arr);
        //         $user_ids = [];
        //     }
        // }
        $i = 1;
        while (count($user_ids) != 0) {
            if (count($user_ids) > 0) {
                $users = AppUser::whereIn('referral_id', $user_ids)->pluck('user_id');
                $arr = [
                    'level' => $i,
                    'total' => count($users),
                ];
                array_push($data, $arr);
                $user_ids = $users;
                $i++;
            } else {
                $arr = [
                    'level' => $i,
                    'total' => 0,
                ];
                array_push($data, $arr);
                $user_ids = [];
                $i++;
            }
        }
        return response([
            'status' => true,
            'data' => $data
        ]);
    }
    public function apiGetUserById(Request $request)
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

        $app_user = AppUser::where('user_id', $request->user_id)->first();
        if ($app_user) {
            return response()->json([
                'status' => true,
                'data' => new AppUserResource($app_user),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ]);
        }
    }
}
