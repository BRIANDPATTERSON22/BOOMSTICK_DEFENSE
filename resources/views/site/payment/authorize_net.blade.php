@extends('site.layouts.default')

@section('htmlheader_title')
  Pay By Authorize.net
@endsection

@section('page-style')
  <style>
    .error_form h1 {
        font-size: 9em;
        font-weight: 700;
        color: #81d742;
        letter-spacing: 10px;
        line-height: 160px;
         margin: 0px; 
    }

    .p_30 {padding: 30px; border: 5px solid #1c3481; border-radius: 30px;}

    .error_form a {
         margin-top: 0px; 
        border-radius: 20px;
    }
  </style>
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
      <div class="container">
          <div class="row">
              <div class="col">
                  <div class="breadcrumb-contain">
                      <div>
                          <h2>Payment</h2>
                          <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="{{ url('payment-methods') }}">Payment Methods</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a>Pay By Authorize.net</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>


    <section class="login-page section-big-py-space bg-light">
      <div class="custom-container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="p_30 text-center">
                    <form method="post" action="https://accept.authorize.net/payment/payment" id="formAuthorizeNetTestPage" name="formAuthorizeNetTestPage">
                      <input type="hidden" id="redirectToken" name="token" value="{{ $authorizeNetToken }}" />
                      <button class="btn btn-primary" id="btnContinue" onclick="">Continue to Authorize.net Payment Page</button>
                    </form>
                </div>
            </div>
        </div>
      </div>    
    </section>
@endsection