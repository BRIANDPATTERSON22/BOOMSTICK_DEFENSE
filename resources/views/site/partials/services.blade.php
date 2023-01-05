<style type="text/css">
  .services-block .item {
    border: 1px solid #e1e7ec;
    padding: 22px 30px;
    width: 100%;}

    .services-block span {
        color: #da318c;
        display: block;
        font-size: 15px;
        font-weight: 600;
        line-height: 15px;}
        .text-guypaul{color:#ff49ab !important;}

</style>
  <div class="container p-0">
<div class="row services-block" style="margin: 0px 0px 0px 0px !important;">

    
    <div class="col-xl-3 col-lg-6 d-flex">
       <div class="item d-flex align-items-center">
          <div class="icon"><i class="icofont icofont-free-delivery text-guypaul"></i></div>
          <div class="text"><span class="text-uppercase">Free shipping</span><small>Free Shipping over {{ $option->currency_symbol }}40 (Ex. VAT)</small></div>
       </div>
    </div>
    <div class="col-xl-3 col-lg-6 d-flex">
       <div class="item d-flex align-items-center">
          <div class="icon"><i class="icofont icofont-money-bag text-guypaul"></i></div>
          <div class="text"><span class="text-uppercase">15% off</span><small>15% off orders over {{ $option->currency_symbol }}100 (Ex. VAT)</small></div>
       </div>
    </div>
    <div class="col-xl-3 col-lg-6 d-flex">
       <div class="item d-flex align-items-center">
          <div class="icon"><i class="icofont icofont-headphone-alt-2 text-guypaul"></i></div>
          <div class="text"><span class="text-uppercase">{{ $option->phone }}</span><small>info@guypaul.co.uk</small></div>
       </div>
    </div>
    <div class="col-xl-3 col-lg-6 d-flex">
       <div class="item d-flex align-items-center">
          <div class="icon"><i class="icofont icofont-shield text-guypaul"></i></div>
          <div class="text"><span class="text-uppercase">Secure Payment</span><small>100% Secure Payment Gateway</small></div>
       </div>
    </div>
  </div>
</div>