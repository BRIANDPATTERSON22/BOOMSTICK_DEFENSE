@extends('admin.layouts.app')

@section('htmlheader_title')
    Sliders
@endsection

@section('contentheader_title')
    Sliders
@endsection

@section('contentheader_description')
    Manage home page sliders
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Sliders</li>
    </ol>
@endsection

@section('main-content')
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if(count($errors) > 0)<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>@endif
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) disabledBg @endif">
                <?php $types = [''=>'Select slider type', 'image'=>'Image', 'video'=>'Video', 'slider'=>'Slider']; ?>
                <div class="row">
                    {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                    {!!csrf_field()!!}
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('display') ? 'has-error' : '' }}">
                                {!!Form::hidden('type', 'slider', ['class' => 'form-control'])!!}
                                <em class="error-msg">{!!$errors->first('display')!!}</em>
                            </div>
                            @if($singleData->type == "image")
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    {!!Form::label("Upload Single Image")!!}
                                    {!!Form::file('image', ['accept'=>'image/*'])!!}
                                    @if($singleData->id && !empty($singleData->image))
                                        <div class="col-md-12 P0">
                                            <div class="image-close pull-right"><a href="{{ url('admin/'.$module.'s/data/image/'.$singleData->id.'/delete')}}"><i class="fa fa-close"></i></a></div>
                                            <img src="{{Storage::url($module.'s/'.$singleData->image)}}" alt="Image" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                                <em class="error-msg">{!!$errors->first('image')!!}</em>
                            @endif
                            @if($singleData->type == "video")
                                <div class="form-group {{ $errors->has('video') ? 'has-error' : '' }}">
                                    {!!Form::label("Upload Video")!!}
                                    {!!Form::file('video', ['accept'=>'video/*'])!!}
                                    @if($singleData->id && !empty($singleData->video))
                                        <div class="col-md-12 P0">
                                            <div class="image-close pull-right"><a href="{{ url('admin/sliders/data/video/'.$singleData->id.'/delete')}}"><i class="fa fa-close"></i></a></div>
                                            <video width="100%" autoplay loop muted poster="{{asset('admin/img/intro-bg.jpg')}}">
                                                <source src="{{Storage::url($module.'s/'.$singleData->video)}}" type="video/ogg">
                                                <source src="{{Storage::url($module.'s/'.$singleData->video)}}" type="video/mp4">
                                                <source src="{{Storage::url($module.'s/'.$singleData->video)}}" type="video/webm">
                                            </video>
                                        </div>
                                    @endif
                                </div>
                                <em class="error-msg">{!!$errors->first('video')!!}</em>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-body">
                            @if($singleData->type != "slider")
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!!Form::label("Main title *")!!}
                                    {!!Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter the main title'))!!}
                                    <em class="error-msg">{!!$errors->first('name')!!}</em>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group {{ $errors->has('title1') ? 'has-error' : '' }}">
                                        {!!Form::label("Title 1")!!}
                                        {!!Form::text('title1', null, array('class' => 'form-control', 'placeholder' => 'Enter title1'))!!}
                                        <em class="error-msg">{!!$errors->first('title1')!!}</em>
                                    </div>
                                    <div class="col-md-6 form-group {{ $errors->has('title2') ? 'has-error' : '' }}">
                                        {!!Form::label("Title 2")!!}
                                        {!!Form::text('title2', null, array('class' => 'form-control', 'placeholder' => 'Enter title2'))!!}
                                        <em class="error-msg">{!!$errors->first('title2')!!}</em>
                                    </div>
                                </div>
                            @endif

                            @if($singleData->type == "slider")
                                <div class="form-group">
                                    {!!Form::label("Upload Slide Images [Size: 1159 x 398px] [Backgroundd: White]")!!}
                                    {!!Form::file('photo[image][]', ['id' => 'photosImage', 'multiple', 'accept'=>'image/*'])!!}
                                </div>
                            @endif
                        </div>
                        <div class="box-footer">
                            <div class="pull-right form-group">
                                <label class="switch" title="@if($singleData->status == 1) Enabled @else Disabled @endif">
                                    <input type="checkbox" name="status" value="1" @if($singleData->status == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if($singleData->id) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
                @if($singleData->type == "slider" && count($photos)>0)
                    <div class="box-header">
                        <h3 class="box-title">Slider Images</h3>
                    </div>
                    <div id="slide" class="box-body">
                        <div class="table-responsive">
                            <input type="hidden" id="table_name" value="slider_images">
                            <table class="table table-hover innovay-sortable-order">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Link</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count = 0; ?>
                                @foreach($photos as $row)
                                    <?php $count++; ?>
                                    <tr id="{{$row->id}}">
                                        <td class="priority">{{$count}}</td>
                                        <td><i class="fa fa-arrows-alt"></i></td>
                                        <td><img title="{{$row->image}}" height="30" src="{{asset('storage/sliders/'.$row->image)}}"> </td>
                                        <td>
                                            {!!Form::model($row, ['url' => 'admin/sliders/photo/'.$row->id.'/update']) !!}
                                            {!!csrf_field()!!}
                                            {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title'])!!}
                                        </td>
                                        <td>
                                            {!!Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description'])!!}
                                        </td>
                                        <td>
                                            {!!Form::text('link1', null, ['class' => 'form-control', 'placeholder' => 'Enter Product link'])!!}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i></button>
                                            {!!Form::close()!!}
                                            <a class="btn btn-sm btn-danger" href="{{url('admin/sliders/photo/'.$row->id.'/delete')}}"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection