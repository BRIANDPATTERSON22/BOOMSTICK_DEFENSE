
<link rel="stylesheet" href="{{asset('plugins/toastr-master/build/toastr.min.css')}}">
<style>
    .toast {opacity: 0.9 !important;}
    /*.toast-success {background-color: #ff4157;}*/
</style>


<link rel="stylesheet" href="{{asset('/plugins/select2/select2.min.css')}}">
<style>

    /*.select2-container .select2-selection--single {
      height: auto;
      outline: none; 
  }*/

/*      .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0px; }*/

/*    .select2-container--default .select2-selection--single {
      border-radius: 0px;
      border: none; }
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #001935;
        font-weight: bold;
        line-height: inherit;
        text-transform: capitalize; }*/

/*    .bigdrop {
      min-width: 196px !important; }*/

/*    .select2-results__options {
      padding: 8px 2px; }*/

/*    .select2-container {
      width: 100% !important; }*/

/*    .select2-container--default .select2-results__option--highlighted {
      border-radius: 3px;
      -webkit-transition: all 0.2s ease-in-out;
      transition: all 0.2s ease-in-out; }*/

/*    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      padding-left: 10px;
      font-weight: 600; }*/

/*    .select2-container--default .select2-selection--single .select2-selection__arrow {
      top: 1px;
      right: 0px;
      height: 21px;
      width: 14px; }
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border: none; }
      .select2-container--default .select2-selection--single .select2-selection__arrow:before {
        content: "\f078";
        font-family: "Font Awesome 5 Free";
        font-style: normal;
        font-weight: 900;
        color: #e67e22; }*/

/*    .select2-container--default .select2-search--dropdown {
      padding: 0; }
      .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #eeeeee; }*/

/*    .select2-container--default .select2-results__option[aria-selected=true] {
      background-color: #fafafa; }*/

/*    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background: rgba(38, 174, 97, 0.1);
      color: #e67e22; }*/

/*    .select2-dropdown {
      border: none;
      border-radius: 0px; }*/

/*    .select-border .select2-container--default .select2-selection--single {
      border: 1px solid #eeeeee;
      height: 50px;
      padding: 15px 20px;
      border-radius: 3px; }
      .select-border .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 16px;
        right: 20px; }*/

/*    .select2-results__option[aria-selected] {
      text-transform: capitalize; }*/

/*    .select2-container--default .select2-results > .select2-results__options {
      border: none; }*/

/*    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #3a4957; }*/

   /* .select2-container--open .select2-dropdown {
      background: #fafafa;
      padding: 7px;
      border: 1px solid #eeeeee; }*/

    /*.select2-search--dropdown .select2-search__field {
      border: 1px solid #eeeeee;
      -webkit-box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.04);
              box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.04); }*/

  .select2-container--default .select2-selection--single {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 30px;
  }
  .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 45px;
      user-select: none;
      -webkit-user-select: none;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 45px;
      font-weight: 100;
  }
  .select2-container .select2-selection--single .select2-selection__rendered {
      display: block;
      padding-left: 20px;
      padding-right: 20px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
      top: 7px;
      right: 10px;
  }

  .select2-dropdown {
      border: 1px solid #ebebeb;
  }
</style>

<link href="{{ asset('plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />

<style>
    .datepicker {
        border-radius: 30px;
    }
</style>

{{-- Global site tag (gtag.js) - Google Analytics --}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{$option->google_analytics}}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{$option->google_analytics}}');
</script>

{{-- <div id="fb-root"></div>
<script type='text/javascript'>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script> --}}

{{-- <style>
    @if($option->bg_breadcrumb)
        .breadcrumb-section {background: url({{ asset('storage/options/'.$option->bg_breadcrumb) }});
    @endif
</style>

<style>
    {{ $option->custom_css_style }}
</style> --}}

<style>
  .inno_shadow_dark { -webkit-box-shadow: 0 2px 28px 0 rgb(18 18 21); box-shadow: 0 2px 28px 0 rgb(18 18 21);}
  .br_10{border-radius: 10px;}
  .br_20{border-radius: 20px;}
  .pixelstrap .link-section h5 { border-bottom: 1px solid #343434; margin-bottom: 9px;}
  .bg-dark-2{background-color: #262626 !important;}
  .border_bottom{border-bottom: 1px solid #3c3c3c !important;}
  .bg_navy_blue{background-color: #1c3481 !important;}
  .text_navy_blue{color: #1c3481 !important;}

  
  .user-info-wrapper {
      /*border: 1px solid rgba(0, 0, 0, 0.125);*/
      border-top-left-radius: 7px;
      border-top-right-radius: 7px;
      margin-bottom: -2px;
      overflow: hidden;
      padding-bottom: 0;
      padding-top: 48px;
      position: relative;
      width: 100%
  }

  .user-info-wrapper .user-cover {
      background-position: right -85px top;
      background-repeat: no-repeat;
      background-size: 525px auto;
      height: 252px;
      left: 0;
      position: absolute;
      top: 0;
      width: 100%
  }

  .user-info-wrapper .user-cover .tooltip .tooltip-inner {
      max-width: 100%;
      padding: 10px 15px;
      width: 230px
  }

  .user-info-wrapper .info-label {
      background-color: #28a745;
      border-radius: 25px;
      box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.18);
      color: #ffffff;
      cursor: pointer;
      display: block;
      font-size: 13px;
      height: 35px;
      line-height: 26px;
      /*padding: 2px 0;*/
      padding: 5px;
      position: absolute;
      right: 18px;
      text-align: center;
      top: 18px;
      width: 34px
  }

  .user-info-wrapper .user-info {
      background: -moz-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 78%, rgba(255, 255, 255, 1) 100%);
      background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 78%, rgba(255, 255, 255, 1) 100%);
      background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 78%, rgba(255, 255, 255, 1) 100%);
      filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#ffffff', GradientType=0);
      display: table;
      padding: 90px 20px 10px 20px;
      position: relative;
      width: 100%;
      z-index: 5
  }

  .user-info-wrapper .user-info .user-avatar,
  .user-info-wrapper .user-info .user-data {
      display: table-cell;
      vertical-align: top
  }

  .user-info-wrapper .user-info .user-avatar {
      position: relative;
      width: 85px
  }

  .user-info-wrapper .user-info .user-avatar > img {
      border: 3px solid #e69d31;
      border-radius: 8px;
      display: block;
      margin: 9px 0 7px;
      width: 100%
  }

  .user-info-wrapper .user-info .user-avatar .edit-avatar {
      background-color: #ffffff;
      border-radius: 10%;
      box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.2);
      color: #606975;
      cursor: pointer;
      display: block;
      height: 36px;
      line-height: 34px;
      opacity: 0;
      position: absolute;
      right: -12px;
      text-align: center;
      text-decoration: none;
      top: -7px;
      transition: opacity 0.3s ease 0s;
      width: 36px
  }

  .user-info-wrapper .user-info .user-avatar:hover .edit-avatar {
      opacity: 1
  }

  .user-info-wrapper .user-info .user-data {
      padding-left: 12px;
      padding-top: 42px
  }

  .user-info-wrapper .user-info .user-data h4 {
      color: #e69d31;
      font-size: 23px;
      font-weight: 600;
      margin-bottom: 2px
  }

  .user-info-wrapper .user-info .user-data span {
      color: #9da9b9;
      display: block
  }





  .user-account-sidebar {
      border-radius: 4px;
      /*box-shadow: 0 0 6px rgba(193, 193, 193, 0.62)*/
  }

  .user-account-sidebar .list-group-item {
      color: #343a40;
      font-weight: 600;
      text-transform: uppercase
  }

  .user-account-sidebar .list-group-item .badge {
      border: 2px solid #ffffff;
      float: right;
      font-weight: bold;
      margin: 0;
      padding: 5px 10px
  }

  .user-account-sidebar .list-group-item i {
      display: inline-block;
      margin: 0 7px 0 0;
      width: 21px
  }

  .user-account-sidebar .list-group-item.active,
  .user-account-sidebar .list-group-item:hover {
      color: #ffffff;
      background-color: #e69d31
  }


  .list-group-item.active {
      border-color: #e69d31;
  }


  @media (max-width: 768px) {
    .user-info-wrapper .user-cover {
      background-position: left top;
    }
  }

  @media (max-width: 992px) {
    .user-info-wrapper .user-info {
      padding: 87px 9px 6px;
    }
    .user-info-wrapper .user-info .user-avatar {
      width: 55px;
    }
    .user-info-wrapper .user-info .user-data {
      padding-left: 8px;
      padding-top: 5px;
    }
    .user-info-wrapper .user-info .user-data h4 {
      font-size: 17px;
    }
    .user-account-sidebar .list-group-item {
      padding: 7px 8px;
    }
  }

  .heading-design-h5 {
      font-size: 16px;
      font-weight: 600;
      margin: 0 0 30px;
      position: relative;
      text-transform: uppercase;
  }

  .heading-design-h5::after {
      background: rgba(0,0,0,0) linear-gradient(to right,#007bff 0%,#005ec2 100%) repeat scroll 0 0;
      border-radius: 12px;
      content: "";
      height: 3px;
      left: 0;
      position: absolute;
      bottom: -13px;
      width: 29px;
  }

  .shopping_cart_page{padding: 50px 0;}

  .g-recaptcha {
      transform:scale(0.84);
      -webkit-transform:scale(0.84);
      transform-origin:0 0;
      -webkit-transform-origin:0 0;
  }

@media (max-width: 1366px){.top-header .top-header-right .top-menu-block {display: block;}}
@media (max-width: 1679px){.top-header .top-header-right .top-menu-block {display: block;}}

.top-header {background-color: #252525;}
/*.category-header-2{background-color: #252525;}*/
.blog .blog-contain .blog-details h4 {
    font-size: 1rem;
}

.dark .layout-header2 {
    background-color: #1b1b1b;
    position: fixed;
    z-index: 9;
    width: 100%;
    top: 0px;
}

.category-header-2 {
    position: relative;
    top: 124px;
    width: 100%;
    margin-bottom: 124px;
    z-index: 8;
}

.custom_menu li {
    color: #cfd4da;
    border-left: 1px solid #2747af;
    padding-left: 20px;
}

.breadcrumb-main {
    padding: 5px;
}

.breadcrumb-main .breadcrumb-contain h2 {
     margin-bottom: 0px; 
}

/*.layout-header3 {
    background-color: #1b1b1b;
}*/

@media (max-width: 577px){
  .dark .layout-header2 {
     z-index: 8;
  }
}

@media (max-width: 991px){
  .dark .layout-header2 {
       z-index: 8;
    }
}

@media (min-width: 992px){
  .layout-header2 .main-menu-block .logo-block img {
       height: 70px; 
  }
}

.add_to_cart .cart-inner .cart_media li .media img {
    height: 50px;
}


.category-header-2 .navbar-menu .category-left .menu-block .pixelstrap .dark-menu-item {
    padding-top: 13px;
    padding-bottom: 13px;
}

.pixelstrap a, .pixelstrap a:hover, .pixelstrap a:active {
    padding-top: 13px;
    padding-bottom: 13px;
}
  
  /*  .search-result-box{
    }*/

  /* width */
  .search-result-box::-webkit-scrollbar {width: 5px;}
  /* Track */
  .search-result-box::-webkit-scrollbar-track {box-shadow: inset 0 0 9px grey; border-radius: 0px;}
  /* Handle */
  .search-result-box::-webkit-scrollbar-thumb {background: black; border-radius: 0px;}
  /* Handle on hover */
  .search-result-box::-webkit-scrollbar-thumb:hover {background: #b30000; }
  
  .search-result-box a{color: black;}
  .search-result-box .list-group-item.active {border-color: #3c3c3c;}
  .search-result-box .list-group-item.active {color: #fff; background-color: #1c3481; border-color: #007bff;}
  .search-result-box .list-group-item:first-child {border-top-left-radius: 0px;border-top-right-radius: 0px;}
  .search-result-box .list-group-item {background-color: #e0e0e0;}

  .title1 {padding: 15px 0;}
  .login-page .theme-card .theme-form input {
      padding: 6px 10px;
  }

  /*.form-control {
    color: #ffffff;
  }*/

  .dark select {
      background-color: #262626 !important;
      color: #cfd4da !important;
      border: 1px solid #3c3c3c;
      border-radius: 0px;
  }

  .contact-page .theme-form input {
       padding: 6px 10px;
  }

  .form-group {
      margin-bottom: 0.3rem;
  }
  .form-control{font-size: 0.8rem;}

  .login-page .theme-card .theme-form label {
      font-size: calc(14px + (18 - 18) * ((100vw - 320px) / (1920 - 320)));
      font-weight: 500;
  }

  .contact-page .theme-form label {
      font-size: calc(14px + (18 - 18) * ((100vw - 320px) / (1920 - 320)));
      font-weight: 500;
  }

  .text_transform_none{text-transform: none !important;}
  .page-item.disabled .page-link {background-color: #1b1b1b;border-color: #3c3c3c;}

  /* Checkout Step */
  .checkout-step {
      display: inline-block;
      width: 100%;
  }
  .checkout-step ul {
      display: table;
      margin: 0 auto 25px;
    text-align: center;
  }
  .checkout-step ul li {
      color: #ffee00;
      cursor: pointer;
      display: inline-block;
      font-size: 15px;
      margin: 0 -2px;
      text-align: center;
  }
  .checkout-step ul li .step {
      float: left;
      margin-bottom: 10px;
      position: relative;
  }
  .checkout-step ul li .step .circle {
      background: #1c3481 none repeat scroll 0 0;
      border-radius: 50%;
      /*border-radius: 0%;*/
      color: #ffffff;
      display: inline-block;
      font-size: 16px;
      font-weight: 500;
      height: 32px;
      left: 50%;
      padding: 3px 11px;
      position: absolute;
      text-align: left;
      transform: translateX(-50%);
      width: 32px;
  }
  .checkout-step ul li .step .line {
      background: #1c3481 none repeat scroll 0 0;
      float: left;
      height: 7px;
      margin: 12px -1px 12px 0;
      width: 155px;
  }
  .checkout-step ul li:first-child .step .line {
      border-radius: 3px 0 0 3px;
      width: 155px;
  }
  .checkout-step ul li:last-child .step .line {
      background: #868e96 none repeat scroll 0 0;
      border-radius: 0 3px 3px 0;
      width: 155px;
  }
  .checkout-step ul li span {
      color: #4a3eed;
      display: block;
      line-height: 20px;
      padding: 6px 15px 6px 6px;
  }
  .checkout-step ul li.step-done {
      color: #26537f;
  }
  .checkout-step ul li.active {
      color: #ffee00;
  }
  .checkout-step ul li.step-done .step .circle,
  .checkout-step ul li.step-done .step .line {
      background: #26537f none repeat scroll 0 0;
  }
  .checkout-step ul li.active .step .circle,
  .checkout-step ul li.active .step .line {
      background: #dc3545 none repeat scroll 0 0;
  }
  .checkout-step .active span {
      color: #dc3545;
  }
  .checkout-step li.active + li .circle,
  .checkout-step li.active + li + li .circle,
  .checkout-step li.active + li + li + li .circle,
  .checkout-step li.active + li .line,
  .checkout-step li.active + li + li .line,
  .checkout-step li.active + li + li + li .line {
      background: #868e96 none repeat scroll 0 0;
  }
  .checkout-step li.active + li span,
  .checkout-step li.active + li + li span,
  .checkout-step li.active + li + li + li span {
      color: #868e96;
  }
  /* End Checkout Step */
  
  
    .creative-card {padding: 10px;}
    .collection-product-wrapper .product-top-filter .product-filter-content .collection-grid-view,
    .collection-product-wrapper .product-top-filter .popup-filter .collection-grid-view {padding: 10px;}
    .footer-2 .footer-main-contian .footer-right .subscribe-section .subscribe-block .subscrib-contant .input-group .telly i {color: #c9d4da}
</style>

@yield('page-style')