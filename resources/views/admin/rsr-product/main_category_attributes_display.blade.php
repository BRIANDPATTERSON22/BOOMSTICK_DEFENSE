@extends('admin.layouts.app')

@section('htmlheader_title')
    RSR main category attributes display
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> RSR main category attributes display</span>
@endsection

@section('contentheader_description')
     Manage attributes display
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
        <li class="text-capitalize active"> RSR main category attributes display</li>
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
                         Manage
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
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Categories</th>
                                        @foreach ($columns as $column)
                                            <th>{{ slug_to_word(substr($column, 10)) }}</th>
                                        @endforeach
                                    </tr>

                                    @foreach ($allData as $row)
                                        <tr>
                                            <td><b><u>{{ $row->have_rsr_main_category ? $row->have_rsr_main_category->category_name : "Deleted Category" }}</u></b></td>
                                            @foreach ($columns as $column)
                                                <td class="text-center">
                                                    <input
                                                    type="checkbox"
                                                    name="{{ $column }}"
                                                    value ="{{ $row->$column }}"
                                                    data-row-id ="{{ $row->id }}"
                                                    data-rsr-department-id="{{ $row->department_id }}"
                                                    data-rsr-main-category-id="{{ $row->category_id }}"
                                                    data-column-name="{{ $column }}"
                                                    @if($row->$column == 1) checked @endif>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($allData instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="text-center">
                                {{ $allData->links() }}    
                            </div>
                        @endif

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
            $("input:checkbox").change(function(){
                this.checked ? this.value = "1" :  this.value = "0";
                var attributeValue = $(this).val();
                var rowId = $(this).attr("data-row-id");
                var columnName = $(this).attr("data-column-name");
                var rsrMainCategoryId = $(this).attr("data-rsr-main-category-id");
                var rsrDepartmentId = $(this).attr("data-rsr-department-id");
                $.ajax({
                    type:'POST',
                    url:'rsr-main-category-filter-attributes',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: {
                        "attribute_value" : attributeValue,
                        "row_id" : rowId,
                        "column_name" : columnName,
                        "rsr_main_category_id" : rsrMainCategoryId,
                        "rsr_department_id" : rsrDepartmentId,
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