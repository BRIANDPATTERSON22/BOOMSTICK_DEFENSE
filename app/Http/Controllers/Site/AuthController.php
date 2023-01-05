<?php namespace App\Http\Controllers\Site;

use App\Country;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\ForgetRequest;
use App\Http\Requests\Site\LoginRequest;
use App\Http\Requests\Site\RegisterRequest;
use App\Http\Requests\Site\ResetRequest;
use App\Subscribe;
use App\User;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function __construct(User $user, Customer $customer, Country $country, Permission $permission, Role $role, Subscribe $subscribe)
    {
        $this->module = "auth";
        $this->user = $user;
        $this->country = $country;
        $this->customer = $customer;
        $this->permission = $permission;
        $this->role = $role;
        $this->subscribe = $subscribe;

        $this->option = Cache::get('optionCache');
    }

    public function get_login()
    {
        $module = $this->module;

        if(Auth::check()){
            if (Auth::user()->hasRole(['admin', 'sales_person', 'store_manager'])) {
                return redirect('admin/dashboard');
            } else {
                return redirect('my-account');
            }
        }
        return view('site.'.$module.'.login');
    }

    public function post_login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->login_email,
            'password' => $request->login_pass,
        ];

        if (Auth::attempt($credentials)) {

            if(Auth::user()->is_verified == 0){
                Auth::logout();
                return redirect()->back()->with('error', 'Account activation failed.');
            }

            if(Auth::user()->status == 0) {
                Auth::logout();
                return redirect()->back()->with('error', 'Your account has been disabled. Please contact us.');
            }

            if (Auth::user()->hasRole(['super-admin', 'admin', 'manager'])) {
                return redirect('admin/dashboard')->with('success', 'Hello '.Auth::user()->name.' !');
            }elseif(Auth::user()->hasRole('customer')){
                return redirect('cart')->with('success', 'Hello, '.Auth::user()->name.'. you have been successfully logged in.');
            }else{
                Auth::logout();
                return redirect()->back()->with('error', 'Permission Denied!');
            }
            
        }else{
            return redirect()->back()->with('error', 'Invalid Username (Email) or Password.');
        }
    }

    public function get_register()
    {
        if(Auth::check()){
            return redirect('/');
        }
        $module = $this->module;
        $phoneCounties = Country::all();

        return view('site.'.$module.'.register', compact('phoneCounties'));
    }

    public function post_register(RegisterRequest $request)
    {
        try {
            $randString = $this->generateRandomString(75);

            //Create user
            // $this->user->role_id = 3;
            $this->user->name = $request->first_name.' '.$request->last_name;
            $this->user->email = strtolower($request->email);
            // $this->user->password = Hash::make($request->password);
            $this->user->password = bcrypt($request->password);
            $this->user->is_verified  = 1;
            $this->user->status = 1;
            // $this->user->verification_token  = $randString;
            // $this->user->verification_token  = $randString;
            // $this->user->is_agreed_terms_and_conditions  = 1;
            // $request->is_subscribed == 1 ? $this->user->is_subscribed  = 1 :  $this->user->is_subscribed  = 0;
            $this->user->ip  = $request->getClientIp(); // Registered IP Address
            $this->user->save();
            $userId = $this->user->id; //Get last save id

            //Assign role
            DB::table('model_has_roles')->insert(['role_id' => '3','model_id' =>  $userId, 'model_type'=>'App\User']);

            //Insert customer
            $this->customer->fill($request->all());
            $this->customer->uuid = Str::uuid();
            $this->customer->user_id = $userId;
            $this->customer->role_id = 3;
            $this->customer->email = strtolower($request->email);
            $this->customer->registration_type = 2;
            $this->customer->status = 1;
            $this->customer->save();

            // Save Subscription
            // if ($request->is_subscribed == 1) {
            //     $this->subscribe->name = $request->first_name.' '.$request->last_name;
            //     $this->subscribe->email = strtolower($request->email);
            //     $this->subscribe->user_id = $userId;
            //     $this->subscribe->save();
            // }

            // // Send Verification Link
            // $option = $this->option;
            // $siteEmail = $option->email;
            // $siteName = $option->name;

            // $data = [
            //     'name' => $request->first_name.' '.$request->last_name,
            //     'email' => $request->email,
            //     'url' => $randString,
            //     'siteEmail' => $siteEmail,
            //     'siteName' => $siteName
            // ];

            // Mail::send('emails.user.account_verification', $data, function($message) use ($data) {
            //     $message
            //         ->to($data['email'], $data['name'])
            //         ->subject('Welcome to '.$data['siteName'].' Please verify your email.');
            // });

            return redirect('login')->with('success', 'Thanks for signing up!');
            // return redirect('login')->with('success', 'Thanks for signing up! An email has been sent to you with instructions for verifying your account.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get_forgot_password()
    {
        $module = $this->module;

        return view('site.'.$module.'.forgot');
    }

    public function post_forgot_password(ForgetRequest $request)
    {
        $email = $request->email;
        $user = $this->user->where('email', $email)->first();

        if($user)
        {
            $siteEmail = $this->option->email;
            $siteName = $this->option->name;

            $link = str_slug(Hash::make($email));
            $dumb = ['id'=> $link, 'email'=>$email];

            Session::put('resetSession', $dumb);

            $data = [
                'name' => $user->name,
                'email' => $email,
                'link' => $link,
                'siteEmail' => $siteEmail,
                'siteName' => $siteName
            ];

            Mail::send('emails.user.password', $data, function ($message) use ($data) {
                $message
                    ->to($data['email'], $data['name'])
                    ->subject('Forgot Password - ' . $data['siteName']);
            });

            return redirect()->back()->with('success', 'Dear '.$user->name.', we have sent you a email to reset your password.');
        }
        else{
            return redirect()->back()->with('error', 'The email not associated with our system.');
        }
    }

    public function get_forgot_reset($hash)
    {
        $module = $this->module;
        
        $dumb_data = session('resetSession');
        if($hash == $dumb_data['id']) {
            Session::forget('verified');
            Auth::logout();
            return view('site.'.$module.'.reset');
        }

        return redirect('forgot-password')->with('error', 'Session expired, Try again.');
    }

    public function post_forgot_reset(ResetRequest $request, $hash)
    {
        if(session('resetSession')) {
            $dumb = session('resetSession');

            $this->user = $this->user->where('email', $dumb['email'])->first();
            $this->user->password = Hash::make($request->password);
            $this->user->save();

            Session::forget('resetSession');
            return redirect('login')->with('success', 'Dear ' . $this->user->name . ', your password has been successfully rested.');
        }
        else{
            return redirect('forgot-password')->with('error', 'Session expired, Try again');
        }
    }


    public function get_logout()
    {
        Cart::instance('cart')->destroy();
        Cart::instance('wish')->destroy();
        Auth::logout();
        Session()->flush();
        return redirect('/');
    }


    //Email verification
    public function get_validate($token)
    {
        $data = $this->user->where('verification_token', $token)->first();
        $verifiedToken = $this->user->where('verified_token', $token)->first();

        if($data){
            $data->verified = 1;
            $data->verification_token = null;
            $data->verified_token = $token;
            $data->save();
            // return redirect('login')->with('success', 'Hello '.$data->name.', your email has been verified. Log-in here to continue!');
            if ($data->hasRole('trade_customer')) {
                return redirect('login')->with('success', 'Hello '.$data->name.', Thank you for your interest in opening a trade account. Your email has been successfully Verified. You will be notified by email, once your trade account has been setup.');
            }else{
                return redirect('login')->with('success', 'Hello '.$data->name.', Your email has been successfully verified. Please login with your username (email) and Password to get started.');
            }

        }
        elseif($verifiedToken){
            return redirect('login')->with('success', 'Your account has already been verified. Please login to continue.');
        }
        else{
            return view('site.errors.404');
        }
    }


    ////
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Send Verification mail
    public function send_verfication_email(array $data)
    {
        // Send Verification Link
        Mail::send('emails.user.account_verification', $data, function($message) use ($data) {
            $message
                ->to($data['email'], $data['name'])
                ->subject('Account Verification - '.$data['siteName']);
        });
    }
}