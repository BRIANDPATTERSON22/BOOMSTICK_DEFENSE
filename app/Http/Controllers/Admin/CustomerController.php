<?php namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Auth;
use App\User;
use App\Country;
use App\Customer;
use App\Order;
use App\Payment;
use App\CustomerPaymentMethod;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use DateTime;

class CustomerController extends Controller
{
    public function __construct(Customer $customer, User $user, Order $order, Payment $payment, CustomerPaymentMethod $customerPaymentMethod)
    {
        $this->module = "customer";
        $this->data = $customer;
        $this->order = $order;
        $this->user = $user;
        $this->payment = $payment;
        $this->customerPaymentMethod = $customerPaymentMethod;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index($type)
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();
        $paymentMethods = $this->payment->where('status', 1)->get();

        $year = date('Y');
        // $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        Session::put('customerType', $type);
        if ($type == "all") {
            $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        } elseif($type == "normal-customers") {
            $allData = $this->data->where('role_id', 2)->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        }elseif ($type == "wholesale") {
            $allData = $this->data->where('role_id', 3)->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        }elseif($type == "trash"){
            $allData = $this->data->onlyTrashed()->get();
        }else{
            $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        }

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year', 'paymentMethods'));
    }

    public function get_archive($type, $year)
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        // $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        Session::put('customerType', $type);
        if ($type == "all") {
            $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        } elseif($type == "normal-customers") {
            $allData = $this->data->where('role_id', 2)->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        }elseif ($type == "wholesale") {
            $allData = $this->data->where('role_id', 3)->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        }elseif($type == "trash"){
            $allData = $this->data->onlyTrashed()->get();
        }else{
            $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();
        }
        
        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_trash()
    {
        $module = $this->module;
        $allData = $this->data->onlyTrashed()->get();

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }


    public function get_add()
    {
        $module = $this->module;
        $singleData = $this->data;
        $countries = Country::pluck('nicename', 'id');

        return view('admin.'.$module.'.add_edit', compact('singleData', 'module', 'countries'));
    }

    public function post_add(CustomerRequest $request)
    {
        $module = $this->module;

        $filename = null;
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());
        $this->data->image = $filename;
        $this->data->status = 1;
        $this->data->save();

        $dataId = $this->data->id;
        $sessionMsg = $this->data->first_name." ".$this->data->last_name;
        return redirect('admin/'.$module.'/'.$dataId.'/view')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $module = $this->module;
        $singleData = $this->data->find($id);
        $countries = Country::pluck('nicename', 'id');
        $paymentMethods = $this->payment->where('status', 1)->get();

