@extends('admin.layouts.app')

@section('htmlheader_title')
    Menus
@endsection

@section('contentheader_title')
    Menus /Sub Menus
@endsection

@section('contentheader_description')
    Manage page menus of the website
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Menus</li>
    </ol>
@endsection

@section('main-content')
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif

    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::model($singleData, array('files' => true, 'autocomplete' => 'off')) !!}
                        {!!csrf_field()!!}
                        <?php $types = ['header'=>'Header', 'footer'=>'Footer']; ?>
                        <div class="box-header">
                            <h3 class="box-title">@if($singleData->id) Edit Menu ID: {{$singleData->id}} @else Add New Menu @endif</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('menu_id') ? 'has-error' : '' }}">
                                {!! Form::label("Main Menu") !!} (Optional)
                                <select name="menu_id" class="form-control">
                                    <option value="">Select Main Menu</option>
                                    @foreach($menus as $row)
                                        <option value="{{$row->id}}" @if($row->id == $singleData->menu_id) selected @endif>{{$row->title}}</option>
                                    @endforeach
                                </select>
                                <em class="error-msg">{!!$errors->first('menu_id')!!}</em>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    {!! Form::label("Menu Title *") !!}
                                    {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter title')) !!}
                                    <em class="error-msg">{!!$errors->first('title')!!}</em>
                                </div>
                                <div class="col-sm-4 form-group {{ $errors->has('order') ? 'has-error' : '' }}">
                                    {!! Form::label("Order") !!}
                                    {!! Form::number('order', null, array('class' => 'form-control', 'placeholder' => 'Order')) !!}
                                    <em class="error-msg">{!!$errors->first('order')!!}</em>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                                    {!! Form::label("Page URL *") !!}
                                    <select name="url" class="form-control">
                                        <option value="">Select Page URL</option>
                                        <option value="parent">Parent *</option>
                                        @foreach($pages as $row)
                                            <option value="{{$row->slug}}"  @if($row->slug == $singleData->url) selected @endif>{{$row->title}}</option>
                                        @endforeach
                                    </select>
                                    <em class="error-msg">{!!$errors->first('url')!!}</em>
                                </div>
                                <div class="col-sm-4 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                    {!! Form::label("Type *") !!}
                                    {!! Form::select('type', $types, null, array('class' => 'form-control', 'placeholder' => 'Position')) !!}
                                    <em class="error-msg">{!!$errors->first('type')!!}</em>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($singleData->id)
                                <div class="pull-right form-group">
                                    <label class="switch" title="@if($singleData->status == 1) Enabled @else Disabled @endif">
                                        <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-check-circle-o"></span> @if($singleData->id) Update @else Create @endif
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-8">
                        <div class="box-header">
                            <h3 class="box-title">List of Page Menus</h3>
                            <small class="pull-right">
                                <a href="{{url('admin/'.$module.'s')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Menu</a>
                            </small>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($allData as $row)
                                        @php $subMenus = $row->subMenus; @endphp
                                        <?php $count++; ?>
                                        <tr class="@if($row->status==0) disabledBg @endif">
                                            <td>{{$row->order}}</td>
                                            <td>{!!$row->title!!}</td>
                                            <td>{!!$row->url!!}</td>
                                            <td>{!!$row->type!!}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning" href="{{url('admin/'.$module.'/'.$row->id.'/edit')}}"><i class="fa fa-edit"> </i></a>
                                                <a class="btn btn-sm btn-danger" href="{{url('admin/'.$module.'/'.$row->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this menu & submenus ?')){return false;}"><i class="fa fa-trash-o"> </i></a>
                                            </td>
                                        </tr>
                                        @foreach($subMenus as $list)
                                            <tr>
                                                <td></td>
                                                <td style="padding-left: 20px"><span style="padding-right: 10px">{{$list->order}}</span> {!!$list->title!!}</td>
                                                <td>{!!$list->url!!}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger" href="{{url('admin/'.$module.'-sub/'.$list->id.'/delete')}}" onclick="if(!confirm('Are you sure to delete this submenu ?')){return false;}"><i class="fa fa-trash-o"> </i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
@endsection