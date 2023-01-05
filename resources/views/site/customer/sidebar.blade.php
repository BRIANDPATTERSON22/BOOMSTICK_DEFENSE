<div class="col-lg-4 col-md-4 col-sm-5">
    <div class="user-account-sidebar inno_shadow">
        <aside class="user-info-wrapper">
            <div class="user-cover inno_shadow" style="background-image: url({{ asset('site/defaults/cover_.png')}});">
                {{--@if(Auth::user()->hasRole('trade-customer') && Auth::user()->customer->status == 1)--}}
                    {{--<div class="info-label" data-toggle="tooltip" title="Account Verified" data-original-title="Verified Account">--}}
                        {{--<i class="icofont icofont-check-circled"></i>--}}
                    {{--</div>--}}
                {{--@endif--}}
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <a data-toggle="modal" data-target="#modal-default" class="edit-avatar" href="#">
                        <i class="icofont icofont-edit"></i>
                    </a>
                    @if($customer->image)
                        <img src="{{asset('storage/customers/'.$customer->image)}}" alt="User">
                    @else
                        <img src="{{asset('site/defaults/avatar.jpg')}}" alt="User">
                    @endif
                </div>
                <div class="user-data">
                    <h4 class="font-16">{{ str_limit(Auth::user()->name, 20) }}</h4>
                    <span><i class="icofont icofont-ui-calendar"></i> Joined {{$customer->created_at->format('d M, Y')}}</span>
                </div>
            </div>
        </aside>
        <nav class="list-group">
            <a class="list-group-item {{(Request::is('*my-account*') ? 'active' : '')}}" href="{{url('my-account')}}"><i class="icofont icofont-ui-user fa-fw"></i>
                My Account</a>
            {{-- <a class="list-group-item" href="my-address.html"><i class="icofont icofont-location-pin fa-fw"></i> My Address</a> --}}
            <a class="list-group-item justify-content-between {{(Request::is('*my-orders*') ? 'active' : '')}}" href="{{url('my-orders')}}"><span><i class="icofont icofont-list fa-fw"></i> My Orders</span>
                <span class="badge badge-primary">{{$orders_c}} Items</span></a>

           {{--  <a class="list-group-item justify-content-between {{(Request::is('*my-wishlist*') ? 'active' : '')}}" href="{{ url('my-wishlist') }}"><span><i class="icofont icofont-heart-alt fa-fw"></i> Wish List</span>
                <span class="badge badge-primary">{{$wishListsCount}} Items</span></a> --}}

            {{-- <a class="list-group-item justify-content-between {{(Request::is('*my-reviews*') ? 'active' : '')}}" href="{{ url('my-reviews') }}"><span><i class="icofont icofont-star fa-fw"></i> My Reviews</span> <span class="badge badge-warning">{{$wishListsCount}} Reviews</span></a> --}}

            {{-- <a class="list-group-item justify-content-between" href="order-status.html"><span><i class="icofont icofont-truck-loaded fa-fw"></i> Order Status</span> <span class="badge badge-success">4</span></a> --}}
            {{-- <a class="list-group-item" href="invoice.html"><i class="icofont icofont-paper fa-fw"></i> Invoice A4</a> --}}
            <a class="list-group-item {{(Request::is('*change-password*') ? 'active' : '')}}" href="{{url('change-password')}}"><i class="icofont icofont-key fa-fw"></i>
                Change Password</a>
            <a class="list-group-item" href="{{ url('logout') }}"><i class="icofont icofont-logout fa-fw"></i>
                Logout</a>
        </nav>
    </div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        {!! Form::model(null, ['files' => true, 'url' => 'post-my-image', 'autocomplete'=>'off']) !!}
        {{-- {!! Form::open(['files' => true, 'url' => 'admin/'.$singleData->id.'/volunteer/add', 'autocomplete'=>'off']) !!} --}}
        {{-- {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!} --}}
        {!!csrf_field()!!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Your Profile Image</h4>
            </div>
            <div class="modal-body">
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    {!!Form::label("Upload Image")!!}
                    {!!Form::file('image', ['accept'=>'image/*'])!!}
                    @if($customer ->image)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="image-close">
                                    <a href="{{url('profile-image-delete/'.$customer->id)}}"><i class="fa fa-close red-text"></i></a>
                                </div>
                                <img src="{{asset('storage/customers/'.$customer->image)}}" alt="Image" class="img-thumbnail">
                            </div>
                        </div>
                    @endif
                    <em class="error-msg">{!!$errors->first('image')!!}</em>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>