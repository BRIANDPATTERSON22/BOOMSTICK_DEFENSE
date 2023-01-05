<?php namespace App\Http\Controllers\Admin;

use App\Country;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\Admin\OrdersItemRequest;
use App\Option;
use App\Order;
use App\OrderItem;
use App\Product;
use App\SalesPersonHasStore;
use App\StoreManagerHasStore;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;

class OrderController extends Controller
{
    public function __construct(Order $order, OrderItem $orderItem, Product $product, Customer $customer, StoreManagerHasStore $storeManagerHasStore, SalesPersonHasStore $salesPersonHasStore)
    {
        $this->module = "order";
        $this->data = $order;
        $this->orderItem = $orderItem;
        $this->product = $product;
        $this->customer = $customer;
        $this->storeManagerHasStore = $storeManagerHasStore;
        $this->salesPersonHasStore = $salesPersonHasStore;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $year = date('Y');
        // $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('customer')->get();

        if (Auth::user()->hasRole(['store_manager'])) {
            $storeManagerIds = Auth::user()->storeManager->id;

            $storeIds = $this->storeManagerHasStore->where('store_manager_id', $storeManagerIds)->pluck('store_id');

            $orderIdsInOrderItems = $this->orderItem->whereIn('store_id', $storeIds)->pluck('order_id');

            $allData = $this->data
                ->where('created_at', 'like', $year.'%')
                ->whereIn('id', $orderIdsInOrderItems)
                ->orderBy('id', 'DESC')
                ->with('customer')
                ->get();
        }elseif(Auth::user()->hasRole(['sales_person'])){
            $salesPersonIds = Auth::user()->salesPerson->id;
            
            $storeIds = $this->salesPersonHasStore->where('sales_person_id', $salesPersonIds)->pluck('store_id');

            $orderIdsInOrderItems = $this->orderItem->whereIn('store_id', $storeIds)->pluck('order_id');

            $allData = $this->data
                ->where('created_at', 'like', $year.'%')
                ->whereIn('id', $orderIdsInOrderItems)
                ->orderBy('id', 'DESC')
                ->with('customer')
                ->get();
        }else{
            $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('customer')->get();
        }

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('customer')->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_trash()
    {
        $module = $this->module;
        $allData = $this->data->onlyTrashed()->get();
        $deleteCount = $this->data->onlyTrashed()->count();

        return view('admin.'.$module.'.index', compact('allData', 'module','deleteCount'));
    }

    public function mark_start_processing($id)
    {
        $this->data = $this->data->find($id);
        $this->data->status = 4;
        $this->data->save();

        return redirect()->back()->with('success', 'The order mark as process stated');
    }

    public function mark_paid($id)
    {
        $this->data = $this->data->find($id);
        $this->data->pay_status = 'PAID';
        $this->data->save();
        return redirect()->back()->with('success', 'The order marked as paid');
    }

    public function mark_as_dispatched($id)
    {
        $this->data = $this->data->find($id);
        $this->data->status = 5;
        $this->data->save();

        // Email to Customer
        $order = $this->data->find($id);
        $orderItems = $this->orderItem->where('order_id', $id)->get();
        $option = Option::first();
        $data = [
            'name' => $order->customer->first_name . ' ' . $order->customer->last_name,
            'email' => $order->customer->email,
            'siteEmail' => $option->email,
            'siteName' => $option->name,
        ];
        Mail::send('emails.order.dispatched', compact('order', 'orderItems'), function ($message) use ($data) {
            $message->to($data['email'])->subject(' Dispatch Confirmation - ' . $data['siteName']);
        });
        return redirect()->back()->with('success', 'The order mark as dispatched');
    }

    public function mark_delivered($id)
    {
        $orderItems = $this->orderItem->where('order_id', $id)->get();
        foreach ($orderItems as $row){
            $this->product = $this->product->find($row->product_id);
            $this->product->quantity = $this->product->quantity - $row->quantity;
            $this->product->save();
        }
        $this->data = $this->data->find($id);
        $this->data->status = 6;
        $this->data->save();

        return redirect()->back()->with('success', 'The order marked as delivered and the quantity reduced from the product');
    }

    public function get_view($id)
    {
        $module = $this->module;
        $singleData = $this->data->find($id);
        // $orderItems = $this->orderItem->where('order_id', $id)->get();
        
        if (Auth::user()->hasRole(['store_manager'])) {
            $storeManagerId = Auth::user()->storeManager->id;
            $storeIds = $this->storeManagerHasStore->where('store_manager_id', $storeManagerId)->pluck('store_id');
            $orderItems = $this->orderItem->where('order_id', $id)->whereIn('store_id', $storeIds)->get();
        }elseif(Auth::user()->hasRole(['sales_person'])){
            $salesPersonId = Auth::user()->salesPerson->id;
            $storeIds = $this->salesPersonHasStore->where('sales_person_id', $salesPersonId)->pluck('store_id');
            $orderItems = $this->orderItem->where('order_id', $id)->whereIn('store_id', $storeIds)->get();
        }else{
            $orderItems = $this->orderItem->where('order_id', $id)->get();
        }

        $allProducts = $this->product->where('status', 1)->pluck('title', 'id');
        // 
        $countries = Country::pluck('nicename', 'id');
        return view('admin.'.$module.'.view',compact('singleData', 'module', 'orderItems','countries','allProducts'));
    }

    public function soft_delete($id)
    {
        if($this->data->find($id)->delete()) {
        	$this->orderItem->where('order_id', $id)->delete();
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore()) {
        	$this->orderItem->where('order_id', $id)->restore();
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        $data = $this->data->where('id', $id)->withTrashed()->first();
        if($data) {
             $data->forceDelete();
             
            // Delete ordered items
            $this->orderItem->where('order_id', $id)->forceDelete();
            
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }

    // 
    public function get_add()
    {
        $module = $this->module;
        $singleData = $this->data;
        $countries = Country::pluck('nicename', 'id');

        return view('admin.'.$module.'.add_edit', compact('singleData', 'module', 'countries'));
    }

    public function post_add(OrderRequest $request)
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


    // Edit Shipping /////////////////////
    public function post_edit(OrderRequest $request, $id)
    {
        $module = $this->module;
        $this->data = $this->data->find($id);
        $customer = $this->data->find($id)->customer_id;
        // $ordered_customer_user_role = $this->data->customer->user->hasRole(['customer']);
        // $this->data->fill($request->all());

        // if ((in_array(strtolower($this->data->customer->is_same_as_billing == 1 ? $this->data->customer->billingCountry->iso : $this->data->customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $this->data->amount >= 40 && ($this->data->shipping_id == 21 || $this->data->shipping_id == 22)) {
        //     $shippingVat =  number_format(0, 2);
        //     $shippingAmount =  number_format(0, 2);
        // }
        if ((in_array(strtolower($this->data->customer->is_same_as_billing == 1 ? $this->data->customer->billingCountry->iso : $this->data->customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $this->data->shippingMethod->is_free_shipping == 1) {
            if($this->data->customer->user->hasRole(['customer']) && $this->data->amount >= $this->option->free_shipping_over_amount_normal_customers || $this->data->customer->user->hasRole(['cake_time_club']) && $this->data->amount >= $this->option->free_shipping_over_amount_cake_time_club || $this->data->customer->user->hasRole(['trade_customer']) && $this->data->amount >= $this->option->free_shipping_over_amount_trade){
                $shippingVat =  number_format(0, 2);
                $shippingAmount =  number_format(0, 2);
            }else{
                $shippingVat = $request->shipping_amount_with_tax / 1.2 * 0.2;
                $shippingAmount = $request->shipping_amount_with_tax - $shippingVat;
            }
        }
        else{
            if(in_array(strtolower($this->data->customer->is_same_as_billing == 1 ? $this->data->customer->billingCountry->iso : $this->data->customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                $shippingVat = $request->shipping_amount_with_tax / 1.2 * 0.2;
                $shippingAmount = $request->shipping_amount_with_tax - $shippingVat;
            }else{
                $shippingVat = 0;
                $shippingAmount = $request->shipping_amount_with_tax;
            }
        }

        $this->data->shipping = $shippingAmount;
        $this->data->shipping_vat = $shippingVat;
        $this->data->vat = $this->data->product_vat + $shippingVat;
        
        $grandTotal = $request->amount + $shippingAmount +  $this->data->vat;
        $this->data->grand_total = $grandTotal;
        $this->data->save();

        $sessionMsg = $this->data->order_no;
        return redirect('admin/'.$module.'/'.$id.'/view')->with('success', 'Order #'.$sessionMsg.' shipping amount has been updated');
    }

    // Edit Ordered item /////////////////////
    public function post_edit_ordered_items(OrdersItemRequest $request, $id)
    {
        $module = $this->module;

        //Update quantity
        $this->orderItem = $this->orderItem->find($id);
        $this->orderItem->quantity = $request->quantity;
        $this->orderItem->save();

        // Updated Product Info
        $product = $this->orderItem->product;

        // Ordered Customer
        $customer = $this->data->find($request->oid)->customer;

        // Updated OrderedItems
        $cartItems = $this->orderItem->where('order_id',$request->oid)->get();

        // Updating Order Details
        $this->data = $this->data->find($request->oid);

        //ordered Sub Total****************************************************
        $order_price[] = 0;
        foreach ($cartItems as $row) {
            $order_price[] = $row->quantity * $row->cart_price;
        }
        $orderedSubTotal = array_sum($order_price);
        // dd($orderedSubTotal . PHP_EOL);
        //*******************************************************************

        // Total Vat
        $vatAmounts[] = 0;
        foreach ($cartItems as $row) {
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $row->vat != 0){
                $vatAmounts[] = $row->cart_price / 1.2 * 0.2 * $row->quantity;
                // $vatAmounts[] = ($row->cart_price + $row->vat) / 1.2 * 0.2 * $row->quantity;
            }else{
                $vatAmounts[] = 0;
            }
        }
        $sumOfTotalVat = array_sum($vatAmounts);
        // dd($sumOfTotalVat . PHP_EOL);
        $subTotalWithoutVatAmount = $orderedSubTotal - $sumOfTotalVat; 
        // print_r($subTotalWithoutVatAmount . PHP_EOL);


        // Normal Discount | ok
        $normalDiscount[] = 0;
        foreach ($cartItems as $item) {
            $normalDiscount[] = number_format(($item->product->price - $item->cart_price),2) * $item->quantity;
            // $normalDiscount[] = ($item->product->price - $item->vat - $item->cart_price) * $item->quantity;
        }
        $sumOfTotalNormalDiscount = array_sum($normalDiscount);
        // dd($sumOfTotalNormalDiscount . PHP_EOL);


        // totalNormalPrice | ok
        $totalNormalPrice[] = 0;
        foreach ($cartItems as $item) {
            if ($item->product->vat != 0){
                $totalNormalPrice[] =$item->cart_price / 1.2 * $item->quantity;
            }
            else{
                $totalNormalPrice[] = $item->quantity * $item->cart_price;
            }
            // $totalNormalPrice[] = $item->quantity * $item->cart_price;
        }
        $totalNormalPriceAmount =  array_sum($totalNormalPrice);
        // print_r($totalNormalPrice);
        // dd($totalNormalPriceAmount . PHP_EOL);


        // Over Hundred Order value Dicount, over 100
        $applicable_ten_percentage_order_value_discoount[] = 0;
        $ten_percentage_order_value_discoount_over[] = 0;
        foreach ($cartItems as $row) {
            if ($row->product->discount_percentage < $this->option->order_value_discount_over_100) {
                $applicable_ten_percentage_order_value_discoount[] = ($row->product->price * $this->option->order_value_discount_over_100 / 100) * $row->quantity;
            }
            if ($row->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                $ten_percentage_order_value_discoount_over[] = ($row->product->price - $row->cart_price) * $row->quantity;
                // $ten_percentage_order_value_discoount_over[] = ($row->product->price - $row->cart_price - $row->vat) * $row->quantity;
            }
        }
        $sumOfApplicableTenPercentageOrderValueDiscount =  array_sum($applicable_ten_percentage_order_value_discoount);
        $sumOfTenPercentageOrderValueDiscountOver =  array_sum($ten_percentage_order_value_discoount_over);
        $sumOfTotalOrderValueDiscountAmount = $sumOfApplicableTenPercentageOrderValueDiscount + $sumOfTenPercentageOrderValueDiscountOver;  
        // dd($sumOfTotalOrderValueDiscountAmount . PHP_EOL);


        // 50 - 100 Order value Dicount
        $applicable_five_percentage_order_value_discoount[] = 0;
        $five_percentage_order_value_discoount_over[] = 0;
        foreach ($cartItems as $item) {
            if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                $applicable_five_percentage_order_value_discoount[] = ($item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
            }
            if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                $five_percentage_order_value_discoount_over[] = ($item->product->price - $item->cart_price) * $item->quantity;
                // $five_percentage_order_value_discoount_over[] = ($item->product->price - $item->cart_price - $row->vat) * $item->quantity;
            }
        }
        $sumOfApplicableFivePercentageOrderValueDiscount =  array_sum($applicable_five_percentage_order_value_discoount);
        $sumOfFivePercentageOrderValueDiscountOver =  array_sum($five_percentage_order_value_discoount_over);
        $sumOfFivePercentageTotalOrderValueDiscountAmount = $sumOfApplicableFivePercentageOrderValueDiscount + $sumOfFivePercentageOrderValueDiscountOver;  // print_r($sumOfFivePercentageTotalOrderValueDiscountAmount . PHP_EOL);


        // Coupon
        // $coupons = $this->coupon->where('status',1)->get();
        // $coupon_code = Session::get('coupon');


        // Coupon code Discounts
        // dd($this->data->coupon_amount);
        if ($this->data->coupon_id) {
            $couponDiscounts[] = 0;
            $couponDiscountsOver[] = 0;
            foreach ($cartItems as $row) {
                if ($row->product->discount_percentage < $this->data->coupon->percentage) {
                    $couponDiscounts[] = ($row->product->price * $this->data->coupon->percentage / 100) * $row->quantity;
                }
                if ($row->product->discount_percentage >= $this->data->coupon->percentage) {
                    $couponDiscountsOver[] = ($row->product->price - $row->cart_price) * $row->quantity;
                }
            }
            $sumOfcouponDiscounts = array_sum($couponDiscounts); //print_r($couponDiscounts); echo "<pre>";print_r($couponDiscounts );echo "</pre>";
            $sumOfcouponDiscountsOver = array_sum($couponDiscountsOver); // print_r($sumOfcouponDiscountsOver . PHP_EOL); echo "<pre>"; print_r($couponDiscountsOver ); echo "</pre>";
            $totalCouponDiscountAmount = $sumOfcouponDiscounts + $sumOfcouponDiscountsOver; //print_r($totalCouponDiscountAmount . PHP_EOL);
        }else{
            $totalCouponDiscountAmount = 0;
        }


        // Coupon sub total
        if ($this->data->coupon_id) {
            $coupon_sub_total[] = 0;
            $coupon_sub_total_over[] = 0;
            foreach ($cartItems as $item) {
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total_over[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
                else{
                    if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total_over[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
            }
            $sumOfCouponSubTotal =  array_sum($coupon_sub_total);
            $sumOfCouponSubTotalOver =  array_sum($coupon_sub_total_over);
            $sumOfCouponNetPrice = $sumOfCouponSubTotal + $sumOfCouponSubTotalOver;
            //print_r($sumOfCouponNetPrice . PHP_EOL);
        }else{
            $sumOfCouponNetPrice = 0;
        } 

        
        // Coupon Vat
        if ($this->data->coupon_id) {
            $coupon_vat_amount[] = 0;
            $coupon_vat_amount_over[] = 0;
            $sumOfCouponTotalVat = 0;
            foreach ($cartItems as $item) {
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                        $coupon_vat_amount[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2 * $item->quantity;
                    }
                    if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                        $coupon_vat_amount_over[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                    }
                }
            }
            $sumOfCouponValueVatAmoount =  array_sum($coupon_vat_amount);
            $sumOfCouponVatAmoountOver =  array_sum($coupon_vat_amount_over);
            $sumOfCouponTotalVat = $sumOfCouponValueVatAmoount + $sumOfCouponVatAmoountOver; 
            //print_r($sumOfCouponTotalVat . PHP_EOL);
        }



        // Order Value over hundred VAT
        $order_value_vat_amount[] = 0;
        $order_value_vat_amount_over[] = 0;
        foreach ($cartItems as $item) {
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    $order_value_vat_amount[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2 * $item->quantity;
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    $order_value_vat_amount_over[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                }
            }
        }
        $sumOfOrderValueVatAmoount =  array_sum($order_value_vat_amount);
        $sumOfOrderValueVatAmoountOver =  array_sum($order_value_vat_amount_over);
        $sumOfOrderValueTotalVat = $sumOfOrderValueVatAmoount + $sumOfOrderValueVatAmoountOver; 
        //print_r($sumOfOrderValueTotalVat . PHP_EOL);


        // Order Value over hundred VAT
        $order_value_vat_amount_five[] = 0;
        $order_value_vat_amount_over_five[] = 0;
        foreach ($cartItems as $item) {
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    $order_value_vat_amount_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2 * $item->quantity;
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    $order_value_vat_amount_over_five[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                }
            }
        }
        $sumOfFivePercentageOrderValueVatAmoount =  array_sum($order_value_vat_amount_five);
        $sumOfOrderValueVatAmoountOverFive =  array_sum($order_value_vat_amount_over_five);
        $sumOfFivePercentageOrderValueTotalVat = $sumOfFivePercentageOrderValueVatAmoount + $sumOfOrderValueVatAmoountOverFive; //print_r($sumOfFivePercentageOrderValueTotalVat . PHP_EOL);


        // Order Value Sub Total
        $order_value_sub_total[] = 0;
        $order_value_sub_total_over[] = 0;
        foreach ($cartItems as $item) {
            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over[] = $item->cart_price * $item->quantity;
                    }
                }
            }
            else{
                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over[] = $item->cart_price * $item->quantity;
                    }
                }
            }
        }
        $sumOfOrderValueSubTotal =  array_sum($order_value_sub_total);
        $sumOfOrderValueSubTotalOver =  array_sum($order_value_sub_total_over);
        $sumOfOrderValueNetPrice = $sumOfOrderValueSubTotal + $sumOfOrderValueSubTotalOver; //print_r( $sumOfOrderValueNetPrice);



        // Order Value Sub Total 50 to 100
        $order_value_sub_total_five[] = 0;
        $order_value_sub_total_over_five[] = 0;
        foreach ($cartItems as $item) {
            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price * $item->quantity;
                    }
                }
            }
            else{
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price * $item->quantity;
                    }
                }
            }
        }
        $sumOfFivePercentageOrderValueSubTotal =  array_sum($order_value_sub_total_five);
        $sumOfOrderValueSubTotalOverFivePercentage =  array_sum($order_value_sub_total_over_five);
        $sumOfsumOfFivePercentageOrderValueNetPrice = $sumOfFivePercentageOrderValueSubTotal + $sumOfOrderValueSubTotalOverFivePercentage; //print_r( $sumOfsumOfFivePercentageOrderValueNetPrice);
        


        // Sub Total ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])){
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $subTotal = $sumOfCouponNetPrice;
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $subTotal = $sumOfsumOfFivePercentageOrderValueNetPrice;
                }elseif($subTotalWithoutVatAmount >= 100){
                    $subTotal = $sumOfOrderValueNetPrice;
                }else{
                    $subTotal = $totalNormalPriceAmount;                    
                }
            }
        }else{
            $subTotal = $totalNormalPriceAmount;
        }

        // dd($subTotalWithoutVatAmount);

        // Discount Amount ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])) {
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $totalDiscountAmount = $totalCouponDiscountAmount;
                Session::put('coupon_amount', $totalDiscountAmount);
                Session::put('discount_type', 1);
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $totalDiscountAmount = $sumOfFivePercentageTotalOrderValueDiscountAmount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 2);
                }elseif($subTotalWithoutVatAmount >= 100){
                    $totalDiscountAmount = $sumOfTotalOrderValueDiscountAmount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 3);
                }else{
                    $totalDiscountAmount = $sumOfTotalNormalDiscount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 4);
                }
            }
        }else{ //Trade ans cake time club customers
            $totalDiscountAmount = $sumOfTotalNormalDiscount;
            Session::put('coupon_amount', $totalDiscountAmount);
            Session::put('discount_type', 4);
        }
        
        
        
        
        $shipping = $this->data->shippingMethod;
        $customerCountry = strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso);
        if(in_array($customerCountry, config('default.european_shipping_countries_iso'))){
            if ($customerCountry ==  'at') {
               $shippingAmount = $shipping->austria_amount && $shipping->is_not_austria_available == 0 ? $shipping->austria_amount : config('default.we_will_let_you_know');
               $shippingVat = $shipping->austria_tax_percentage;
            }elseif ($customerCountry ==  'be') {
                $shippingAmount = $shipping->belgium_amount && $shipping->is_not_belgium_available == 0 ? $shipping->belgium_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->belgium_tax_percentage;
            }elseif ($customerCountry ==  'bg') {
                $shippingAmount = $shipping->bulgaria_amount && $shipping->is_not_bulgaria_available == 0 ? $shipping->bulgaria_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->bulgaria_tax_percentage;
            }elseif ($customerCountry ==  'hr') {
                $shippingAmount = $shipping->croatia_amount && $shipping->is_not_croatia_available == 0 ? $shipping->croatia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->croatia_tax_percentage;
            }elseif ($customerCountry ==  'cy') {
                $shippingAmount = $shipping->republic_of_cyprus_amount && $shipping->is_not_republic_of_cyprus_available == 0 ? $shipping->republic_of_cyprus_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->republic_of_cyprus_tax_percentage;
            }elseif ($customerCountry ==  'cz') {
                $shippingAmount = $shipping->czech_republic_amount && $shipping->is_not_czech_republic_available == 0 ? $shipping->czech_republic_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->czech_republic_tax_percentage;
            }elseif ($customerCountry ==  'dk') {
                $shippingAmount = $shipping->denmark_amount && $shipping->is_not_denmark_available == 0 ? $shipping->denmark_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->denmark_tax_percentage;
            }elseif ($customerCountry ==  'ee') {
                $shippingAmount = $shipping->estonia_amount && $shipping->is_not_estonia_available == 0 ? $shipping->estonia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->estonia_tax_percentage;
            }elseif ($customerCountry ==  'fi') {
                $shippingAmount = $shipping->finland_amount && $shipping->is_not_finland_available == 0 ? $shipping->finland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->finland_tax_percentage;
            }elseif ($customerCountry ==  'fr') {
                $shippingAmount = $shipping->france_amount && $shipping->is_not_france_available == 0 ? $shipping->france_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->france_tax_percentage;
            }elseif ($customerCountry ==  'de') {
                $shippingAmount = $shipping->germany_amount && $shipping->is_not_germany_available == 0 ? $shipping->germany_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->germany_tax_percentage;
            }elseif ($customerCountry ==  'gr') {
                $shippingAmount = $shipping->greece_amount && $shipping->is_not_greece_available == 0 ? $shipping->greece_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->greece_tax_percentage;
            }elseif ($customerCountry ==  'hu') {
                $shippingAmount = $shipping->hungary_amount && $shipping->is_not_hungary_available == 0 ? $shipping->hungary_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->hungary_tax_percentage;
            }elseif ($customerCountry ==  'ie') {
                $shippingAmount = $shipping->ireland_amount && $shipping->is_not_ireland_available == 0 ? $shipping->ireland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->ireland_tax_percentage;
            }elseif ($customerCountry ==  'it') {
                $shippingAmount = $shipping->italy_amount && $shipping->is_not_italy_available == 0 ? $shipping->italy_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->italy_tax_percentage;
            }elseif ($customerCountry ==  'lv') {
                $shippingAmount = $shipping->latvia_amount && $shipping->is_not_latvia_available == 0 ? $shipping->latvia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->latvia_tax_percentage;
            }elseif ($customerCountry ==  'lt') {
                $shippingAmount = $shipping->lithuania_amount && $shipping->is_not_lithuania_available == 0 ? $shipping->lithuania_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->lithuania_tax_percentage;
            }elseif ($customerCountry ==  'lu') {
                $shippingAmount = $shipping->luxembourg_amount && $shipping->is_not_luxembourg_available == 0 ? $shipping->luxembourg_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->luxembourg_tax_percentage;
            }elseif ($customerCountry ==  'mt') {
                $shippingAmount = $shipping->malta_amount && $shipping->is_not_malta_available == 0 ? $shipping->malta_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->malta_tax_percentage;
            }elseif ($customerCountry ==  'nl') {
                $shippingAmount = $shipping->netherlands_amount && $shipping->is_not_netherlands_available == 0 ? $shipping->netherlands_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->netherlands_tax_percentage;
            }elseif ($customerCountry ==  'pl') {
                $shippingAmount = $shipping->poland_amount && $shipping->is_not_poland_available == 0 ? $shipping->poland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->poland_tax_percentage;
            }elseif ($customerCountry ==  'pt') {
                $shippingAmount = $shipping->portugal_amount && $shipping->is_not_portugal_available == 0 ? $shipping->portugal_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->portugal_tax_percentage;
            }elseif ($customerCountry ==  'ro') {
                $shippingAmount = $shipping->romania_amount && $shipping->is_not_romania_available == 0 ? $shipping->romania_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->romania_tax_percentage;
            }elseif ($customerCountry ==  'sk') {
                $shippingAmount = $shipping->slovakia_amount && $shipping->is_not_slovakia_available == 0 ? $shipping->slovakia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->slovakia_tax_percentage;
            }elseif ($customerCountry ==  'si') {
                $shippingAmount = $shipping->slovenia_amount && $shipping->is_not_slovenia_available == 0 ? $shipping->slovenia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->slovenia_tax_percentage;
            }elseif ($customerCountry ==  'es') {
                $shippingAmount = $shipping->spain_amount && $shipping->is_not_spain_available == 0 ? $shipping->spain_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->spain_tax_percentage;
            }elseif ($customerCountry ==  'se') {
                $shippingAmount = $shipping->sweden_amount && $shipping->is_not_sweden_available == 0 ? $shipping->sweden_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->sweden_tax_percentage;
            }else{
                $shippingAmount = 0;
            }
        }elseif(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.uk_countries_iso'))){
            $shippingAmount = $shipping->uk_amount && $shipping->is_not_uk_available == 0 ? $shipping->uk_amount : config('default.we_will_let_you_know');
            $shippingVat = $shipping->uk_tax_percentage;
            // dd( $shippingAmount);
        }else{
            $shippingAmount = $shipping->global_amount && $shipping->is_not_globally_available == 0 ? $shipping->global_amount : config('default.we_will_let_you_know');
            $shippingVat = $shipping->global_tax_percentage;
        }
        
        if(!is_numeric($shippingAmount)){
            $shippingAmount = 0;
        }
        
        // Shipping ///////////////////////////////////////
        // $shippingVat =  number_format(0, 2);
        // $shippingAmount =  number_format(0, 2);
        // $shippingAmountAndShippingTax = $this->data->shipping + $this->data->shipping_vat;
        $shippingAmountAndShippingTax = $shippingAmount;
        // dd($this->data->shippingMethod->id);
        if ($this->data->shipping_id) {
            // if ((in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $subTotalWithoutVatAmount >= 40 && ($this->data->shippingMethod->id == 21 || $this->data->shippingMethod->id == 22)) {
            //     $shippingVat =  number_format(0, 2);
            //     $shippingAmount =  number_format(0, 2);
            // }
            if ((in_array(strtolower($this->data->customer->is_same_as_billing == 1 ? $this->data->customer->billingCountry->iso : $this->data->customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $this->data->shippingMethod->is_free_shipping == 1) {
                if($this->data->customer->user->hasRole(['customer']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_normal_customers || $this->data->customer->user->hasRole(['cake_time_club']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_cake_time_club || $this->data->customer->user->hasRole(['trade_customer']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_trade){
                    $shippingVat =  number_format(0, 2);
                    $shippingAmount =  number_format(0, 2);
                }else{
                    // $shippingVat = $request->shipping_amount_with_tax / 1.2 * 0.2;
                    // $shippingAmount = $request->shipping_amount_with_tax - $shippingVat;
                    $shippingVat = $shippingAmountAndShippingTax / 1.2 * 0.2;
                    $shippingAmount = $shippingAmountAndShippingTax;
                }
            }
            else{
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                    $shippingVat = $shippingAmountAndShippingTax / 1.2 * 0.2;
                    $shippingAmount = $shippingAmountAndShippingTax;
                }else{
                    $shippingVat = 0;
                    $shippingAmount = $shippingAmountAndShippingTax;
                }
            }
        }

        // Vat ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])) {
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $totalVatAmount = $sumOfCouponTotalVat;
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $totalVatAmount = $sumOfFivePercentageOrderValueTotalVat;
                }elseif($subTotalWithoutVatAmount >= 100){
                    $totalVatAmount = $sumOfOrderValueTotalVat;
                }else{
                    $totalVatAmount = $sumOfTotalVat;
                }
            }
        }else{ //Trade ans cake time club customers
            $totalVatAmount = $sumOfTotalVat;
        }

        // Grand Total ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])) {
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $grandTotal = $sumOfCouponNetPrice + $shippingAmount + $sumOfCouponTotalVat;
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $grandTotal = $sumOfsumOfFivePercentageOrderValueNetPrice + $shippingAmount + $totalVatAmount;
                }elseif($subTotalWithoutVatAmount >= 100){
                    $grandTotal = $sumOfOrderValueNetPrice + $shippingAmount + $totalVatAmount;
                }else{
                    $grandTotal = $totalNormalPriceAmount + $shippingAmount + $totalVatAmount;
                }
            }
        }else{ //Trade ans cake time club customers
            $grandTotal = $totalNormalPriceAmount + $shippingAmount + $totalVatAmount;
        }

        // Save SubTotal
        $this->data->amount = $subTotal;

        // Save total Discount amount
        $this->data->total_discount = $totalDiscountAmount;

        // Applied Discount Type
        $this->data->discount_type = session('discount_type');

        // discount amount over hunder
        // $this->data->order_value_discount_over_hundred = $totalDiscountAmount;
        // $this->data->old_order_value_discount_over_hundred = $totalDiscountAmount; 

        // $this->data->order_value_discount = $totalDiscountAmount;
        // $this->data->old_order_value_discount = $totalDiscountAmount;

        $this->data->order_value_discount_percentage = $this->option->order_value_discount_50_100;
        $this->data->order_value_discount_percentage_over_100 = $this->option->order_value_discount_over_100;

        // Save Coupon Amount
        $this->data->coupon_amount = $totalCouponDiscountAmount;

        //Save Shipping
        $this->data->shipping = $shippingAmount - $shippingVat;

        // Save all VAT
        $this->data->product_vat = $totalVatAmount;
        $this->data->shipping_vat = $shippingVat;
        $this->data->vat = $totalVatAmount + $shippingVat;

        // Save grand Total
        $this->data->grand_total = $grandTotal;
        $this->data->save();


        /////
        $orderItems = null;
        $dt = new DateTime();
        foreach ($cartItems as $item) {
            // Line NET ////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])){
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage){
                         if ($item->product->vat != 0){
                            $line_net = number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity ,2);
                        }
                        else{
                            $line_net = number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity ,2);
                        }
                    }
                    elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                        if ($item->product->vat != 0) {
                            $line_net = number_format($item->cart_price / 1.2 * $item->quantity ,2);
                        }
                        else{
                            $line_net = number_format($item->cart_price * $item->quantity ,2);
                        }
                    }
                }
                else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_50_100){
                            if ($item->product->vat != 0){
                                $line_net =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity ,2);
                            }else{
                                $line_net =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity ,2);
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                            if ($item->product->vat != 0) {
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity ,2);
                            }
                            else {
                                $line_net = number_format($item->cart_price * $item->quantity ,2);
                            }
                        } 
                    }
                    elseif($subTotalWithoutVatAmount >= 100){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_over_100){
                            if ($item->product->vat != 0){
                                $line_net = number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity  ,2);
                            }
                            else{
                                $line_net = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity ,2);
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                            if ($item->product->vat != 0) {
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity,2);
                            }
                            else{
                                $line_net = number_format($item->cart_price * $item->quantity,2);
                            }
                        }
                    }
                    else{
                        if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                            $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                        }
                        else{
                            if ($item->product->vat != 0){
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                            }
                            else{
                                $line_net = number_format(($item->quantity * $item->cart_price), 2);
                            }
                        }
                    }
                }
            }else{ //trade and caketime club customers
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                }else{
                    if ($item->product->vat != 0){
                        $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                    }else{
                        $line_net = number_format(($item->quantity * $item->cart_price), 2);
                    }
                }
            }

            // NET Price////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])){
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage){
                         if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                             $net_price =  number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
                         }
                         else{
                              if ($item->product->vat != 0){
                                 $net_price =  number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
                              }
                             else{
                                 $net_price =  number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) ,2);
                             }
                         }
                    }
                    elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                         if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                             $net_price =  number_format($item->cart_price / 1.2,2);
                         }
                         else{
                             if ($item->product->vat != 0){
                                 $net_price =  number_format($item->cart_price / 1.2,2);
                             }
                             else{
                                 $net_price =  number_format($item->cart_price,2);
                             }
                         }
                    }
                }
                else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_50_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
                                }
                                else{
                                    $net_price =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) ,2);
                                }
                            }
                        }   
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                $net_price =  number_format($item->cart_price / 1.2,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format($item->cart_price / 1.2,2);
                                }
                                else{
                                    $net_price =  number_format($item->cart_price,2);
                                }
                            }
                        }
                    }
                    elseif($subTotalWithoutVatAmount >= 100){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_over_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
                                }
                                else{
                                    $net_price =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) ,2);
                                }
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                $net_price =  number_format($item->cart_price / 1.2,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format($item->cart_price / 1.2,2);
                                }
                                else{
                                    $net_price =  number_format($item->cart_price,2);
                                }
                            }
                        }
                    }
                    else{
                        if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                            $net_price = number_format($item->cart_price / 1.2, 2);
                        }
                        else{
                            if ($item->product->vat != 0){
                                $net_price = number_format($item->cart_price / 1.2, 2);
                            }
                            else{
                                $net_price = number_format($item->cart_price, 2);
                            }
                        }
                    }
                }
            }else{ // Trade, Cake time customers
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    $net_price = number_format($item->cart_price / 1.2, 2);
                }
                else{
                    if ($item->product->vat != 0){
                        $net_price = number_format($item->cart_price / 1.2, 2);
                    }
                    else{
                        $net_price = number_format($item->cart_price, 2);
                    }
                }  
            }
               
            // Vat ////////////////////////////////////
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                if ($this->data->customer->user->hasRole(['customer'])){
                    if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                        if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                            $vat_amount = number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2  ,2);
                        }
                        elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                            $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                        }
                    }
                    else{
                        if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                                $vat_amount = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2  ,2);
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                                $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                            }
                        }
                        elseif($subTotalWithoutVatAmount >= 100){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                                $vat_amount = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2  ,2);
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                                $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                            }
                        }
                        else{
                            $vat_amount =number_format($item->cart_price / 1.2 * 0.2, 2);
                        }
                    }
                }
                else{
                    $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                }
            }else{
                $vat_amount = number_format(0,2);
            }

            $orderItems[] = [
                'order_id' => $request->oid,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'old_quantity' => $item->quantity,
                'cart_price' => $item->cart_price,
                'price' => $net_price,
                'vat' => $vat_amount,
                'old_vat' => $vat_amount,
                'color_id' => $item->product->color_id,
                'is_product_discount' => $item->product->discount_percentage ? 1 : 0,
                'created_at' => $dt->format('Y-m-d H:i:s'),
                'updated_at' => $dt->format('Y-m-d H:i:s'),
            ];
            $this->orderItem->where('id', $item->id)->update(['price' => $net_price,'vat' => $vat_amount]);
        }

        // if ($orderItems) $this->orderItem->insert($orderItems);

        // $orderedItemsProductsIds = $this->orderItem
        //     ->where('order_id',  $request->oid)
        //     ->pluck('product_id')
        //     ->toArray();

        // $this->orderItem
        //     ->where('order_id',  $request->oid)
        //     ->delete();

        // if ($orderItems) $this->orderItem->insert($orderItems);

        // $db = array_map('serialize', $cartItems->toArray());
        // $excel = array_map('serialize', $orderItems);
        // $diff = array_map('unserialize', array_diff($excel, $db));
        // dd($diff);

        // dd($orderedItemsProductsIds);

        // $values = $this->orderItem
        //     ->where('id', $id)
        //     ->update([
        //         'price' => $net_price,
        //         'vat' => $vat_amount
        //     ]);

        $sessionMsg = $this->orderItem->product->name;
        return redirect()->back()->with('success', 'Product '.$sessionMsg.' quantity has been updated');
    }


    // Add new product /////////////////////
    public function post_add_ordered_items(OrdersItemRequest $request, $id)
    {
        $module = $this->module;
        $this->data = $this->data->find($id); // Order Details
        $product = $this->product->whereId($request->product_id)->first();
        $user = $this->data->find($id)->customer->user;
        $customer = $this->data->find($id)->customer;

        // Cart Price////////////////////////////////////
        if ($user->hasRole('trade_customer')) {
            if ($user->customer->discount_percentage) {
                if ($user->customer->discount_percentage >= $product->discount_percentage) {
                    $price = $product->price - (($user->customer->discount_percentage / 100) * $product->price);
                }else{
                    $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                }
            }else{
                if ($this->option->trade_discount_percentage >= $product->discount_percentage) {
                    $price = $product->price - (($this->option->trade_discount_percentage / 100) * $product->price);
                }else{
                    $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                }
            }
        }
        elseif ($user->hasRole('cake_time_club')) {
            if ($user->customer->is_paid == 1) { // Paid
                if ($user->customer->membership_type == 1) { // Gold
                    if ($user->customer->discount_percentage) { 
                        if ($user->customer->discount_percentage >= $product->discount_percentage) {
                            $price = $product->price - (($user->customer->discount_percentage / 100) * $product->price);
                        }else{
                            $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                        }
                    }else{
                        if ($this->option->cake_time_club_gold_discount_percentage >= $product->discount_percentage) {
                            $price = $product->price - (($this->option->cake_time_club_gold_discount_percentage / 100) * $product->price);
                        }else{
                            $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                        }
                    }
                }elseif($user->customer->membership_type == 2){ // Platinum
                    if ($user->customer->discount_percentage) { 
                        if ($user->customer->discount_percentage >= $product->discount_percentage) {
                            $price = $product->price - (($user->customer->discount_percentage / 100) * $product->price);
                        }else{
                            $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                        }
                    }else{
                        if ($this->option->cake_time_club_platinum_discount_percentage >= $product->discount_percentage) {
                            $price = $product->price - (($this->option->cake_time_club_platinum_discount_percentage / 100) * $product->price);
                        }else{
                            $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                        }
                    }
                }
            }else{ // Not Paid club member
                if ($user->customer->discount_percentage) { 
                    if ($user->customer->discount_percentage >= $product->discount_percentage) {
                        $price = $product->price - (($user->customer->discount_percentage / 100) * $product->price);
                    }else{
                        $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                    }
                } else { 
                    if ($product->discount_percentage){
                        $price = $product->price - (($product->discount_percentage / 100) * $product->price);
                    }else { 
                        $price = $product->price;
                    }
                }
            }
        } 
        elseif ($user->hasRole('customer')) {
           if ($user->customer->discount_percentage) { 
               if ($user->customer->discount_percentage >= $product->discount_percentage) {
                   $price = $product->price - (($user->customer->discount_percentage / 100) * $product->price);
               }else{
                   $price = $product->price - (($product->discount_percentage / 100) * $product->price);
               }
           } else { 
               if ($product->discount_percentage){
                   $price = $product->price - (($product->discount_percentage / 100) * $product->price);
               }else { 
                   $price = $product->price;
               }
           }
        }
        else{
            $price = $product->discount_percentage ? $product->discount_price : $product->price;
        }

       // NET Price////////////////////////////////////
       // if ($this->data->customer->user->hasRole(['customer'])){
       //     if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
       //         if ($product->discount_percentage < $this->data->coupon->percentage){
       //              if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0){
       //                  $net_price =  number_format( ($product->price - $product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
       //              }
       //              else{
       //                   if ($product->vat != 0){
       //                      $net_price =  number_format( ($product->price - $product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
       //                   }
       //                  else{
       //                      $net_price =  number_format(($product->price - $product->price * $this->data->coupon->percentage / 100) ,2);
       //                  }
       //              }
       //         }
       //         elseif($product->discount_percentage >= $this->data->coupon->percentage){
       //              if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0) {
       //                  $net_price =  number_format($price / 1.2,2);
       //              }
       //              else{
       //                  if ($product->vat != 0){
       //                      $net_price =  number_format($price / 1.2,2);
       //                  }
       //                  else{
       //                      $net_price =  number_format($price,2);
       //                  }
       //              }
       //         }
       //     }
       //     else{
       //         if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
       //             if ($product->discount_percentage < $this->option->order_value_discount_50_100){
       //                 if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0){
       //                     $net_price =  number_format( ($product->price - $product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
       //                 }
       //                 else{
       //                     if ($product->vat != 0){
       //                         $net_price =  number_format( ($product->price - $product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
       //                     }
       //                     else{
       //                         $net_price =  number_format(($product->price - $product->price * $this->option->order_value_discount_50_100 / 100) ,2);
       //                     }
       //                 }
       //             }   
       //             elseif($product->discount_percentage >= $this->option->order_value_discount_50_100){
       //                 if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0) {
       //                     $net_price =  number_format($price / 1.2,2);
       //                 }
       //                 else{
       //                     if ($product->vat != 0){
       //                         $net_price =  number_format($price / 1.2,2);
       //                     }
       //                     else{
       //                         $net_price =  number_format($price,2);
       //                     }
       //                 }
       //             }
       //         }
       //         elseif($subTotalWithoutVatAmount >= 100){
       //             if ($product->discount_percentage < $this->option->order_value_discount_over_100){
       //                 if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0){
       //                     $net_price =  number_format( ($product->price - $product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
       //                 }
       //                 else{
       //                     if ($product->vat != 0){
       //                         $net_price =  number_format( ($product->price - $product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
       //                     }
       //                     else{
       //                         $net_price =  number_format(($product->price - $product->price * $this->option->order_value_discount_over_100 / 100) ,2);
       //                     }
       //                 }
       //             }
       //             elseif($product->discount_percentage >= $this->option->order_value_discount_over_100){
       //                 if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0) {
       //                     $net_price =  number_format($price / 1.2,2);
       //                 }
       //                 else{
       //                     if ($product->vat != 0){
       //                         $net_price =  number_format($price / 1.2,2);
       //                     }
       //                     else{
       //                         $net_price =  number_format($price,2);
       //                     }
       //                 }
       //             }
       //         }
       //         else{
       //             if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0){
       //                 $net_price = number_format($price / 1.2, 2);
       //             }
       //             else{
       //                 if ($product->vat != 0){
       //                     $net_price = number_format($price / 1.2, 2);
       //                 }
       //                 else{
       //                     $net_price = number_format($price, 2);
       //                 }
       //             }
       //         }
       //     }
       // }else{
       //     if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0){
       //         $net_price = number_format($price / 1.2, 2);
       //     }
       //     else{
       //         if ($product->vat != 0){
       //             $net_price = number_format($price / 1.2, 2);
       //         }
       //         else{
       //             $net_price = number_format($price, 2);
       //         }
       //     }  
       // }
          
       // Vat ////////////////////////////////////
       // if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $product->vat != 0){
       //     if ($this->data->customer->user->hasRole(['customer'])){
       //         if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
       //             if ($product->discount_percentage < $this->data->coupon->percentage) {
       //                 $vat_amount = number_format(($product->price - $product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2  ,2);
       //             }
       //             elseif($product->discount_percentage >= $this->data->coupon->percentage){
       //                 $vat_amount = number_format($price / 1.2 * 0.2, 2);
       //             }
       //         }
       //         else{
       //             if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
       //                 if ($product->discount_percentage < $this->option->order_value_discount_50_100) {
       //                     $vat_amount = number_format(($product->price - $product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2  ,2);
       //                 }
       //                 elseif($product->discount_percentage >= $this->option->order_value_discount_50_100){
       //                     $vat_amount = number_format($price / 1.2 * 0.2, 2);
       //                 }
       //             }
       //             elseif($subTotalWithoutVatAmount >= 100){
       //                 if ($product->discount_percentage < $this->option->order_value_discount_over_100) {
       //                     $vat_amount = number_format(($product->price - $product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2  ,2);
       //                 }
       //                 elseif($product->discount_percentage >= $this->option->order_value_discount_over_100){
       //                     $vat_amount = number_format($price / 1.2 * 0.2, 2);
       //                 }
       //             }
       //             else{
       //                 $vat_amount =number_format($price / 1.2 * 0.2, 2);
       //             }
       //         }
       //     }
       //     else{
       //         $vat_amount = number_format($price / 1.2 * 0.2, 2);
       //     }
       // }else{
       //     $vat_amount = number_format(0,2);
       // }



        // Add new product
        $this->orderItem->order_id = $id;
        $this->orderItem->product_id = $request->product_id;
        $this->orderItem->quantity = $request->quantity;
        $this->orderItem->old_quantity = $request->quantity;
        $this->orderItem->cart_price = $price;
        // $this->orderItem->price =  $net_price;
        // $this->orderItem->vat = $vat_amount;
        // $this->orderItem->old_vat = $vat_amount;
        $this->orderItem->is_product_discount =  $product->discount_percentage ? 1 : 0;
        $this->orderItem->status = 1;
        $this->orderItem->save();

        // die();

        $cartItems = $this->orderItem->where('order_id',$id)->get();





        //ordered Sub Total****************************************************
        $order_price[] = 0;
        foreach ($cartItems as $row) {
            $order_price[] = $row->quantity * $row->cart_price;
        }
        $orderedSubTotal = array_sum($order_price);
        // dd($orderedSubTotal . PHP_EOL);


        // Total Vat
        $vatAmounts[] = 0;
        foreach ($cartItems as $row) {
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $row->vat != 0){
                $vatAmounts[] = $row->cart_price / 1.2 * 0.2 * $row->quantity;
                // $vatAmounts[] = ($row->cart_price + $row->vat) / 1.2 * 0.2 * $row->quantity;
            }else{
                $vatAmounts[] = 0;
            }
        }
        $sumOfTotalVat = array_sum($vatAmounts);
        // dd($sumOfTotalVat . PHP_EOL);
        $subTotalWithoutVatAmount = $orderedSubTotal - $sumOfTotalVat; 
        // print_r($subTotalWithoutVatAmount . PHP_EOL);


        // Normal Discount | ok
        $normalDiscount[] = 0;
        foreach ($cartItems as $item) {
            $normalDiscount[] = number_format(($item->product->price - $item->cart_price),2) * $item->quantity;
            // $normalDiscount[] = ($item->product->price - $item->vat - $item->cart_price) * $item->quantity;
        }
        $sumOfTotalNormalDiscount = array_sum($normalDiscount);
        // dd($sumOfTotalNormalDiscount . PHP_EOL);


        // totalNormalPrice | ok
        $totalNormalPrice[] = 0;
        foreach ($cartItems as $item) {
            if ($item->product->vat != 0){
                $totalNormalPrice[] =$item->cart_price / 1.2 * $item->quantity;
            }
            else{
                $totalNormalPrice[] = $item->quantity * $item->cart_price;
            }
            // $totalNormalPrice[] = $item->quantity * $item->cart_price;
        }
        $totalNormalPriceAmount =  array_sum($totalNormalPrice);
        // print_r($totalNormalPrice);
        // dd($totalNormalPriceAmount . PHP_EOL);


        // Over Hundred Order value Dicount, over 100
        $applicable_ten_percentage_order_value_discoount[] = 0;
        $ten_percentage_order_value_discoount_over[] = 0;
        foreach ($cartItems as $row) {
            if ($row->product->discount_percentage < $this->option->order_value_discount_over_100) {
                $applicable_ten_percentage_order_value_discoount[] = ($row->product->price * $this->option->order_value_discount_over_100 / 100) * $row->quantity;
            }
            if ($row->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                $ten_percentage_order_value_discoount_over[] = ($row->product->price - $row->cart_price) * $row->quantity;
                // $ten_percentage_order_value_discoount_over[] = ($row->product->price - $row->cart_price - $row->vat) * $row->quantity;
            }
        }
        $sumOfApplicableTenPercentageOrderValueDiscount =  array_sum($applicable_ten_percentage_order_value_discoount);
        $sumOfTenPercentageOrderValueDiscountOver =  array_sum($ten_percentage_order_value_discoount_over);
        $sumOfTotalOrderValueDiscountAmount = $sumOfApplicableTenPercentageOrderValueDiscount + $sumOfTenPercentageOrderValueDiscountOver;  
        // dd($sumOfTotalOrderValueDiscountAmount . PHP_EOL);


        // 50 - 100 Order value Dicount
        $applicable_five_percentage_order_value_discoount[] = 0;
        $five_percentage_order_value_discoount_over[] = 0;
        foreach ($cartItems as $item) {
            if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                $applicable_five_percentage_order_value_discoount[] = ($item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
            }
            if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                $five_percentage_order_value_discoount_over[] = ($item->product->price - $item->cart_price) * $item->quantity;
                // $five_percentage_order_value_discoount_over[] = ($item->product->price - $item->cart_price - $row->vat) * $item->quantity;
            }
        }
        $sumOfApplicableFivePercentageOrderValueDiscount =  array_sum($applicable_five_percentage_order_value_discoount);
        $sumOfFivePercentageOrderValueDiscountOver =  array_sum($five_percentage_order_value_discoount_over);
        $sumOfFivePercentageTotalOrderValueDiscountAmount = $sumOfApplicableFivePercentageOrderValueDiscount + $sumOfFivePercentageOrderValueDiscountOver;  // print_r($sumOfFivePercentageTotalOrderValueDiscountAmount . PHP_EOL);


        // Coupon
        // $coupons = $this->coupon->where('status',1)->get();
        // $coupon_code = Session::get('coupon');


        // Coupon code Discounts
        // dd($this->data->coupon_amount);
        if ($this->data->coupon_id) {
            $couponDiscounts[] = 0;
            $couponDiscountsOver[] = 0;
            foreach ($cartItems as $row) {
                if ($row->product->discount_percentage < $this->data->coupon->percentage) {
                    $couponDiscounts[] = ($row->product->price * $this->data->coupon->percentage / 100) * $row->quantity;
                }
                if ($row->product->discount_percentage >= $this->data->coupon->percentage) {
                    $couponDiscountsOver[] = ($row->product->price - $row->cart_price) * $row->quantity;
                }
            }
            $sumOfcouponDiscounts = array_sum($couponDiscounts); //print_r($couponDiscounts); echo "<pre>";print_r($couponDiscounts );echo "</pre>";
            $sumOfcouponDiscountsOver = array_sum($couponDiscountsOver); // print_r($sumOfcouponDiscountsOver . PHP_EOL); echo "<pre>"; print_r($couponDiscountsOver ); echo "</pre>";
            $totalCouponDiscountAmount = $sumOfcouponDiscounts + $sumOfcouponDiscountsOver; //print_r($totalCouponDiscountAmount . PHP_EOL);
        }else{
            $totalCouponDiscountAmount = 0;
        }


        // Coupon sub total
        if ($this->data->coupon_id) {
            $coupon_sub_total[] = 0;
            $coupon_sub_total_over[] = 0;
            foreach ($cartItems as $item) {
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total_over[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
                else{
                    if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                        if ($item->product->vat != 0) {
                            $coupon_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $coupon_sub_total_over[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
            }
            $sumOfCouponSubTotal =  array_sum($coupon_sub_total);
            $sumOfCouponSubTotalOver =  array_sum($coupon_sub_total_over);
            $sumOfCouponNetPrice = $sumOfCouponSubTotal + $sumOfCouponSubTotalOver;
            //print_r($sumOfCouponNetPrice . PHP_EOL);
        }else{
            $sumOfCouponNetPrice = 0;
        } 

        
        // Coupon Vat
        if ($this->data->coupon_id) {
            $coupon_vat_amount[] = 0;
            $coupon_vat_amount_over[] = 0;
            $sumOfCouponTotalVat = 0;
            foreach ($cartItems as $item) {
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                        $coupon_vat_amount[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2 * $item->quantity;
                    }
                    if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                        $coupon_vat_amount_over[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                    }
                }
            }
            $sumOfCouponValueVatAmoount =  array_sum($coupon_vat_amount);
            $sumOfCouponVatAmoountOver =  array_sum($coupon_vat_amount_over);
            $sumOfCouponTotalVat = $sumOfCouponValueVatAmoount + $sumOfCouponVatAmoountOver; 
            //print_r($sumOfCouponTotalVat . PHP_EOL);
        }



        // Order Value over hundred VAT
        $order_value_vat_amount[] = 0;
        $order_value_vat_amount_over[] = 0;
        foreach ($cartItems as $item) {
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    $order_value_vat_amount[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2 * $item->quantity;
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    $order_value_vat_amount_over[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                }
            }
        }
        $sumOfOrderValueVatAmoount =  array_sum($order_value_vat_amount);
        $sumOfOrderValueVatAmoountOver =  array_sum($order_value_vat_amount_over);
        $sumOfOrderValueTotalVat = $sumOfOrderValueVatAmoount + $sumOfOrderValueVatAmoountOver; 
        //print_r($sumOfOrderValueTotalVat . PHP_EOL);


        // Order Value over hundred VAT
        $order_value_vat_amount_five[] = 0;
        $order_value_vat_amount_over_five[] = 0;
        foreach ($cartItems as $item) {
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    $order_value_vat_amount_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2 * $item->quantity;
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    $order_value_vat_amount_over_five[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                }
            }
        }
        $sumOfFivePercentageOrderValueVatAmoount =  array_sum($order_value_vat_amount_five);
        $sumOfOrderValueVatAmoountOverFive =  array_sum($order_value_vat_amount_over_five);
        $sumOfFivePercentageOrderValueTotalVat = $sumOfFivePercentageOrderValueVatAmoount + $sumOfOrderValueVatAmoountOverFive; //print_r($sumOfFivePercentageOrderValueTotalVat . PHP_EOL);


        // Order Value Sub Total
        $order_value_sub_total[] = 0;
        $order_value_sub_total_over[] = 0;
        foreach ($cartItems as $item) {
            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over[] = $item->cart_price * $item->quantity;
                    }
                }
            }
            else{
                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over[] = $item->cart_price * $item->quantity;
                    }
                }
            }
        }
        $sumOfOrderValueSubTotal =  array_sum($order_value_sub_total);
        $sumOfOrderValueSubTotalOver =  array_sum($order_value_sub_total_over);
        $sumOfOrderValueNetPrice = $sumOfOrderValueSubTotal + $sumOfOrderValueSubTotalOver; //print_r( $sumOfOrderValueNetPrice);



        // Order Value Sub Total 50 to 100
        $order_value_sub_total_five[] = 0;
        $order_value_sub_total_over_five[] = 0;
        foreach ($cartItems as $item) {
            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price * $item->quantity;
                    }
                }
            }
            else{
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                    }
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    if ($item->product->vat != 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price / 1.2 * $item->quantity;
                    }
                    if ($item->product->vat == 0) {
                        $order_value_sub_total_over_five[] = $item->cart_price * $item->quantity;
                    }
                }
            }
        }
        $sumOfFivePercentageOrderValueSubTotal =  array_sum($order_value_sub_total_five);
        $sumOfOrderValueSubTotalOverFivePercentage =  array_sum($order_value_sub_total_over_five);
        $sumOfsumOfFivePercentageOrderValueNetPrice = $sumOfFivePercentageOrderValueSubTotal + $sumOfOrderValueSubTotalOverFivePercentage; //print_r( $sumOfsumOfFivePercentageOrderValueNetPrice);
        


        // Sub Total ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])){
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $subTotal = $sumOfCouponNetPrice;
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $subTotal = $sumOfsumOfFivePercentageOrderValueNetPrice;
                }elseif($subTotalWithoutVatAmount >= 100){
                    $subTotal = $sumOfOrderValueNetPrice;
                }else{
                    $subTotal = $totalNormalPriceAmount;                    
                }
            }
        }else{
            $subTotal = $totalNormalPriceAmount;
        }

        // dd($subTotalWithoutVatAmount);

        // Discount Amount ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])) {
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $totalDiscountAmount = $totalCouponDiscountAmount;
                Session::put('coupon_amount', $totalDiscountAmount);
                Session::put('discount_type', 1);
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $totalDiscountAmount = $sumOfFivePercentageTotalOrderValueDiscountAmount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 2);
                }elseif($subTotalWithoutVatAmount >= 100){
                    $totalDiscountAmount = $sumOfTotalOrderValueDiscountAmount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 3);
                }else{
                    $totalDiscountAmount = $sumOfTotalNormalDiscount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 4);
                }
            }
        }else{ //Trade ans cake time club customers
            $totalDiscountAmount = $sumOfTotalNormalDiscount;
            Session::put('coupon_amount', $totalDiscountAmount);
            Session::put('discount_type', 4);
        }
        
        
        
        
        $shipping = $this->data->shippingMethod;
        $customerCountry = strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso);
        if(in_array($customerCountry, config('default.european_shipping_countries_iso'))){
            if ($customerCountry ==  'at') {
               $shippingAmount = $shipping->austria_amount && $shipping->is_not_austria_available == 0 ? $shipping->austria_amount : config('default.we_will_let_you_know');
               $shippingVat = $shipping->austria_tax_percentage;
            }elseif ($customerCountry ==  'be') {
                $shippingAmount = $shipping->belgium_amount && $shipping->is_not_belgium_available == 0 ? $shipping->belgium_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->belgium_tax_percentage;
            }elseif ($customerCountry ==  'bg') {
                $shippingAmount = $shipping->bulgaria_amount && $shipping->is_not_bulgaria_available == 0 ? $shipping->bulgaria_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->bulgaria_tax_percentage;
            }elseif ($customerCountry ==  'hr') {
                $shippingAmount = $shipping->croatia_amount && $shipping->is_not_croatia_available == 0 ? $shipping->croatia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->croatia_tax_percentage;
            }elseif ($customerCountry ==  'cy') {
                $shippingAmount = $shipping->republic_of_cyprus_amount && $shipping->is_not_republic_of_cyprus_available == 0 ? $shipping->republic_of_cyprus_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->republic_of_cyprus_tax_percentage;
            }elseif ($customerCountry ==  'cz') {
                $shippingAmount = $shipping->czech_republic_amount && $shipping->is_not_czech_republic_available == 0 ? $shipping->czech_republic_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->czech_republic_tax_percentage;
            }elseif ($customerCountry ==  'dk') {
                $shippingAmount = $shipping->denmark_amount && $shipping->is_not_denmark_available == 0 ? $shipping->denmark_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->denmark_tax_percentage;
            }elseif ($customerCountry ==  'ee') {
                $shippingAmount = $shipping->estonia_amount && $shipping->is_not_estonia_available == 0 ? $shipping->estonia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->estonia_tax_percentage;
            }elseif ($customerCountry ==  'fi') {
                $shippingAmount = $shipping->finland_amount && $shipping->is_not_finland_available == 0 ? $shipping->finland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->finland_tax_percentage;
            }elseif ($customerCountry ==  'fr') {
                $shippingAmount = $shipping->france_amount && $shipping->is_not_france_available == 0 ? $shipping->france_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->france_tax_percentage;
            }elseif ($customerCountry ==  'de') {
                $shippingAmount = $shipping->germany_amount && $shipping->is_not_germany_available == 0 ? $shipping->germany_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->germany_tax_percentage;
            }elseif ($customerCountry ==  'gr') {
                $shippingAmount = $shipping->greece_amount && $shipping->is_not_greece_available == 0 ? $shipping->greece_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->greece_tax_percentage;
            }elseif ($customerCountry ==  'hu') {
                $shippingAmount = $shipping->hungary_amount && $shipping->is_not_hungary_available == 0 ? $shipping->hungary_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->hungary_tax_percentage;
            }elseif ($customerCountry ==  'ie') {
                $shippingAmount = $shipping->ireland_amount && $shipping->is_not_ireland_available == 0 ? $shipping->ireland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->ireland_tax_percentage;
            }elseif ($customerCountry ==  'it') {
                $shippingAmount = $shipping->italy_amount && $shipping->is_not_italy_available == 0 ? $shipping->italy_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->italy_tax_percentage;
            }elseif ($customerCountry ==  'lv') {
                $shippingAmount = $shipping->latvia_amount && $shipping->is_not_latvia_available == 0 ? $shipping->latvia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->latvia_tax_percentage;
            }elseif ($customerCountry ==  'lt') {
                $shippingAmount = $shipping->lithuania_amount && $shipping->is_not_lithuania_available == 0 ? $shipping->lithuania_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->lithuania_tax_percentage;
            }elseif ($customerCountry ==  'lu') {
                $shippingAmount = $shipping->luxembourg_amount && $shipping->is_not_luxembourg_available == 0 ? $shipping->luxembourg_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->luxembourg_tax_percentage;
            }elseif ($customerCountry ==  'mt') {
                $shippingAmount = $shipping->malta_amount && $shipping->is_not_malta_available == 0 ? $shipping->malta_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->malta_tax_percentage;
            }elseif ($customerCountry ==  'nl') {
                $shippingAmount = $shipping->netherlands_amount && $shipping->is_not_netherlands_available == 0 ? $shipping->netherlands_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->netherlands_tax_percentage;
            }elseif ($customerCountry ==  'pl') {
                $shippingAmount = $shipping->poland_amount && $shipping->is_not_poland_available == 0 ? $shipping->poland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->poland_tax_percentage;
            }elseif ($customerCountry ==  'pt') {
                $shippingAmount = $shipping->portugal_amount && $shipping->is_not_portugal_available == 0 ? $shipping->portugal_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->portugal_tax_percentage;
            }elseif ($customerCountry ==  'ro') {
                $shippingAmount = $shipping->romania_amount && $shipping->is_not_romania_available == 0 ? $shipping->romania_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->romania_tax_percentage;
            }elseif ($customerCountry ==  'sk') {
                $shippingAmount = $shipping->slovakia_amount && $shipping->is_not_slovakia_available == 0 ? $shipping->slovakia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->slovakia_tax_percentage;
            }elseif ($customerCountry ==  'si') {
                $shippingAmount = $shipping->slovenia_amount && $shipping->is_not_slovenia_available == 0 ? $shipping->slovenia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->slovenia_tax_percentage;
            }elseif ($customerCountry ==  'es') {
                $shippingAmount = $shipping->spain_amount && $shipping->is_not_spain_available == 0 ? $shipping->spain_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->spain_tax_percentage;
            }elseif ($customerCountry ==  'se') {
                $shippingAmount = $shipping->sweden_amount && $shipping->is_not_sweden_available == 0 ? $shipping->sweden_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->sweden_tax_percentage;
            }else{
                $shippingAmount = 0;
            }
        }elseif(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.uk_countries_iso'))){
            $shippingAmount = $shipping->uk_amount && $shipping->is_not_uk_available == 0 ? $shipping->uk_amount : config('default.we_will_let_you_know');
            $shippingVat = $shipping->uk_tax_percentage;
            // dd( $shippingAmount);
        }else{
            $shippingAmount = $shipping->global_amount && $shipping->is_not_globally_available == 0 ? $shipping->global_amount : config('default.we_will_let_you_know');
            $shippingVat = $shipping->global_tax_percentage;
        }
        
        if(!is_numeric($shippingAmount)){
            $shippingAmount = 0;
        }

        // Shipping ///////////////////////////////////////
        // $shippingVat =  number_format(0, 2);
        // $shippingAmount =  number_format(0, 2);
        // $shippingAmountAndShippingTax = $this->data->shipping + $this->data->shipping_vat;
        $shippingAmountAndShippingTax = $shippingAmount;
        // dd($this->data->shippingMethod->id);
        if ($this->data->shipping_id) {
            // if ((in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $subTotalWithoutVatAmount >= 40 && ($this->data->shippingMethod->id == 21 || $this->data->shippingMethod->id == 22)) {
            //     $shippingVat =  number_format(0, 2);
            //     $shippingAmount =  number_format(0, 2);
            // }

            if ((in_array(strtolower($this->data->customer->is_same_as_billing == 1 ? $this->data->customer->billingCountry->iso : $this->data->customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $this->data->shippingMethod->is_free_shipping == 1) {
                if($this->data->customer->user->hasRole(['customer']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_normal_customers || $this->data->customer->user->hasRole(['cake_time_club']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_cake_time_club || $this->data->customer->user->hasRole(['trade_customer']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_trade){
                    $shippingVat =  number_format(0, 2);
                    $shippingAmount =  number_format(0, 2);
                }else{
                    // $shippingVat = $request->shipping_amount_with_tax / 1.2 * 0.2;
                    // $shippingAmount = $request->shipping_amount_with_tax - $shippingVat;
                    $shippingVat = $shippingAmountAndShippingTax / 1.2 * 0.2;
                    $shippingAmount = $shippingAmountAndShippingTax;
                }
            }
            else{
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                    $shippingVat = $shippingAmountAndShippingTax / 1.2 * 0.2;
                    $shippingAmount = $shippingAmountAndShippingTax;
                }else{
                    $shippingVat = 0;
                    $shippingAmount = $shippingAmountAndShippingTax;
                }
            }
        }

        // Vat ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])) {
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $totalVatAmount = $sumOfCouponTotalVat;
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $totalVatAmount = $sumOfFivePercentageOrderValueTotalVat;
                }elseif($subTotalWithoutVatAmount >= 100){
                    $totalVatAmount = $sumOfOrderValueTotalVat;
                }else{
                    $totalVatAmount = $sumOfTotalVat;
                }
            }
        }else{ //Trade ans cake time club customers
            $totalVatAmount = $sumOfTotalVat;
        }

        // Grand Total1 ///////////////////////////////////////
        if ($this->data->customer->user->hasRole(['customer'])) {
            if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                $grandTotal = $sumOfCouponNetPrice + $shippingAmount + $sumOfCouponTotalVat;
            }else{
                if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                    $grandTotal = $sumOfsumOfFivePercentageOrderValueNetPrice + $shippingAmount + $totalVatAmount;
                }elseif($subTotalWithoutVatAmount >= 100){
                    $grandTotal = $sumOfOrderValueNetPrice + $shippingAmount + $totalVatAmount;
                }else{
                    $grandTotal = $totalNormalPriceAmount + $shippingAmount + $totalVatAmount;
                }
            }
        }else{ //Trade ans cake time club customers
            $grandTotal = $totalNormalPriceAmount + $shippingAmount + $totalVatAmount;
        }

        // Save SubTotal
        $this->data->amount = $subTotal;

        // Save total Discount amount
        $this->data->total_discount = $totalDiscountAmount;

        // Applied Discount Type
        $this->data->discount_type = session('discount_type');

        // discount amount over hunder
        // $this->data->order_value_discount_over_hundred = $totalDiscountAmount;
        // $this->data->old_order_value_discount_over_hundred = $totalDiscountAmount; 

        // $this->data->order_value_discount = $totalDiscountAmount;
        // $this->data->old_order_value_discount = $totalDiscountAmount;

        $this->data->order_value_discount_percentage = $this->option->order_value_discount_50_100;
        $this->data->order_value_discount_percentage_over_100 = $this->option->order_value_discount_over_100;

        // Save Coupon Amount
        $this->data->coupon_amount = $totalCouponDiscountAmount;

        //Save Shipping
        $this->data->shipping = $shippingAmount - $shippingVat;

        // Save all VAT
        $this->data->product_vat = $totalVatAmount;
        $this->data->shipping_vat = $shippingVat;
        $this->data->vat = $totalVatAmount + $shippingVat;

        // Save grand Total
        $this->data->grand_total = $grandTotal;
        $this->data->save();


        /////
        $orderItems = null;
        $dt = new DateTime();
        foreach ($cartItems as $item) {
            // Line NET ////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])){
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage){
                         if ($item->product->vat != 0){
                            $line_net = number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity ,2);
                        }
                        else{
                            $line_net = number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity ,2);
                        }
                    }
                    elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                        if ($item->product->vat != 0) {
                            $line_net = number_format($item->cart_price / 1.2 * $item->quantity ,2);
                        }
                        else{
                            $line_net = number_format($item->cart_price * $item->quantity ,2);
                        }
                    }
                }
                else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_50_100){
                            if ($item->product->vat != 0){
                                $line_net =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity ,2);
                            }else{
                                $line_net =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity ,2);
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                            if ($item->product->vat != 0) {
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity ,2);
                            }
                            else {
                                $line_net = number_format($item->cart_price * $item->quantity ,2);
                            }
                        } 
                    }
                    elseif($subTotalWithoutVatAmount >= 100){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_over_100){
                            if ($item->product->vat != 0){
                                $line_net = number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity  ,2);
                            }
                            else{
                                $line_net = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity ,2);
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                            if ($item->product->vat != 0) {
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity,2);
                            }
                            else{
                                $line_net = number_format($item->cart_price * $item->quantity,2);
                            }
                        }
                    }
                    else{
                        if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                            $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                        }
                        else{
                            if ($item->product->vat != 0){
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                            }
                            else{
                                $line_net = number_format(($item->quantity * $item->cart_price), 2);
                            }
                        }
                    }
                }
            }else{ //trade and caketime club customers
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                }else{
                    if ($item->product->vat != 0){
                        $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                    }else{
                        $line_net = number_format(($item->quantity * $item->cart_price), 2);
                    }
                }
            }

            // NET Price////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])){
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    if ($item->product->discount_percentage < $this->data->coupon->percentage){
                         if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                             $net_price =  number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
                         }
                         else{
                              if ($item->product->vat != 0){
                                 $net_price =  number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
                              }
                             else{
                                 $net_price =  number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) ,2);
                             }
                         }
                    }
                    elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                         if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                             $net_price =  number_format($item->cart_price / 1.2,2);
                         }
                         else{
                             if ($item->product->vat != 0){
                                 $net_price =  number_format($item->cart_price / 1.2,2);
                             }
                             else{
                                 $net_price =  number_format($item->cart_price,2);
                             }
                         }
                    }
                }
                else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_50_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
                                }
                                else{
                                    $net_price =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) ,2);
                                }
                            }
                        }   
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                $net_price =  number_format($item->cart_price / 1.2,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format($item->cart_price / 1.2,2);
                                }
                                else{
                                    $net_price =  number_format($item->cart_price,2);
                                }
                            }
                        }
                    }
                    elseif($subTotalWithoutVatAmount >= 100){
                        if ($item->product->discount_percentage < $this->option->order_value_discount_over_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
                                }
                                else{
                                    $net_price =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) ,2);
                                }
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                $net_price =  number_format($item->cart_price / 1.2,2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price =  number_format($item->cart_price / 1.2,2);
                                }
                                else{
                                    $net_price =  number_format($item->cart_price,2);
                                }
                            }
                        }
                    }
                    else{
                        if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                            $net_price = number_format($item->cart_price / 1.2, 2);
                        }
                        else{
                            if ($item->product->vat != 0){
                                $net_price = number_format($item->cart_price / 1.2, 2);
                            }
                            else{
                                $net_price = number_format($item->cart_price, 2);
                            }
                        }
                    }
                }
            }else{ // Trade, Cake time customers
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    $net_price = number_format($item->cart_price / 1.2, 2);
                }
                else{
                    if ($item->product->vat != 0){
                        $net_price = number_format($item->cart_price / 1.2, 2);
                    }
                    else{
                        $net_price = number_format($item->cart_price, 2);
                    }
                }  
            }
               
            // Vat ////////////////////////////////////
            if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                if ($this->data->customer->user->hasRole(['customer'])){
                    if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                        if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                            $vat_amount = number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2  ,2);
                        }
                        elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                            $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                        }
                    }
                    else{
                        if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                                $vat_amount = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2  ,2);
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                                $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                            }
                        }
                        elseif($subTotalWithoutVatAmount >= 100){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                                $vat_amount = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2  ,2);
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                                $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                            }
                        }
                        else{
                            $vat_amount =number_format($item->cart_price / 1.2 * 0.2, 2);
                        }
                    }
                }
                else{
                    $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                }
            }else{
                $vat_amount = number_format(0,2);
            }

            $orderItems[] = [
                'order_id' => $request->oid,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'old_quantity' => $item->quantity,
                'cart_price' => $item->cart_price,
                'price' => $net_price,
                'vat' => $vat_amount,
                'old_vat' => $vat_amount,
                'color_id' => $item->product->color_id,
                'is_product_discount' => $item->product->discount_percentage ? 1 : 0,
                'created_at' => $dt->format('Y-m-d H:i:s'),
                'updated_at' => $dt->format('Y-m-d H:i:s'),
            ];
            $this->orderItem->where('id', $item->id)->update(['price' => $net_price,'vat' => $vat_amount, 'old_vat' =>$vat_amount]);
        }

        // After Added new product
        $newCartItems = $this->orderItem->where('order_id',$id)->get();
        foreach ($newCartItems as $row) {
             $totalNewVatAmount[] = $row->vat * $row->quantity;
        }
        $sumOfTotalNewVatAmount = array_sum($totalNewVatAmount);// dd($sumOfTotalNewVatAmount);

        // Update all VAT
        $this->data->product_vat = $sumOfTotalNewVatAmount;
        // $this->data->old_product_vat = $sumOfTotalNewVatAmount;  // Keep Track
        $this->data->shipping_vat = $shippingVat;
        // $this->data->old_shipping_vat = $shippingVat;  // Keep Track
        $this->data->vat = $sumOfTotalNewVatAmount + $shippingVat;
        // $this->data->old_vat = $sumOfTotalNewVatAmount + $shippingVat;  // Keep Track

        // Update final grand Total
        $this->data->grand_total = $subTotal + $this->data->vat + $this->data->shipping;
        // $this->data->old_grand_total = $grandTotal; //keepTrack
        $this->data->save();

        $sessionMsg = $this->orderItem->product->name;
        return redirect()->back()->with('success', 'Product '.$sessionMsg.' quantity has been addedd');
    }


    //Delete ordered Item /////////////////////
    public function get_force_delete_ordered_items(Request $request, $id)
    {
        $module = $this->module;
        $dataDelete = $this->orderItem->where('id', $id)->first();

        // Updated Product Info
        $product = $this->orderItem->product;

        // Ordered Customer
        $customer = $this->data->find($dataDelete->order_id)->customer;

        // Updating Order Details
        $this->data = $this->data->find($dataDelete->order_id);

        if($dataDelete) {
            $dataDelete->forceDelete();

            $cartItems = $this->orderItem->where('order_id',$dataDelete->order_id)->get();

            //ordered Sub Total****************************************************
            $order_price[] = 0;
            foreach ($cartItems as $row) {
                $order_price[] = $row->quantity * $row->cart_price;
            }
            $orderedSubTotal = array_sum($order_price);
            // dd($orderedSubTotal . PHP_EOL);
            //*******************************************************************

            // Total Vat
            $vatAmounts[] = 0;
            foreach ($cartItems as $row) {
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $row->vat != 0){
                    $vatAmounts[] = $row->cart_price / 1.2 * 0.2 * $row->quantity;
                    // $vatAmounts[] = ($row->cart_price + $row->vat) / 1.2 * 0.2 * $row->quantity;
                }else{
                    $vatAmounts[] = 0;
                }
            }
            $sumOfTotalVat = array_sum($vatAmounts);
            // dd($sumOfTotalVat . PHP_EOL);
            $subTotalWithoutVatAmount = $orderedSubTotal - $sumOfTotalVat; 
            // print_r($subTotalWithoutVatAmount . PHP_EOL);


            // Normal Discount | ok
            $normalDiscount[] = 0;
            foreach ($cartItems as $item) {
                $normalDiscount[] = number_format(($item->product->price - $item->cart_price),2) * $item->quantity;
                // $normalDiscount[] = ($item->product->price - $item->vat - $item->cart_price) * $item->quantity;
            }
            $sumOfTotalNormalDiscount = array_sum($normalDiscount);
            // dd($sumOfTotalNormalDiscount . PHP_EOL);


            // totalNormalPrice | ok
            $totalNormalPrice[] = 0;
            foreach ($cartItems as $item) {
                if ($item->product->vat != 0){
                    $totalNormalPrice[] =$item->cart_price / 1.2 * $item->quantity;
                }
                else{
                    $totalNormalPrice[] = $item->quantity * $item->cart_price;
                }
                // $totalNormalPrice[] = $item->quantity * $item->cart_price;
            }
            $totalNormalPriceAmount =  array_sum($totalNormalPrice);
            // print_r($totalNormalPrice);
            // dd($totalNormalPriceAmount . PHP_EOL);


            // Over Hundred Order value Dicount, over 100
            $applicable_ten_percentage_order_value_discoount[] = 0;
            $ten_percentage_order_value_discoount_over[] = 0;
            foreach ($cartItems as $row) {
                if ($row->product->discount_percentage < $this->option->order_value_discount_over_100) {
                    $applicable_ten_percentage_order_value_discoount[] = ($row->product->price * $this->option->order_value_discount_over_100 / 100) * $row->quantity;
                }
                if ($row->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                    $ten_percentage_order_value_discoount_over[] = ($row->product->price - $row->cart_price) * $row->quantity;
                    // $ten_percentage_order_value_discoount_over[] = ($row->product->price - $row->cart_price - $row->vat) * $row->quantity;
                }
            }
            $sumOfApplicableTenPercentageOrderValueDiscount =  array_sum($applicable_ten_percentage_order_value_discoount);
            $sumOfTenPercentageOrderValueDiscountOver =  array_sum($ten_percentage_order_value_discoount_over);
            $sumOfTotalOrderValueDiscountAmount = $sumOfApplicableTenPercentageOrderValueDiscount + $sumOfTenPercentageOrderValueDiscountOver;  
            // dd($sumOfTotalOrderValueDiscountAmount . PHP_EOL);


            // 50 - 100 Order value Dicount
            $applicable_five_percentage_order_value_discoount[] = 0;
            $five_percentage_order_value_discoount_over[] = 0;
            foreach ($cartItems as $item) {
                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                    $applicable_five_percentage_order_value_discoount[] = ($item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                }
                if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                    $five_percentage_order_value_discoount_over[] = ($item->product->price - $item->cart_price) * $item->quantity;
                    // $five_percentage_order_value_discoount_over[] = ($item->product->price - $item->cart_price - $row->vat) * $item->quantity;
                }
            }
            $sumOfApplicableFivePercentageOrderValueDiscount =  array_sum($applicable_five_percentage_order_value_discoount);
            $sumOfFivePercentageOrderValueDiscountOver =  array_sum($five_percentage_order_value_discoount_over);
            $sumOfFivePercentageTotalOrderValueDiscountAmount = $sumOfApplicableFivePercentageOrderValueDiscount + $sumOfFivePercentageOrderValueDiscountOver;  // print_r($sumOfFivePercentageTotalOrderValueDiscountAmount . PHP_EOL);


            // Coupon
            // $coupons = $this->coupon->where('status',1)->get();
            // $coupon_code = Session::get('coupon');


            // Coupon code Discounts
            // dd($this->data->coupon_amount);
            if ($this->data->coupon_id) {
                $couponDiscounts[] = 0;
                $couponDiscountsOver[] = 0;
                foreach ($cartItems as $row) {
                    if ($row->product->discount_percentage < $this->data->coupon->percentage) {
                        $couponDiscounts[] = ($row->product->price * $this->data->coupon->percentage / 100) * $row->quantity;
                    }
                    if ($row->product->discount_percentage >= $this->data->coupon->percentage) {
                        $couponDiscountsOver[] = ($row->product->price - $row->cart_price) * $row->quantity;
                    }
                }
                $sumOfcouponDiscounts = array_sum($couponDiscounts); //print_r($couponDiscounts); echo "<pre>";print_r($couponDiscounts );echo "</pre>";
                $sumOfcouponDiscountsOver = array_sum($couponDiscountsOver); // print_r($sumOfcouponDiscountsOver . PHP_EOL); echo "<pre>"; print_r($couponDiscountsOver ); echo "</pre>";
                $totalCouponDiscountAmount = $sumOfcouponDiscounts + $sumOfcouponDiscountsOver; //print_r($totalCouponDiscountAmount . PHP_EOL);
            }else{
                $totalCouponDiscountAmount = 0;
            }


            // Coupon sub total
            if ($this->data->coupon_id) {
                $coupon_sub_total[] = 0;
                $coupon_sub_total_over[] = 0;
                foreach ($cartItems as $item) {
                    if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                        if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                            if ($item->product->vat != 0) {
                                $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity;
                            }
                            if ($item->product->vat == 0) {
                                $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity;
                            }
                        }
                        if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                            if ($item->product->vat != 0) {
                                $coupon_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                            }
                            if ($item->product->vat == 0) {
                                $coupon_sub_total_over[] = $item->cart_price * $item->quantity;
                            }
                        }
                    }
                    else{
                        if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                            if ($item->product->vat != 0) {
                                $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity;
                            }
                            if ($item->product->vat == 0) {
                                $coupon_sub_total[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity;
                            }
                        }
                        if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                            if ($item->product->vat != 0) {
                                $coupon_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                            }
                            if ($item->product->vat == 0) {
                                $coupon_sub_total_over[] = $item->cart_price * $item->quantity;
                            }
                        }
                    }
                }
                $sumOfCouponSubTotal =  array_sum($coupon_sub_total);
                $sumOfCouponSubTotalOver =  array_sum($coupon_sub_total_over);
                $sumOfCouponNetPrice = $sumOfCouponSubTotal + $sumOfCouponSubTotalOver;
                //print_r($sumOfCouponNetPrice . PHP_EOL);
            }else{
                $sumOfCouponNetPrice = 0;
            } 

            
            // Coupon Vat
            if ($this->data->coupon_id) {
                $coupon_vat_amount[] = 0;
                $coupon_vat_amount_over[] = 0;
                $sumOfCouponTotalVat = 0;
                foreach ($cartItems as $item) {
                    if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                        if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                            $coupon_vat_amount[] = ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2 * $item->quantity;
                        }
                        if ($item->product->discount_percentage >= $this->data->coupon->percentage) {
                            $coupon_vat_amount_over[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                        }
                    }
                }
                $sumOfCouponValueVatAmoount =  array_sum($coupon_vat_amount);
                $sumOfCouponVatAmoountOver =  array_sum($coupon_vat_amount_over);
                $sumOfCouponTotalVat = $sumOfCouponValueVatAmoount + $sumOfCouponVatAmoountOver; 
                //print_r($sumOfCouponTotalVat . PHP_EOL);
            }



            // Order Value over hundred VAT
            $order_value_vat_amount[] = 0;
            $order_value_vat_amount_over[] = 0;
            foreach ($cartItems as $item) {
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                        $order_value_vat_amount[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2 * $item->quantity;
                    }
                    if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                        $order_value_vat_amount_over[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                    }
                }
            }
            $sumOfOrderValueVatAmoount =  array_sum($order_value_vat_amount);
            $sumOfOrderValueVatAmoountOver =  array_sum($order_value_vat_amount_over);
            $sumOfOrderValueTotalVat = $sumOfOrderValueVatAmoount + $sumOfOrderValueVatAmoountOver; 
            //print_r($sumOfOrderValueTotalVat . PHP_EOL);


            // Order Value over hundred VAT
            $order_value_vat_amount_five[] = 0;
            $order_value_vat_amount_over_five[] = 0;
            foreach ($cartItems as $item) {
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                        $order_value_vat_amount_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2 * $item->quantity;
                    }
                    if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                        $order_value_vat_amount_over_five[] = $item->cart_price / 1.2 * 0.2 * $item->quantity;
                    }
                }
            }
            $sumOfFivePercentageOrderValueVatAmoount =  array_sum($order_value_vat_amount_five);
            $sumOfOrderValueVatAmoountOverFive =  array_sum($order_value_vat_amount_over_five);
            $sumOfFivePercentageOrderValueTotalVat = $sumOfFivePercentageOrderValueVatAmoount + $sumOfOrderValueVatAmoountOverFive; //print_r($sumOfFivePercentageOrderValueTotalVat . PHP_EOL);


            // Order Value Sub Total
            $order_value_sub_total[] = 0;
            $order_value_sub_total_over[] = 0;
            foreach ($cartItems as $item) {
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                    if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total_over[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
                else{
                    if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->option->order_value_discount_over_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total_over[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total_over[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
            }
            $sumOfOrderValueSubTotal =  array_sum($order_value_sub_total);
            $sumOfOrderValueSubTotalOver =  array_sum($order_value_sub_total_over);
            $sumOfOrderValueNetPrice = $sumOfOrderValueSubTotal + $sumOfOrderValueSubTotalOver; //print_r( $sumOfOrderValueNetPrice);



            // Order Value Sub Total 50 to 100
            $order_value_sub_total_five[] = 0;
            $order_value_sub_total_over_five[] = 0;
            foreach ($cartItems as $item) {
                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                    if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total_over_five[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total_over_five[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
                else{
                    if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total_five[] = ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity;
                        }
                    }
                    if ($item->product->discount_percentage >= $this->option->order_value_discount_50_100) {
                        if ($item->product->vat != 0) {
                            $order_value_sub_total_over_five[] = $item->cart_price / 1.2 * $item->quantity;
                        }
                        if ($item->product->vat == 0) {
                            $order_value_sub_total_over_five[] = $item->cart_price * $item->quantity;
                        }
                    }
                }
            }
            $sumOfFivePercentageOrderValueSubTotal =  array_sum($order_value_sub_total_five);
            $sumOfOrderValueSubTotalOverFivePercentage =  array_sum($order_value_sub_total_over_five);
            $sumOfsumOfFivePercentageOrderValueNetPrice = $sumOfFivePercentageOrderValueSubTotal + $sumOfOrderValueSubTotalOverFivePercentage; //print_r( $sumOfsumOfFivePercentageOrderValueNetPrice);
            


            // Sub Total ///////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])){
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    $subTotal = $sumOfCouponNetPrice;
                }else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        $subTotal = $sumOfsumOfFivePercentageOrderValueNetPrice;
                    }elseif($subTotalWithoutVatAmount >= 100){
                        $subTotal = $sumOfOrderValueNetPrice;
                    }else{
                        $subTotal = $totalNormalPriceAmount;                    
                    }
                }
            }else{
                $subTotal = $totalNormalPriceAmount;
            }

            // dd($subTotalWithoutVatAmount);

            // Discount Amount ///////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])) {
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    $totalDiscountAmount = $totalCouponDiscountAmount;
                    Session::put('coupon_amount', $totalDiscountAmount);
                    Session::put('discount_type', 1);
                }else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        $totalDiscountAmount = $sumOfFivePercentageTotalOrderValueDiscountAmount;
                        Session::put('coupon_amount', $totalDiscountAmount);
                        Session::put('discount_type', 2);
                    }elseif($subTotalWithoutVatAmount >= 100){
                        $totalDiscountAmount = $sumOfTotalOrderValueDiscountAmount;
                        Session::put('coupon_amount', $totalDiscountAmount);
                        Session::put('discount_type', 3);
                    }else{
                        $totalDiscountAmount = $sumOfTotalNormalDiscount;
                        Session::put('coupon_amount', $totalDiscountAmount);
                        Session::put('discount_type', 4);
                    }
                }
            }else{ //Trade ans cake time club customers
                $totalDiscountAmount = $sumOfTotalNormalDiscount;
                Session::put('coupon_amount', $totalDiscountAmount);
                Session::put('discount_type', 4);
            }
            
            
                    $shipping = $this->data->shippingMethod;
        $customerCountry = strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso);
        if(in_array($customerCountry, config('default.european_shipping_countries_iso'))){
            if ($customerCountry ==  'at') {
               $shippingAmount = $shipping->austria_amount && $shipping->is_not_austria_available == 0 ? $shipping->austria_amount : config('default.we_will_let_you_know');
               $shippingVat = $shipping->austria_tax_percentage;
            }elseif ($customerCountry ==  'be') {
                $shippingAmount = $shipping->belgium_amount && $shipping->is_not_belgium_available == 0 ? $shipping->belgium_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->belgium_tax_percentage;
            }elseif ($customerCountry ==  'bg') {
                $shippingAmount = $shipping->bulgaria_amount && $shipping->is_not_bulgaria_available == 0 ? $shipping->bulgaria_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->bulgaria_tax_percentage;
            }elseif ($customerCountry ==  'hr') {
                $shippingAmount = $shipping->croatia_amount && $shipping->is_not_croatia_available == 0 ? $shipping->croatia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->croatia_tax_percentage;
            }elseif ($customerCountry ==  'cy') {
                $shippingAmount = $shipping->republic_of_cyprus_amount && $shipping->is_not_republic_of_cyprus_available == 0 ? $shipping->republic_of_cyprus_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->republic_of_cyprus_tax_percentage;
            }elseif ($customerCountry ==  'cz') {
                $shippingAmount = $shipping->czech_republic_amount && $shipping->is_not_czech_republic_available == 0 ? $shipping->czech_republic_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->czech_republic_tax_percentage;
            }elseif ($customerCountry ==  'dk') {
                $shippingAmount = $shipping->denmark_amount && $shipping->is_not_denmark_available == 0 ? $shipping->denmark_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->denmark_tax_percentage;
            }elseif ($customerCountry ==  'ee') {
                $shippingAmount = $shipping->estonia_amount && $shipping->is_not_estonia_available == 0 ? $shipping->estonia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->estonia_tax_percentage;
            }elseif ($customerCountry ==  'fi') {
                $shippingAmount = $shipping->finland_amount && $shipping->is_not_finland_available == 0 ? $shipping->finland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->finland_tax_percentage;
            }elseif ($customerCountry ==  'fr') {
                $shippingAmount = $shipping->france_amount && $shipping->is_not_france_available == 0 ? $shipping->france_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->france_tax_percentage;
            }elseif ($customerCountry ==  'de') {
                $shippingAmount = $shipping->germany_amount && $shipping->is_not_germany_available == 0 ? $shipping->germany_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->germany_tax_percentage;
            }elseif ($customerCountry ==  'gr') {
                $shippingAmount = $shipping->greece_amount && $shipping->is_not_greece_available == 0 ? $shipping->greece_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->greece_tax_percentage;
            }elseif ($customerCountry ==  'hu') {
                $shippingAmount = $shipping->hungary_amount && $shipping->is_not_hungary_available == 0 ? $shipping->hungary_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->hungary_tax_percentage;
            }elseif ($customerCountry ==  'ie') {
                $shippingAmount = $shipping->ireland_amount && $shipping->is_not_ireland_available == 0 ? $shipping->ireland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->ireland_tax_percentage;
            }elseif ($customerCountry ==  'it') {
                $shippingAmount = $shipping->italy_amount && $shipping->is_not_italy_available == 0 ? $shipping->italy_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->italy_tax_percentage;
            }elseif ($customerCountry ==  'lv') {
                $shippingAmount = $shipping->latvia_amount && $shipping->is_not_latvia_available == 0 ? $shipping->latvia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->latvia_tax_percentage;
            }elseif ($customerCountry ==  'lt') {
                $shippingAmount = $shipping->lithuania_amount && $shipping->is_not_lithuania_available == 0 ? $shipping->lithuania_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->lithuania_tax_percentage;
            }elseif ($customerCountry ==  'lu') {
                $shippingAmount = $shipping->luxembourg_amount && $shipping->is_not_luxembourg_available == 0 ? $shipping->luxembourg_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->luxembourg_tax_percentage;
            }elseif ($customerCountry ==  'mt') {
                $shippingAmount = $shipping->malta_amount && $shipping->is_not_malta_available == 0 ? $shipping->malta_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->malta_tax_percentage;
            }elseif ($customerCountry ==  'nl') {
                $shippingAmount = $shipping->netherlands_amount && $shipping->is_not_netherlands_available == 0 ? $shipping->netherlands_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->netherlands_tax_percentage;
            }elseif ($customerCountry ==  'pl') {
                $shippingAmount = $shipping->poland_amount && $shipping->is_not_poland_available == 0 ? $shipping->poland_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->poland_tax_percentage;
            }elseif ($customerCountry ==  'pt') {
                $shippingAmount = $shipping->portugal_amount && $shipping->is_not_portugal_available == 0 ? $shipping->portugal_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->portugal_tax_percentage;
            }elseif ($customerCountry ==  'ro') {
                $shippingAmount = $shipping->romania_amount && $shipping->is_not_romania_available == 0 ? $shipping->romania_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->romania_tax_percentage;
            }elseif ($customerCountry ==  'sk') {
                $shippingAmount = $shipping->slovakia_amount && $shipping->is_not_slovakia_available == 0 ? $shipping->slovakia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->slovakia_tax_percentage;
            }elseif ($customerCountry ==  'si') {
                $shippingAmount = $shipping->slovenia_amount && $shipping->is_not_slovenia_available == 0 ? $shipping->slovenia_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->slovenia_tax_percentage;
            }elseif ($customerCountry ==  'es') {
                $shippingAmount = $shipping->spain_amount && $shipping->is_not_spain_available == 0 ? $shipping->spain_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->spain_tax_percentage;
            }elseif ($customerCountry ==  'se') {
                $shippingAmount = $shipping->sweden_amount && $shipping->is_not_sweden_available == 0 ? $shipping->sweden_amount : config('default.we_will_let_you_know');
                $shippingVat = $shipping->sweden_tax_percentage;
            }else{
                $shippingAmount = 0;
            }
        }elseif(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.uk_countries_iso'))){
            $shippingAmount = $shipping->uk_amount && $shipping->is_not_uk_available == 0 ? $shipping->uk_amount : config('default.we_will_let_you_know');
            $shippingVat = $shipping->uk_tax_percentage;
            // dd( $shippingAmount);
        }else{
            $shippingAmount = $shipping->global_amount && $shipping->is_not_globally_available == 0 ? $shipping->global_amount : config('default.we_will_let_you_know');
            $shippingVat = $shipping->global_tax_percentage;
        }
        
        if(!is_numeric($shippingAmount)){
            $shippingAmount = 0;
        }

            // Shipping ///////////////////////////////////////
            // $shippingVat =  number_format(0, 2);
            // $shippingAmount =  number_format(0, 2);
            // $shippingAmountAndShippingTax = $this->data->shipping + $this->data->shipping_vat;
            $shippingAmountAndShippingTax = $shippingAmount;
            // dd($this->data->shippingMethod->id);
            if ($this->data->shipping_id) {
                // if ((in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $subTotalWithoutVatAmount >= 40 && ($this->data->shippingMethod->id == 21 || $this->data->shippingMethod->id == 22)) {
                //     $shippingVat =  number_format(0, 2);
                //     $shippingAmount =  number_format(0, 2);
                // }
                if ((in_array(strtolower($this->data->customer->is_same_as_billing == 1 ? $this->data->customer->billingCountry->iso : $this->data->customer->deliveryCountry->iso), config('default.uk_countries_iso'))) && $this->data->shippingMethod->is_free_shipping == 1) {
                    if($this->data->customer->user->hasRole(['customer']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_normal_customers || $this->data->customer->user->hasRole(['cake_time_club']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_cake_time_club || $this->data->customer->user->hasRole(['trade_customer']) && $subTotalWithoutVatAmount >= $this->option->free_shipping_over_amount_trade){
                        $shippingVat =  number_format(0, 2);
                        $shippingAmount =  number_format(0, 2);
                    }else{
                        // $shippingVat = $request->shipping_amount_with_tax / 1.2 * 0.2;
                        // $shippingAmount = $request->shipping_amount_with_tax - $shippingVat;
                        $shippingVat = $shippingAmountAndShippingTax / 1.2 * 0.2;
                        $shippingAmount = $shippingAmountAndShippingTax;
                    }
                }
                else{
                    if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso'))){
                        $shippingVat = $shippingAmountAndShippingTax / 1.2 * 0.2;
                        $shippingAmount = $shippingAmountAndShippingTax;
                    }else{
                        $shippingVat = 0;
                        $shippingAmount = $shippingAmountAndShippingTax;
                    }
                }
            }

            // Vat ///////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])) {
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    $totalVatAmount = $sumOfCouponTotalVat;
                }else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        $totalVatAmount = $sumOfFivePercentageOrderValueTotalVat;
                    }elseif($subTotalWithoutVatAmount >= 100){
                        $totalVatAmount = $sumOfOrderValueTotalVat;
                    }else{
                        $totalVatAmount = $sumOfTotalVat;
                    }
                }
            }else{ //Trade ans cake time club customers
                $totalVatAmount = $sumOfTotalVat;
            }

            // Grand Total ///////////////////////////////////////
            if ($this->data->customer->user->hasRole(['customer'])) {
                if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                    $grandTotal = $sumOfCouponNetPrice + $shippingAmount + $sumOfCouponTotalVat;
                }else{
                    if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                        $grandTotal = $sumOfsumOfFivePercentageOrderValueNetPrice + $shippingAmount + $totalVatAmount;
                    }elseif($subTotalWithoutVatAmount >= 100){
                        $grandTotal = $sumOfOrderValueNetPrice + $shippingAmount + $totalVatAmount;
                    }else{
                        $grandTotal = $totalNormalPriceAmount + $shippingAmount + $totalVatAmount;
                    }
                }
            }else{ //Trade ans cake time club customers
                $grandTotal = $totalNormalPriceAmount + $shippingAmount + $totalVatAmount;
            }

            // Save SubTotal
            $this->data->amount = $subTotal;

            // Save total Discount amount
            $this->data->total_discount = $totalDiscountAmount;

            // Applied Discount Type
            $this->data->discount_type = session('discount_type');

            // discount amount over hunder
            // $this->data->order_value_discount_over_hundred = $totalDiscountAmount;
            // $this->data->old_order_value_discount_over_hundred = $totalDiscountAmount; 

            // $this->data->order_value_discount = $totalDiscountAmount;
            // $this->data->old_order_value_discount = $totalDiscountAmount;

            $this->data->order_value_discount_percentage = $this->option->order_value_discount_50_100;
            $this->data->order_value_discount_percentage_over_100 = $this->option->order_value_discount_over_100;

            // Save Coupon Amount
            $this->data->coupon_amount = $totalCouponDiscountAmount;

            //Save Shipping
            $this->data->shipping = $shippingAmount - $shippingVat;

            // Save all VAT
            $this->data->product_vat = $totalVatAmount;
            $this->data->shipping_vat = $shippingVat;
            $this->data->vat = $totalVatAmount + $shippingVat;

            // Save grand Total
            $this->data->grand_total = $grandTotal;
            $this->data->save();


            /////
            $orderItems = null;
            $dt = new DateTime();
            foreach ($cartItems as $item) {
                // Line NET ////////////////////////////////////
                if ($this->data->customer->user->hasRole(['customer'])){
                    if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                        if ($item->product->discount_percentage < $this->data->coupon->percentage){
                             if ($item->product->vat != 0){
                                $line_net = number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * $item->quantity ,2);
                            }
                            else{
                                $line_net = number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) * $item->quantity ,2);
                            }
                        }
                        elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                            if ($item->product->vat != 0) {
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity ,2);
                            }
                            else{
                                $line_net = number_format($item->cart_price * $item->quantity ,2);
                            }
                        }
                    }
                    else{
                        if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_50_100){
                                if ($item->product->vat != 0){
                                    $line_net =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * $item->quantity ,2);
                                }else{
                                    $line_net =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) * $item->quantity ,2);
                                }
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                                if ($item->product->vat != 0) {
                                    $line_net = number_format($item->cart_price / 1.2 * $item->quantity ,2);
                                }
                                else {
                                    $line_net = number_format($item->cart_price * $item->quantity ,2);
                                }
                            } 
                        }
                        elseif($subTotalWithoutVatAmount >= 100){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_over_100){
                                if ($item->product->vat != 0){
                                    $line_net = number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * $item->quantity  ,2);
                                }
                                else{
                                    $line_net = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) * $item->quantity ,2);
                                }
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                                if ($item->product->vat != 0) {
                                    $line_net = number_format($item->cart_price / 1.2 * $item->quantity,2);
                                }
                                else{
                                    $line_net = number_format($item->cart_price * $item->quantity,2);
                                }
                            }
                        }
                        else{
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                                }
                                else{
                                    $line_net = number_format(($item->quantity * $item->cart_price), 2);
                                }
                            }
                        }
                    }
                }else{ //trade and caketime club customers
                    if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                        $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                    }else{
                        if ($item->product->vat != 0){
                            $line_net = number_format($item->cart_price / 1.2 * $item->quantity, 2);
                        }else{
                            $line_net = number_format(($item->quantity * $item->cart_price), 2);
                        }
                    }
                }

                // NET Price////////////////////////////////////
                if ($this->data->customer->user->hasRole(['customer'])){
                    if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                        if ($item->product->discount_percentage < $this->data->coupon->percentage){
                             if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                 $net_price =  number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
                             }
                             else{
                                  if ($item->product->vat != 0){
                                     $net_price =  number_format( ($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2  ,2);
                                  }
                                 else{
                                     $net_price =  number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) ,2);
                                 }
                             }
                        }
                        elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                             if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                 $net_price =  number_format($item->cart_price / 1.2,2);
                             }
                             else{
                                 if ($item->product->vat != 0){
                                     $net_price =  number_format($item->cart_price / 1.2,2);
                                 }
                                 else{
                                     $net_price =  number_format($item->cart_price,2);
                                 }
                             }
                        }
                    }
                    else{
                        if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_50_100){
                                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                    $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
                                }
                                else{
                                    if ($item->product->vat != 0){
                                        $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2  ,2);
                                    }
                                    else{
                                        $net_price =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) ,2);
                                    }
                                }
                            }   
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                    $net_price =  number_format($item->cart_price / 1.2,2);
                                }
                                else{
                                    if ($item->product->vat != 0){
                                        $net_price =  number_format($item->cart_price / 1.2,2);
                                    }
                                    else{
                                        $net_price =  number_format($item->cart_price,2);
                                    }
                                }
                            }
                        }
                        elseif($subTotalWithoutVatAmount >= 100){
                            if ($item->product->discount_percentage < $this->option->order_value_discount_over_100){
                                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                    $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
                                }
                                else{
                                    if ($item->product->vat != 0){
                                        $net_price =  number_format( ($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2  ,2);
                                    }
                                    else{
                                        $net_price =  number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) ,2);
                                    }
                                }
                            }
                            elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                                if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0) {
                                    $net_price =  number_format($item->cart_price / 1.2,2);
                                }
                                else{
                                    if ($item->product->vat != 0){
                                        $net_price =  number_format($item->cart_price / 1.2,2);
                                    }
                                    else{
                                        $net_price =  number_format($item->cart_price,2);
                                    }
                                }
                            }
                        }
                        else{
                            if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                                $net_price = number_format($item->cart_price / 1.2, 2);
                            }
                            else{
                                if ($item->product->vat != 0){
                                    $net_price = number_format($item->cart_price / 1.2, 2);
                                }
                                else{
                                    $net_price = number_format($item->cart_price, 2);
                                }
                            }
                        }
                    }
                }else{ // Trade, Cake time customers
                    if (in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                        $net_price = number_format($item->cart_price / 1.2, 2);
                    }
                    else{
                        if ($item->product->vat != 0){
                            $net_price = number_format($item->cart_price / 1.2, 2);
                        }
                        else{
                            $net_price = number_format($item->cart_price, 2);
                        }
                    }  
                }
                   
                // Vat ////////////////////////////////////
                if(in_array(strtolower($customer->is_same_as_billing == 1 ? $customer->billingCountry->iso : $customer->deliveryCountry->iso), config('default.european_countries_iso')) && $item->product->vat != 0){
                    if ($this->data->customer->user->hasRole(['customer'])){
                        if ($totalCouponDiscountAmount > $sumOfTotalOrderValueDiscountAmount || $totalCouponDiscountAmount > $sumOfFivePercentageTotalOrderValueDiscountAmount){
                            if ($item->product->discount_percentage < $this->data->coupon->percentage) {
                                $vat_amount = number_format(($item->product->price - $item->product->price * $this->data->coupon->percentage / 100) / 1.2 * 0.2  ,2);
                            }
                            elseif($item->product->discount_percentage >= $this->data->coupon->percentage){
                                $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                            }
                        }
                        else{
                            if ($subTotalWithoutVatAmount >= 50 && $subTotalWithoutVatAmount  <= 99.99){
                                if ($item->product->discount_percentage < $this->option->order_value_discount_50_100) {
                                    $vat_amount = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_50_100 / 100) / 1.2 * 0.2  ,2);
                                }
                                elseif($item->product->discount_percentage >= $this->option->order_value_discount_50_100){
                                    $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                                }
                            }
                            elseif($subTotalWithoutVatAmount >= 100){
                                if ($item->product->discount_percentage < $this->option->order_value_discount_over_100) {
                                    $vat_amount = number_format(($item->product->price - $item->product->price * $this->option->order_value_discount_over_100 / 100) / 1.2 * 0.2  ,2);
                                }
                                elseif($item->product->discount_percentage >= $this->option->order_value_discount_over_100){
                                    $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                                }
                            }
                            else{
                                $vat_amount =number_format($item->cart_price / 1.2 * 0.2, 2);
                            }
                        }
                    }
                    else{
                        $vat_amount = number_format($item->cart_price / 1.2 * 0.2, 2);
                    }
                }else{
                    $vat_amount = number_format(0,2);
                }

                $orderItems[] = [
                    'order_id' => $request->oid,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'old_quantity' => $item->quantity,
                    'cart_price' => $item->cart_price,
                    'price' => $net_price,
                    'vat' => $vat_amount,
                    'old_vat' => $vat_amount,
                    'color_id' => $item->product->color_id,
                    'is_product_discount' => $item->product->discount_percentage ? 1 : 0,
                    'created_at' => $dt->format('Y-m-d H:i:s'),
                    'updated_at' => $dt->format('Y-m-d H:i:s'),
                ];
                $this->orderItem->where('id', $item->id)->update(['price' => $net_price,'vat' => $vat_amount]);
            }

            return redirect()->back()->with('success', 'Product has been permanently deleted');
        }
        else{
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    } 


    // Repeat
    public function post_repeat_transaction(Request $request, $referenceTransactionId, $c_id)
    {
        $customer = $this->customer->find($c_id);
        try {
            $curl = curl_init();
             $postArray = [
               'transactionType' => 'Repeat',
               'referenceTransactionId' => substr($referenceTransactionId, 1, -1),
               'vendorTxCode' => 'repeat-'.$customer->id.'-'.$request->order_no_repeat.'-'.time(),
               'amount' =>  (float)$request->repeat_amount*100,
               'currency' => 'GBP',
               'description' => $request->description,
               'shippingDetails' => [
                 'recipientFirstName' => $customer->first_name,
                 'recipientLastName' => $customer->last_name,
                 'shippingAddress1' => $customer->address1,
                 'shippingAddress2' => $customer->address2 ? $customer->address2 : 'null',
                 'shippingCity' => $customer->city,
                 'shippingPostalCode' => $customer->postal_code,
                 'shippingCountry' => $customer->billingCountry->iso,
               ],
             ];

            $postBody = json_encode($postArray);
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://pi-live.sagepay.com/api/v1/transactions",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $postBody,
              CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ZXRMNEJZa1EzVDEzbG5Xc3Nmdjl5UlpvSTJyc2lXeFcxODdZeDBDSDFJOUcyb20yYmM6d1R4eTZySGQxSlI2UzNwSmEzbURTMVlWalhWY21vWFpmVmlXZ205S0dGNWdnTjhHNVVINGhnNTI3SGFMbXV6aU0=",
                "Cache-Control: no-cache",
                "Content-Type: application/json"
              ),
            ));
             
            $response = curl_exec($curl);
            $response = json_decode($response, true);
            $err = curl_error($curl);
            curl_close($curl);
            // dd($response);
            if ($response["status"] === "Ok") {
                return redirect()->back()->with('success', $response['statusDetail'].'[Repeat Transaction]');
            }else{
                return redirect()->back()->with('error', 'Transaction not found!, Check your sagepay live account.');
            }
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // Refund
    public function post_refund_transaction(Request $request, $referenceTransactionId, $c_id)
    {
        $customer = $this->customer->find($c_id);
        try {
            $curl = curl_init();
             $postArray = [
               'transactionType' => 'Refund',
               'referenceTransactionId' => substr($referenceTransactionId, 1, -1),
                'vendorTxCode' => 'repeat-'.$customer->id.'-'.$request->order_no_refund.'-'.time(),
               'amount' =>  (float)$request->refund_amount * 100,
               'currency' => 'GBP',
               'description' => $request->description,
               'shippingDetails' => [
                'recipientFirstName' => $customer->first_name,
                 'recipientLastName' => $customer->last_name,
                 'shippingAddress1' => $customer->address1,
                 'shippingAddress2' => $customer->address2 ? $customer->address2 : 'null',
                 'shippingCity' => $customer->city,
                 'shippingPostalCode' => $customer->postal_code,
                 'shippingCountry' => $customer->billingCountry->iso,
               ],
             ];

            $postBody = json_encode($postArray);
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://pi-live.sagepay.com/api/v1/transactions",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $postBody,
              CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ZXRMNEJZa1EzVDEzbG5Xc3Nmdjl5UlpvSTJyc2lXeFcxODdZeDBDSDFJOUcyb20yYmM6d1R4eTZySGQxSlI2UzNwSmEzbURTMVlWalhWY21vWFpmVmlXZ205S0dGNWdnTjhHNVVINGhnNTI3SGFMbXV6aU0=",
                "Cache-Control: no-cache",
                "Content-Type: application/json"
              ),
            ));
             
            $response = curl_exec($curl);
            $response = json_decode($response, true);
            $err = curl_error($curl);
            curl_close($curl);
            // dd($response);
            if ($response["status"] === "Ok") {
                return redirect()->back()->with('success', $response['statusDetail'].'[Refund Transaction]');
            }else{
                return redirect()->back()->with('error', 'Transaction not found!, Check your sagepay live account.');
            }
        }
        catch (\Exception $exception){
            // return redirect()->back()->with('error', $exception->getMessage());
            return redirect()->back()->with('error', $response["description"] .' - '.$exception->getMessage());
        }
    }

    // Printing Invoice
    public function get_invoice($id)
    {
        $module = $this->module;
        $singleData = $this->data->find($id);
        $orderItems = $this->orderItem->where('order_id', $id)->get();
        $allProducts = $this->product->where('status', 1)->pluck('name', 'id');
        $countries = Country::pluck('nicename', 'id');
        return view('admin.'.$module.'.invoice_pdf',compact('singleData', 'module', 'orderItems','countries','allProducts'));
    }

    public function  update_status(Request $request)
    {
        $module = $this->module;

        $attributeName = $request->attribute_name;
        $orderId = $request->order_id;
        $status = $request->status;

        $orderStatusData = $this->data->find($orderId);
        $orderStatusData->$attributeName = $status;
        $orderStatusData->save();

        return redirect()->back()->with('success', 'Order Status Updated');
    }
}