        $oldPayments = $this->customerPaymentMethod->where('customer_id', $id)->pluck('payment_id')->toArray();
        $singleData->payments_id = $oldPayments;

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module', 'countries', 'paymentMethods'));
    }

    public function post_edit(customerRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);
        $oldFilename = $filename = $this->data->image;
        $this->data->fill($request->all());
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $request->is_same_as_billing == 1 ? $this->data->is_same_as_billing = 1 : $this->data->is_same_as_billing = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.$oldFilename);
        }

        $this->data->image = $filename;
        $this->data->save();

        //Payment methods
        $oldCategories = $this->customerPaymentMethod->where('customer_id', $id)->pluck('payment_id')->toArray();

        $availableCategories = null;
        if($request->payments_id) {
            foreach ($request->payments_id as $newCat) {
                if (!in_array($newCat, $oldCategories)) {
                    $availableCategories[] = [
                        'customer_id' => $id,
                        'payment_id' => $newCat,
                        'status' => 1,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                } else {
                    $key = array_search($newCat, $oldCategories);
                    unset($oldCategories[$key]);
                }
            }
        }
        if($availableCategories) {
            $this->customerPaymentMethod->insert($availableCategories);
        }
        //Delete old categories
        $this->customerPaymentMethod->whereIn('payment_id', $oldCategories)->where('customer_id', $id)->delete();

        $sessionMsg = $this->data->title;
        // return redirect('admin/'.$module.'/'.$id.'/view')->with('success', 'Data '.$sessionMsg.' has been updated');
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_view($id)
    {
        $module = $this->module;
        $singleData = $this->data->find($id);
        $orderedData = $this->order->where('customer_id', $id)->get();

        return view('admin.'.$module.'.view',compact('singleData', 'module', 'orderedData'));
    }

    public function image_delete($id)
    {
        $module = $this->module;

        $data = $this->data->find($id);
        if($data) {
            Storage::delete($module.'s/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function soft_delete($id)
    {
        // try {
        //     HistoryResort::where('source_id', $id)->delete();
        //     return redirect()->back()->with('success', 'The resort full history has been successfully deleted');

        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }

        $module = $this->module;
        $data = $this->order->where('customer_id', $id)->get();

        if (count($data) > 0) {
            return redirect()->back()->with('error', 'Your data has not been moved to trash. You can not delete already ordered customer. Please delete related customer orders First.');
        }else{
            $this->data->find($id)->delete();
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        $module = $this->module;
        $data = $this->data->where('id', $id)->withTrashed()->first();
        if($data) {
            if($data->user_id){
                $this->user->find($data->user_id)->delete();
                DB::table('model_has_roles')->where('model_id', $data->user_id)->delete();
            }
            
            // Force Delete Customer
            if($data->image)
                Storage::delete($module.'s/'.$data->image);
            $data->forceDelete();

            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }

    //// Create/Edit user login
    public function post_login(Request $request, $cid)
    {
        $data = $this->data->find($cid);

        if($data->user_id) {
            $validationRule = [
                'email' => 'required|email|unique:users,email,'.$data->user_id,
                'password' => 'min:6|confirmed|required',
            ];
            $validation = Validator::make($request->all(), $validationRule);
            if ($validation->passes()) {
                $this->user = $this->user->find($data->user_id);
                $this->user->fill($request->all());
                $this->user->name = $data->first_name .' '. $data->first_name;
                $this->user->password = Hash::make($request->password);
                $this->user->save();
            }
            return redirect()->back()->with('success', 'The customer account password has been updated.');
        }
        else{
            $validationRule = [
                'email' => 'required|email|unique:users,email',
                'password' => 'min:6|confirmed|required',
            ];
            $validation = Validator::make($request->all(), $validationRule);
            if ($validation->passes()) {
                $this->user->fill($request->all());
                $this->user->name =  $data->first_name .' '. $data->first_name;
                $this->user->password = Hash::make($request->password);
                $this->user->save();
                $userId = $this->user->id;
                //Assign Role
                $this->data->assignRole(2);
                //Assign to parent
                $this->data = $data;
                $this->data->user_id = $userId;
                $this->data->save();
            }
            return redirect()->back()->with('success', 'The login has been created.');
        }
    }
    public function mystatus(Request $request)
    {
        // dd($request->all());
        $data = $request->id;

        $userId= DB::table('customers')
            ->where('id', $data)->first()->user_id;

        $status= DB::table('users')
            ->where('id', $userId)->first()->status;
            // dd(    $status);

        if($status==1)
        {
            DB::table('users')
                ->where('id', $userId)
                ->update(['status' => 0]);
        }
        else{
            DB::table('users')
                ->where('id', $userId)
                ->update(['status' => 1]);
        }
        return json_encode($data);

    }

    public function post_payment_method(Request $request , $cid)
    {
        $module = $this->module;
        //Payment Methods
        $availableCategories = null;
        if($request->payments_id) {
            foreach ($request->payments_id as $addCat) {
                $availableCategories[] = [
                    'customer_id' => $cid,
                    'payment_id' => $addCat,
                    'status' => 1,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }
        if($availableCategories) {
            $this->customerPaymentMethod->insert($availableCategories);
        }
        return redirect()->back()->with('success', 'Payment methods added.');
    }
    
    public function resend_verification_email($cid)
    {
        $customer = $this->data->whereId($cid)->first();
        $verificationToken = $customer->user->verification_token;
        // dd($verificationToken);
        // $randString = $this->generateRandomString(75);
        $randString = $verificationToken;

        // Send Verification Link
        $option = $this->option;
        $siteEmail = $option->email;
        $siteName = $option->name;

        $data = [
            'name' => $customer->first_name.' '.$customer->last_name,
            'email' => $customer->user->email,
            'url' => $randString,
            'siteEmail' => $siteEmail,
            'siteName' => $siteName
        ];

        if ($customer->user->hasRole(['trade_customer'])) {
            Mail::send('emails.user.account_verification', $data, function($message) use ($data) {
                $message
                    ->to($data['email'], $data['name'])
                    ->subject('Welcome to '.$data['siteName'].' Please verify your trade account email.');
            });
        }elseif ($customer->user->hasRole(['cake_time_club'])) {
            Mail::send('emails.user.account_verification', $data, function($message) use ($data) {
                $message
                    ->to($data['email'], $data['name'])
                    ->subject('Welcome to '.$data['siteName'].' Please verify your CakeTime Club account email.');
            });
        }else{
            Mail::send('emails.user.account_verification', $data, function($message) use ($data) {
                $message
                    ->to($data['email'], $data['name'])
                    ->subject('Welcome to '.$data['siteName'].' Please verify your email.');
            });
        }

        return redirect()->back()->with('success', 'An email has been sent to '. $customer->user->email .'.');
    }
    
}