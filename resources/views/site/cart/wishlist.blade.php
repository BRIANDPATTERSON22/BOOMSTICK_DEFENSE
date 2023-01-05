@extends('site.layouts.default')

@section('htmlheader_title')
  Wish list
@endsection

@section('main-content')
  <div class="page-title">
    <div class="container">
      <div class="column">
        <h1>Wish list</h1>
      </div>
      <div class="column">
        <ul class="breadcrumbs">
          <li><a href="{{url('/')}}">Home</a></li>
          <li class="separator">&nbsp;</li>
          <li><a href="{{url('products')}}">Shop</a></li>
          <li class="separator">&nbsp;</li>
          <li>Wish list</li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1">
    @if(count($wishItems)>0)
      <div class="table-responsive shopping-cart">
        <table class="table">
          <thead>
          <tr>
            <th>Product</th>
            <th class="text-right">Price</th>
            <th></th>
            <th class="text-center">
              <a class="btn btn-sm btn-outline-danger" href="{{url('wish-remove-all')}}">Clear Wish</a>
            </th>
          </tr>
          </thead>
          <tbody>
          @foreach($wishItems as $item)
            <tr>
              <td>
                <div class="product-item">
                  <a class="product-thumb" href="{{url('product/'.$item->options['slug'])}}">
                    <img src="{{asset('storage/products/images/'.$item->options['image'])}}" alt="Product">
                  </a>
                  <div class="product-info">
                    <h4 class="product-title">
                      <a href="{{url('product/'.$item->options['slug'])}}">{{$item->name}}</a>
                    </h4>
                    <span>{{$item->options['description']}}</span>
                  </div>
                </div>
              </td>
              <td class="text-right text-lg">${{number_format($item->price, 2)}}</td>
              <td><a class="btn btn-primary" href="{{url($item->id.'/item')}}">To Cart</a></td>
              <td class="text-center"><a class="remove-from-cart" href="{{url('wish/'.$item->rowId.'/remove')}}" data-toggle="tooltip" title="Remove item"><i class="icon-x"></i></a></td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    @else
      <h3 class="text-center"> The Wish list is Empty</h3>
      <div class="shopping-cart-footer">
        <div class="text-center">
          <a class="btn btn-outline-secondary" href="{{url('products')}}"><i class="icon-arrow-left"></i>&nbsp;Add some Products to Wish list</a>
        </div>
      </div>
  @endif

  <!-- Related Products Carousel-->
    <h3 class="text-center padding-top-2x mt-2 padding-bottom-1x">You May Also Like</h3>
    <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;margin&quot;: 30, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;576&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
      @foreach($otherProducts as $row)
        <div class="product-card">
          @if($row->quantity == 0)
            <div class="product-badge bg-secondary border-default text-body">Out of stock</div>
          @elseif($row->special_price)
            <div class="product-badge bg-success">Sale</div>
          @endif
          <a class="product-thumb" href="{{url('product/'.$row->slug)}}">
            @if($row->main_image)
              <div class="shop-img" style="background-image: url('{{asset('storage/products/images/'.$row->main_image)}}')">
                <img src="{{asset('storage/products/images/'.$row->main_image)}}" alt="{{$row->name}}">
              </div>
            @else
              <div class="shop-img" style="background-image: url('{{asset('site/img/default.png')}}')">
                <img src="{{asset('site/img/default.png')}}" alt="{{$row->name}}">
              </div>
            @endif
          </a>
          <div class="product-card-body">
            <div class="product-category"><a href="{{url('category/'.$row->category->slug)}}">{{$row->category->name}}</a></div>
            <h3 class="product-title"><a href="{{url('product/'.$row->slug)}}">{{str_limit($row->name,24)}}</a></h3>
            <h4 class="product-price">
              @if($row->special_price)<del>${{$row->special_price}}</del> @endif ${{$row->price}}
            </h4>
          </div>
          <div class="product-button-group">
            @if($row->quantity > 0)
              <a class="product-button btn-wishlist" href="{{url($row->id.'/wish')}}"><i class="icon-heart"></i><span>Wishlist</span></a>
            @endif
            <a class="product-button btn-compare" href="{{url('product/'.$row->slug)}}"><i class="icon-search"></i><span>View</span></a>
            @if($row->quantity > 0)
              <a class="product-button" href="{{url($row->id.'/item')}}"><i class="icon-shopping-cart"></i><span>To Cart</span></a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection