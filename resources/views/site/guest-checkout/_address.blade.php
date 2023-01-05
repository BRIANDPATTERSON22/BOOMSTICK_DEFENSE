<div class="modal fade " id="addressModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        {!!Form::model(session('guestAddressSession') ?? null, ['url'=>'address', 'autocomplete'=>'off', 'id' => 'guest_checkout_address_form', 'class' => 'theme-form'])!!}
        {!!csrf_field()!!}
        <div class="modal-content  bg-dark">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change your address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body bg-dark">
            {{-- <input type="hidden" name="timezone_identifier" id="timezone_identifier"> --}}
            <input type="hidden" name="data_from" value="checkout">

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>First Name <span class="required">*</span></label>
                        {!!Form::text('first_name', null, ['id'=>'checkout-fn', 'class' => 'form-control ', 'placeholder'=>'First name'])!!}
                        <em class="text-danger">{!!$errors->first('first_name')!!}</em>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>Last Name <span class="required">*</span></label>
                        {!!Form::text('last_name', null, ['id'=>'checkout-ln', 'class' => 'form-control ', 'placeholder'=>'Last name'])!!}
                       <em class="text-danger">{!!$errors->first('last_name')!!}</em>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>Email Address <span class="required">*</span></label>
                        {!!Form::email('email', null, ['id'=>'checkout-email', 'class' => 'form-control ', 'placeholder'=>'Email address'])!!}
                       <em class="text-danger">{!!$errors->first('email')!!}</em>
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>Mobile <span class="required">*</span></label>
                        {!!Form::tel('mobile', null, ['id'=>'checkout-phone', 'class' => 'form-control ', 'placeholder'=>'Contact Number'])!!}
                       <em class="text-danger">{!!$errors->first('mobile')!!}</em>
                    </div>
                </div> --}}

                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>Phone No<span class="required">*</span></label>
                        {!!Form::tel('phone_no', null, ['id'=>'checkout-phone', 'class' => 'form-control ', 'placeholder'=>'Phone Number'])!!}
                       <em class="text-danger">{!!$errors->first('phone_no')!!}</em>
                    </div>
                </div>
            </div>

            <div id="billing-address">
                {{-- <h5 class="heading-design-form">Enter Your Billing Info</h5> --}}
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id_billing_address" class="control-label">Billing Address *</label>
                        {!!Form::textarea('billing_address', null, ['id'=>'id_billing_address', 'class' => 'form-control ', 'placeholder'=>'Address *','rows' => '2', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('billing_address')!!}</em>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="id_billing_country_id" class="control-label">Billing Country *</label>
                      {!!Form::select('billing_country_id', $countries, null, ['id'=>'id_billing_country_id', 'class' => 'form-control ', 'placeholder'=>'Country *', 'required'])!!}
                      <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_country_id')!!}</em>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="id_billing_city" class="control-label">Billing City *</label>
                        {!!Form::text('billing_city', null, ['id'=>'id_billing_city', 'class' => 'form-control ', 'placeholder'=>'City *', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('billing_city')!!}</em>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="id_billing_state" class="control-label">Billing State *</label>
                      {!!Form::select('billing_state', config('default.usStates'), null, ['id'=>'id_billing_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                      <em class="error-msg" id="billing_country_id_error">{!!$errors->first('billing_state')!!}</em>
                    </div>
                    {{-- <div class="form-group col-md-3">
                        <label for="id_billing_state" class="control-label">Billing State *</label>
                        {!!Form::text('billing_state', null, ['id'=>'id_billing_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('billing_state')!!}</em>
                    </div> --}}
                    <div class="form-group col-md-3">
                        <label for="id_billing_postal_code" class="control-label">Billing Zip code *</label>
                        {!!Form::text('billing_postal_code', null, ['id'=>'id_billing_postal_code', 'class' => 'form-control ', 'placeholder'=>'Zip code *', 'required'])!!}
                        <em class="error-msg">{!!$errors->first('billing_postal_code')!!}</em>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label class="d-inline">
                     <input type="checkbox" name="is_same_as_billing" onclick="leader_show()" value="1" class="h_15 width_none_"  @if(session('isSameAsBillingSession') == 1) checked @endif>
                    If the Delivery address is same as Billing address, please tick this check box.
                   </label>
                </div>
            </div>
            
            <div id="delivery-address" @if(session('isSameAsBillingSession') == 1) style="display: none" @endif>
              {{-- <h5 class="heading-design-form">Enter Delivery Info</h5> --}}
              <div class="row">
                  <div class="form-group col-md-12">
                      <label for="id_delivery_address" class="control-label">Delivery Address *</label>
                      {!!Form::textarea('delivery_address', null, ['id'=>'id_delivery_address', 'class' => 'form-control ', 'placeholder'=>'Address *','rows' => '2', 'required'])!!}
                      <em class="error-msg">{!!$errors->first('delivery_address')!!}</em>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="id_delivery_country_id" class="control-label">Delivery Country *</label>
                    {!!Form::select('delivery_country_id', $countries, null, ['id'=>'id_delivery_country_id', 'class' => 'form-control ', 'placeholder'=>'Country *', 'required'])!!}
                    <em class="error-msg" id="delivery_country_id_error">{!!$errors->first('delivery_country_id')!!}</em>
                  </div>
                  <div class="form-group col-md-3">
                      <label for="id_delivery_city" class="control-label">Delivery City *</label>
                      {!!Form::text('delivery_city', null, ['id'=>'id_delivery_city', 'class' => 'form-control ', 'placeholder'=>'City *', 'required'])!!}
                      <em class="error-msg">{!!$errors->first('delivery_city')!!}</em>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="id_delivery_state" class="control-label">Delivery State *</label>
                    {!!Form::select('delivery_state', config('default.usStates'), null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                    <em class="error-msg" id="billing_country_id_error">{!!$errors->first('delivery_state')!!}</em>
                  </div>
                 {{--  <div class="form-group col-md-3">
                      <label for="id_delivery_state" class="control-label">Delivery State *</label>
                      {!!Form::text('delivery_state', null, ['id'=>'id_delivery_state', 'class' => 'form-control ', 'placeholder'=>'State *', 'required'])!!}
                      <em class="error-msg">{!!$errors->first('delivery_state')!!}</em>
                  </div> --}}
                  <div class="form-group col-md-3">
                      <label for="id_delivery_postal_code" class="control-label">Delivery Zip code *</label>
                      {!!Form::text('delivery_postal_code', null, ['id'=>'id_delivery_postal_code', 'class' => 'form-control ', 'placeholder'=>'Zip code *', 'required'])!!}
                      <em class="error-msg">{!!$errors->first('delivery_postal_code')!!}</em>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>