@extends('admin.layouts.app')

@section('htmlheader_title')
    Photo Albums
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> @if($singleData->photo) Edit {{$module}} album ID: {{$singleData->photoAlbum->id}} @else Add new {{$module}} album @endif</span>
@endsection

@section('contentheader_description')
    Maximum file upload size 10MB, Maximum number of images 10, at one upload
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/photos')}}"> {{$module}} Albums</a></li>
        <li class="text-capitalize active">@if($singleData->photo) Edit {{$module}} album ID: {{$singleData->photoAlbum->id}} @else Add new photo album @endif</li>
    </ol>
@endsection

@section('actions')
    @if($singleData->photo)
        <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->photoAlbum->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
        <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->photoAlbum->id.'/view')}}"><i class="fa fa-eye"></i> <span>View</span></a></li>
    @endif
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                {!!csrf_field()!!}
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('PhotoAlbums.content') ? 'has-error' : '' }}">
                                {!!Form::label("Album Description")!!}
                                {!!Form::textarea('photoAlbum[content]', null, array('class' => 'form-control', 'placeholder' => 'Enter album content'))!!}
                                <em class="error-msg">{!!$errors->first('photoAlbum.content')!!}</em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-pull-4">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('photoAlbum.title') ? 'has-error' : '' }}">
                                {!!Form::label("Album Name *")!!}
                                {!!Form::text('photoAlbum[title]', null, array('class' => 'form-control', 'placeholder' => 'Enter album name'))!!}
                                <em class="error-msg">{!!$errors->first('photoAlbum.title')!!}</em>
                            </div>
                            @if($singleData->photo)
                                <div class=" form-group {{ $errors->has('photoAlbum.slug') ? 'has-error' : '' }}">
                                    {!!Form::label("Slug *")!!}
                                    {!!Form::text('photoAlbum[slug]', null, array('class' => 'form-control'))!!}
                                    <em class="error-msg">{!!$errors->first('photoAlbum.slug')!!}</em>
                                    <em class="small-font">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</em>
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('photo.image') ? 'has-error' : '' }}">
                                @if($singleData->photo){!!Form::label("Upload More Images *")!!} @else {!!Form::label("Upload Images *")!!}@endif
                                {!!Form::file('photo[image][]', array('id' => 'photosImage', 'multiple', 'accept'=>'image/*'))!!}
                                <em class="error-msg">{!!$errors->first('photo.image')!!}</em>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right form-group">
                                @if($singleData->photo)
                                <label class="switch">
                                    <input type="checkbox" name="status" value="1" @if($singleData->photoAlbum->status == 1) checked @endif >
                                    <div class="slider round"></div>
                                </label>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle-o"></i> @if(count($singleData->photo)>0) Update @else Create @endif
                            </button>
                            <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-times-circle-o"></i> Cancel </a>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
                @if(count($singleData->photo)>0)
                    <div class="box-header">
                        <h3 class="box-title">Album Images</h3>
                    </div>
                    <div id="slide" class="box-body">
                        <input type="hidden" id="table_name" value="photos">
                        <table class="table table-hover innovay-sortable-order">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 0;
                            $photos = null;
                            if(count($singleData->photo) > 0) {
                                $photos = $singleData->photo;
                            }
                            ?>
                            @foreach($photos as $row)
                                <?php $count++; ?>
                                <tr id="{{$row->id}}">
                                    <td class="priority">{{$count}}</td>
                                    <td><i class="fa fa-arrows-alt"></i></td>
                                    <td><img title="{{$row->image}}" height="30" src="{{asset('storage/'.$module.'s/'.$row->album_id.'/'.$row->image)}}"> </td>
                                    <td>
                                        {!!Form::model($row, ['url' => 'admin/photos/photo/'.$row->id.'/update']) !!}
                                        {!!csrf_field()!!}
                                        {!!Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title'])!!}
                                    </td>
                                    <td>
                                        {!!Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description'])!!}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i></button>
                                        {!!Form::close()!!}
                                        @if(count($singleData->photo)>1)
                                            <a class="btn btn-sm btn-danger" href="{{url('admin/'.$module.'s/photo/'.$row->id.'/delete')}}"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection