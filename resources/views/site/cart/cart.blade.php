@extends('site.layouts.default')

@section('htmlheader_title')
    Cart
@endsection

@section('page-style')
    <style>
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>cart</h2>
                            <ul>
                                <li><a href="{{ url('/') }}">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a>cart</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="cart-section section-big-py-space bg-light">
        <div class="custom-container">
            {{-- <div class="mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger" role="alert">
                            Some products required an age verification! If you under 18 highlighted products will be removed from your cart.
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">image</th>
                                <th scope="col">product name</th>
                                <th scope="col">price</th>
                                <th scope="col">quantity</th>
                                <th scope="col">action</th>
                                <th scope="col">total</th>
                            </tr>
                        </thead>
                        @foreach($cartItems as $item)
                            <tbody>
                            <tr class="">
                                <td>
                                    <a href="{{url('product/'.$item->options['slug'])}}">
                                        @if ($item->options['type'] == 0)
                                            @if($item->options['image'])
                                                <img src="{{asset('storage/products/images/'.$item->options['image'])}}" alt="{{$item->name}}">
                                            @else
                                                <img src="{{asset('site/defaults/image-not-found.png')}}" alt="{{$item->name}}">
                                            @endif
                                        @else
                                            {{-- @if($row->image_name)
                                              @if (Storage::exists($row->get_hr_image_storage_path_by_category()))
                                                <img class="img-fluid" src="{{asset($row->get_hr_image_by_category())}}">
                                              @else
                                                <img class="img-fluid" src="{{asset('site/defaults/image-coming-soon.png')}}">
                                              @endif
                                            @else
                                                 <img class="img-fluid" src="{{asset('site/defaults/image-not-found.png')}}">
                                            @endif --}}
                                            <img class="img-fluid" src="{{asset($item->options['image'])}}">
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <a href="{{url('product/'.$item->options['slug'])}}">{{str_limit($item->name, 100)}}</a>
                                    <div class="mobile-cart-content row">
                                        <div class="col-xs-3">
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <input type="text" name="quantity" class="form-control input-number" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color">{{ $option->currency_symbol }}{{number_format($item->price, 2)}}</h2></div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color"><a href="cart.html#" class="icon"><i class="ti-close"></i></a></h2></div>
                                    </div>
                                </td>

                                <td>
                                    <h2>{{ $option->currency_symbol }}{{number_format($item->price, 2)}}</h2>
                                </td>

                                <td>
                                    <div class="qty-box">
                                        {!!Form::open(['url'=> 'item/'.$item->rowId.'/update', 'autocomplete'=>'off', 'id' => 'target'])!!}
                                        {!!csrf_field()!!}
                                            <div class="input-group">
                                                <input class="form-control input-number" id="{{ $item->id }}" min="1" max="{{ $item->options['qty'] }}" value="{{ $item->qty }}" type="number" name="qty">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-dark">
                                                        <button type="submit" class="btn btn-dark"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                                    </span>
                                                  </div>
                                                
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </td>

                                <td><a href="{{url('item/'.$item->rowId.'/remove')}}" class="icon"><i class="ti-close"></i></a></td>

                                <td><h2 class="td-color">{{ $option->currency_symbol }}{{number_format(($item->qty * $item->price), 2)}}</h2></td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                        <tr>
                            <td>total price :</td>
                            <td>
                                <h2>{{ $option->currency_symbol }} {{Cart::subtotal()}}</h2></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-12">
                    @if (Auth::check())
                        {{-- <a href="{{ url('checkout-address') }}" class="btn btn-normal">Checkout</a>  --}}
                        <a href="{{ url('checkout-age-verification') }}" class="btn btn-normal">Checkout</a> 
                    @else
                        <a href="{{ url('login') }}" class="btn btn-normal">Login & Checkout</a> 
                        {{-- <a href="{{ url('address') }}" class="btn btn-normal ml-3">checkout as guest</a> --}}
                        <a href="{{ url('verification') }}" class="btn btn-normal ml-3">checkout as guest</a>
                    @endif
                    {{-- <a href="{{ url('products') }}" class="btn btn-normal">continue shopping</a>  --}}
                </div>
            </div>
        </div>
    </section>
@endsection



@section('page-script')
{{--     <script>
        $("input[type='number']").inputSpinner()
    </script> --}}

    {{-- <script type='text/javascript'> 
        $(document).ready(function(){
          $('#quantity').change(function(){
            var x = $('#quantity').closest("form").attr('id');
            var user_id = $(this).closest("form").attr('id');
            console.log(x);
            $('#qty-form').submit();
          });
        });
    </script> --}}

    {{-- <script type='text/javascript'> 
        $(document).ready(function(){
          $('#quantity').change(function(){
            var x = $('#quantity').closest("form").attr('id');
            // var user_id = $(this).closest("form").attr('id');
            console.log(x);
            $('#qty-form').submit();
          });
        });
    </script> --}}
@endsection