@extends('admin.layouts.app')

@section('htmlheader_title')
    @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif | Customers
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active"> @if($singleData->id) Edit {{$module}} ID: {{$singleData->id}} @else Add New {{$module}} @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->id)
        <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
        <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                {!!csrf_field()!!}
                <?php $display = [''=>'Select a display area', 'Featured'=>'Featured', 'Special'=>'Special']; ?>
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                {!!Form::label("Upload Image")!!}
                                {!!Form::file('image', ['accept'=>'image/*'])!!}
                                @if($singleData->image)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="image-close"><a href="{{url('admin/'.$module.'/'.$singleData->id.'/image-delete')}}"><i class="fa fa-close red-text"></i></a></div>
                                            {{-- <img src="{{Storage::url($module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail"> --}}
                                            <img src="{{asset('storage/customers/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                                        </div>
                                    </div>
                                @else
                                    <img src="{{asset('site/images/defaults/avatar.jpg')}}" alt="Image" class="img-thumbnail">
                                @endif
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    {!!Form::label("First name")!!}
                                    {!!Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Enter first name'])!!}
                                    <em class="error-msg">{!!$errors->first('first_name')!!}</em>
                                </div>
                                <div class="col-sm-6 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    {!!Form::label("Last Name *")!!}
                                    {!!Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter last name'])!!}
                                    <em class="error-msg">{!!$errors->first('last_name')!!}</em>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {!!Form::label("Email *")!!}
                                    {!!Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email address'])!!}
                                    <em class="error-msg">{!!$errors->first('email')!!}</em>
                                </div>
                                <div class="col-sm-4 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                                    {!!Form::label("Mobile *")!!}
                                    {!!Form::tel('mobile', null, ['class' => 'form-control', 'placeholder' => 'Enter mobile phone'])!!}
                                    <em class="error-msg">{!!$errors->first('mobile')!!}</em>
                                </div>
                                <div class="col-sm-4 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    {!!Form::label("Phone")!!}
                                    {!!Form::tel('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter land line'])!!}
                                    <em class="error-msg">{!!$errors->first('phone')!!}</em>
                                </div>
                            </div>
                      
                              <hr>
                              <div id="billing-address">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="checkout-address1" class="control-label" >Billing Address *</label>
                                      {!!Form::textarea('address1', null, ['id'=>'checkout-address1', 'class' => 'form-control border-form-control', 'placeholder'=>'Enter Your Billing Address', 'rows' => '4'])!!}
                                      <em class="error-msg">{!!$errors->first('address1')!!}</em>
                                    </div>
                                  </div>
                                </div>
                             <div class="row">
                               <div class="col-sm-3">
                                 <div class="form-group">
                                   <label for="checkout-city" class="control-label" >City *</label>
                                   {!!Form::text('city', null, ['id'=>'checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City'])!!}
                                   <em class="error-msg">{!!$errors->first('city')!!}</em>
                                 </div>
                               </div>
                               
                               <div class="col-sm-3">
                                 <div class="form-group">
                                      <label for="checkout-state" class="control-label" >County *</label>
                                     {!!Form::text('state', null, ['id'=>'checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'County'])!!}
                                     <em class="error-msg">{!!$errors->first('state')!!}</em>
                                 </div>
                               </div>
                               <div class="col-sm-3">
                                 <div class="form-group">
                                   <label for="checkout-zip" class="control-label" > Post code *</label>
                                   {!!Form::text('postal_code', null, ['id'=>'checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Post code *'])!!}
                                   <em class="error-msg">{!!$errors->first('postal_code')!!}</em>
                                 </div>
                               </div>
                               <div class="col-sm-3">
                                 <div class="form-group">
                                   <label for="checkout-country" class="control-label" >Country *</label>
                                   {!!Form::select('billing_country_id', $countries, null, ['id'=>'checkout-country', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select country'])!!}
                                   <em class="error-msg">{!!$errors->first('country_id')!!}</em>
                                 </div>
                               </div>
                             </div>
                               </div>

                              <div class="form-group">
                                  <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" @if($singleData->is_same_as_billing == 1) checked @endif >
                                  <label>If the Delivery address is same as Billing address, please tick this check box.</label>
                              </div>

                              <div id="delivery-address" @if($singleData->is_same_as_billing == 1) style="display: none" @endif>
                              <hr>
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label for="checkout-address2" class="control-label">Delivery Address</label>
                                    {!!Form::textarea('address2', null, ['id'=>'d-checkout-address2', 'class' => 'form-control border-form-control', 'placeholder'=>'Enter Your Delivery Address', 'rows' => '4', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('address2')!!}</em>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="checkout-city" class="control-label" >City</label>
                                    {!!Form::text('delivery_city', null, ['id'=>'d-checkout-city', 'class' => 'form-control border-form-control', 'placeholder'=>'City', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('delivery_city')!!}</em>
                                  </div>
                                </div>
                               
                                
                                <div class="col-sm-3">
                                  <div class="form-group">
                                       <label for="checkout-state" class="control-label" >County *</label>
                                      {!!Form::text('delivery_state', null, ['id'=>'d-checkout-state', 'class' => 'form-control border-form-control', 'placeholder'=>'County', 'required'])!!}
                                      <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="checkout-zip" class="control-label" >Post code</label>
                                    {!!Form::text('delivery_postel_code', null, ['id'=>'d-checkout-zip', 'class' => 'form-control border-form-control', 'placeholder'=>'Post code *', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('delivery_postel_code')!!}</em>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="checkout-country" class="control-label" >Country</label>
                                    {!!Form::select('delivery_country_id', $countries, null, ['id'=>'d-checkout-country', 'class' => 'form-control border-form-control select2', 'placeholder'=>'Select country', 'required'])!!}
                                    <em class="error-msg">{!!$errors->first('delivery_country_id')!!}</em>
                                  </div>
                                </div>
                              </div>
                              </div>

                             {{--  <script>
                                  function leader_show() {
                                      var x = document.getElementById("delivery-address");
                                      if (x.style.display === "none") {
                                          x.style.display = "block";
                                      } else {
                                          x.style.display = "none";
                                      }
                                  }
                              </script> --}}

                              <script>
                                  function leader_show() {
                                      var x = document.getElementById("delivery-address");
                                      if (x.style.display === "none") {
                                          x.style.display = "block";
                                          $('#d-checkout-address2').prop('required',true);
                                          $('#d-checkout-city').prop('required',true);
                                          $('#d-checkout-state').prop('required',true);
                                          $('#d-checkout-zip').prop('required',true);
                                          $('#d-checkout-country').prop('required',true);
                                      } else {
                                          x.style.display = "none";
                                          $('#d-checkout-address2').removeAttr('required');
                                          $('#d-checkout-city').removeAttr('required');
                                          $('#d-checkout-state').removeAttr('required');
                                          $('#d-checkout-zip').removeAttr('required');
                                          $('#d-checkout-country').removeAttr('required');
                                      }
                                  }
                              </script>
                             

                          <hr>
                            {{-- <div class="row">
                                <div class="col-sm-12 form-group {{ $errors->has('payments_id') ? 'has-error' : '' }}">
                                    {!!Form::label("Payment Methods")!!}
                                    <div class="row">
                                        @foreach($paymentMethods as $payment)
                                            <div class="col-sm-4 col-xs-6 PB10">
                                                <span class="icheckbox_flat-green">
                                                {!!Form::checkbox('payments_id[]', $payment->id, null, ['class' => 'flat-red'])!!}
                                                </span>
                                                {{$payment->title}}
                                            </div>
                                        @endforeach
                                    </div>
                                    <em class="error-msg">{!!$errors->first('payments_id')!!}</em>
                                </div>
                            </div>
                          <hr> --}}



                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('discount_percentage') ? 'has-error' : '' }}">
                                    {!!Form::label("Discount *")!!}
                                    {!!Form::text('discount_percentage', null, ['class' => 'form-control', 'placeholder' => 'Enter discount percentage'])!!}
                                    <em class="error-msg">{!!$errors->first('discount_percentage')!!}</em>
                                </div>
                                {{-- @if($singleData->user->hasRole('customer')) --}}
                                <div class="col-sm-6 form-group {{ $errors->has('is_paid') ? 'has-error' : '' }}">
                                    @php $arr_status = ['0' => 'Not Paid', '1' => 'Paid', '2' => 'Not Required', '3' => 'Cancelled'] @endphp
                                    {!!Form::label("Payment Status")!!}
                                    {!!Form::select('is_paid', $arr_status, null, ['class' => 'form-control select2', 'placeholder' => 'Select Paymnet Status'])!!}
                                    <em class="error-msg">{!!$errors->first('is_paid')!!}</em>
                                </div>  
                                {{-- @endif --}}
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($singleData->id)
                                <div class="pull-right form-group">
                                    <label class="switch">
                                        <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif>
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/'.$module.'s'.'/all')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
  @if($singleData->is_same_as_billing == 1)
    <script>
      $(document).ready( function() {
          $('#d-checkout-address2').removeAttr('required');
          $('#d-checkout-city').removeAttr('required');
          $('#d-checkout-state').removeAttr('required');
          $('#d-checkout-zip').removeAttr('required');
          $('#d-checkout-country').removeAttr('required');
      });
    </script>
  @endif
@endsection