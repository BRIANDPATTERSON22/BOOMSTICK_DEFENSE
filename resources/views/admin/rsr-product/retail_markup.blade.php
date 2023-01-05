@extends('admin.layouts.app')

@section('htmlheader_title')
    RSR Retail Markup
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> RSR Retail Markup</span>
@endsection

@section('contentheader_description')
    Manage RSR Retail Markup
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> RSR Retail Markup</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"><i class="fa fa-list"></i>
                    <span>
                         Manage RSR Retail Markup
                    </span>
                 </a>
            </li>
            {{-- <li class="pull-right">
                <a href="{{url('admin/rsr-main-categories')}}"><i class="fa fa-plus"></i> <span>Add</span></a>
            </li> --}}
        </ul>

        {{-- @include('admin.'.$module.'.header') --}}
        
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-12">
                        {{-- {!! Form::model(null, array('autocomplete' => 'off')) !!} --}}
                        {{-- {!!csrf_field()!!} --}}
                        {{-- <div class="box-header">
                            <h3 class="box-title">Retail Markup</h3>
                        </div> --}}
                        <div class="box-body">
                            <div class="row">
                                @foreach ($allData as $row)
                                    <div class="col-sm-4 form-group {{ $errors->has('retail_price_percentage') ? 'has-error' : '' }}">
{{--                                         {!!Form::label("retail_price_percentage*")!!} --}}
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>{{ $row->department_name }}</b></span>
                                            {{-- {!!Form::text('retail_price_percentage', $row->retail_price_percentage, ['class' => 'form-control', 'placeholder' => 'Enter Retail Price Percentage'])!!} --}}
                                            <input class="form-control" 
                                                type="text"
                                                name="retail_price_percentage"
                                                value="{{ $row->retail_price_percentage }}"
                                                data-rsr-main-category-id="{{ $row->id }}"
                                                placeholder="Enter Retail Price Percentage">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <em class="error-msg">{!!$errors->first('retail_price_percentage')!!}</em>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="box-footer">
                            <div class="pull-left form-group">
                                <a class="btn btn-default" href="{{url('admin/rsr-retail-markup')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                            </div>
                            <div class="pull-right form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check-circle-o"></i> Update
                                </button>
                            </div>
                        </div> --}}
                        {{-- {!! Form::close() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ajaxStart(function () {
            Pace.restart()
        })
    </script>

    <script>
        $(document).ready(function(){
            $(":text").keyup(function(){
              var retailPricePercentageValue = $(this).val();
              var rsrMainCategoryId = $(this).attr("data-rsr-main-category-id");

              $.ajax({
                      type:'POST',
                      url:'rsr-retail-markup',
                      headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                      data: {
                          "retail_price_percentage" : retailPricePercentageValue,
                          "rsr_main_category_id" : rsrMainCategoryId,
                      },
                      success: function(data){
                        if(data.message){
                          // console.log(data);
                        }
                      }
                  });
            });
        });
    </script>
@endsection