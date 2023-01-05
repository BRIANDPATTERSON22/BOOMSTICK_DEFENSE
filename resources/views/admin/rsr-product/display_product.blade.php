@extends('admin.layouts.app')

@section('htmlheader_title')
    Display RSR Product
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> {{$module}} display</span>
@endsection

@section('contentheader_description')
    Manage  Display RSR Product
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> sales-persons</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

        <ul class="nav nav-tabs">
            <li @if(Request::is('admin/display-type/*')) class="active" @endif>
                <a href="#"><i class="fa fa-list"></i> 
                    <span>
                        @if($singleData->id) Edit sales-person ID: {{$singleData->id}} @else  Add Featured/ New Arrivals @endif
                    </span>
                </a>
            </li>
            @yield('actions')
            <li class="pull-right">
                {{-- <a href="{{url('admin/display-product')}}"><i class="fa fa-plus"></i> <span>Add</span></a> --}}
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        {{-- <div class="box-header">
                            <h3 class="box-title">
                                @if($singleData->id) Edit sales-person ID: {{$singleData->id}} @else  Add New sales-person @endif
                            </h3>
                        </div> --}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                    {!!Form::label("Type *")!!}
                                    @php $arr_type = ['1' => 'Featured', '2' => 'New Products'] @endphp
                                    {!!Form::select('type', $arr_type, null, ['class' => 'form-control select2', 'placeholder' => 'Select the display type'])!!}
                                    <em class="error-msg">{!!$errors->first('type')!!}</em>
                                </div>

                                <div class="col-md-6">
                                    {!!Form::label("Select Product(s) *")!!}
                                    {{-- <span class="pull-right"><a href="{{url('admin/products')}}" target="_blank">Add Products</a></span> --}}
                                    {!!Form::select('products[]', $rsrProductsData, null, ['class' => 'form-control select2', 'multiple' => 'multiple','data-placeholder' => 'Select the product(s)'])!!}
                                    {{-- <select name="products[]" class="form-control select2" multiple="multiple" data-placeholder="Select Product(s)">
                                        @foreach($productsData as $row)
                                            <option value="{{ $row->id }}" @if($singleData->id && in_array($row->id, $singleData->products)) selected @endif>
                                                {{ $row->title }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                    <em class="error-msg">{!!$errors->first('products')!!}</em>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right form-group">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="{{ Request::is('admin/rsr-display-type/featured') ? 'active' : '' }}"><a href="{{ url('admin/rsr-display-type/featured') }}" data-toggle="tab_"><i class="fa fa-bookmark"></i> <span>Featured Products</span></a></li>
            <li class="{{ Request::is('admin/rsr-display-type/new') ? 'active' : '' }}"><a href="{{ url('admin/rsr-display-type/new') }}" data-toggle="tab_"><i class="fa fa-cube"></i> <span>New Arrivals</span></a></li>
            {{-- <li class="pull-right">
                <a href="{{url('admin/shippings')}}"><i class="fa fa-plus"></i> <span>Add</span></a>
            </li> --}}
        </ul>
        <div class="tab-content">
            @if(Request::is('admin/rsr-display-type/featured'))
            <div class="tab-pane {{ Request::is('admin/rsr-display-type/featured') ? 'active' : '' }}" id="tab_1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                   {{--  <div class="box-header">
                                        <small class="pull-right">
                                            <a href="{{url('admin/shippings')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                                        </small>
                                    </div> --}}
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Store</th>
                                                    <th>Product</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 0; ?>
                                                    @foreach ($rsrFeaturedProductsData as $row)
                                                        <?php $count++; ?>
                                                        <tr>
                                                            <td>{{$count}}</td>
                                                            <td>{{ $row->type == 1 ? 'Featured' : 'New' }}</td>
                                                            <td>{{ $row->get_store_type() }}</td>
                                                            <td>
                                                                <span class="label label-default">{{ $row->rsrProduct ? $row->rsrProduct->product_description : 'Product Deleted' }} </span> &nbsp
                                                            </td>
                                                            <td style="white-space: nowrap;">
                                                                {{-- <a href="{{ url('admin/display-type/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a> --}}
                                                                <a href="{{ url('admin/display-type/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i> DELETE</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if(Request::is('admin/rsr-display-type/new'))
            <div class="tab-pane {{ Request::is('admin/rsr-display-type/new') ? 'active' : '' }}" id="tab_2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                   {{--  <div class="box-header">
                                        <small class="pull-right">
                                            <a href="{{url('admin/shippings')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
                                        </small>
                                    </div> --}}
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Store</th>
                                                    <th>Product</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 0; ?>
                                                    @foreach ($rsrNewProductsData as $row)
                                                        <?php $count++; ?>
                                                        <tr>
                                                            <td>{{$count}}</td>
                                                            <td>{{ $row->type == 1 ? 'Featured' : 'New' }}</td>
                                                             <td>{{ $row->get_store_type() }}</td>
                                                            <td>
                                                                <span class="label label-default">{{ $row->rsrProduct ? $row->rsrProduct->product_description : 'Product Deleted' }} </span> &nbsp
                                                            </td>
                                                            <td style="white-space: nowrap;">
                                                                {{-- <a href="{{ url('admin/display-option/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"> </i></a> --}}
                                                                <a href="{{ url('admin/display-type/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this data?')){return false;}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"> </i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ajaxStart(function () {
            Pace.restart()
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="type"]').on('change', function(){
                var typeId = $(this).val();
                var APP_URL = {!! json_encode(url('/')) !!};

                if(typeId) {
                    $.ajax({
                        url: APP_URL+'/admin/get-rsr-product-by-type/'+typeId,
                        type:"GET",
                        dataType:"json",
                        beforeSend: function(){
                            $('#loader').css("visibility", "visible");
                        },

                        success:function(data) {
                            $('select[name="products[]"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="products[]"]').append('<option value="'+ key +'">' + value + '</option>');
                            });
                        },
                        complete: function(){
                            $('#loader').css("visibility", "hidden");
                        }
                    });
                } else {
                    $('select[name="products[]"]').empty();
                }
            });
        });
    </script>
@endsection