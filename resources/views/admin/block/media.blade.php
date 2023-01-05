@extends('admin.layouts.app')

@section('htmlheader_title')
    Media
@endsection

@section('contentheader_title')
    List of Media(s) created in the year {{$year}}
@endsection

@section('contentheader_description')
    Manage images for static pages/blocks of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize active">Media(s)</li>
    </ol>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li @if(Request::is('*media')) class="active" @endif><a href="{{url('admin/media')}}"><i class="fa fa-medium"></i> <span>Media</span></a></li>
            <li class="dropdown @if(Request::is('*archive*')) active @endif">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                    <i class="fa fa-archive"></i> Archive <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    @php
                        $years = null;
                        for($i= config('default.year'); $i<date('Y'); $i++){
                            $years [] = $i;
                        }
                    @endphp
                    @foreach($years as $year)
                        <li><a href="{{ url('admin/media/archive/'.$year) }}"> Media Created in the Year {{$year}}</a></li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
                {!!csrf_field()!!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3 form-group {{ $errors->has('photo.image') ? 'has-error' : '' }}">
                            @if($singleData->photo){!!Form::label("Upload More Images *")!!} @else {!!Form::label("Upload Images *")!!}@endif
                            {!!Form::file('photo[image][]', array('id' => 'photosImage', 'multiple', 'accept'=>'image/*'))!!}
                            <em class="error-msg">{!!$errors->first('photo.image')!!}</em>
                        </div>
                        <div class="col-md-2 form-group" style="margin-top: 18px">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Upload</button>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}

                <div class="box-body">
                    <div class="row">
                        @foreach ($allData as $row)
                            <div class="col-sm-3" style="margin-bottom: 15px">
                                <div class="gallery-thumb" style="background-image: url('{{asset('storage/uploads/'.$row->image)}}')"></div>
                                <div class="corner-action">
                                    <a data-toggle="modal" data-target="#view{{$row->id}}"> <i class="fa fa-search-plus"></i> </a>
                                    <a id="copy_{{$row->id}}" onclick="copy_to_clipboard(this.id)"> <i class="fa fa-copy"></i> </a>
                                    <a href="{{url('admin/media/'.$row->id.'/delete')}}"> <i class="fa fa-trash-o"></i> </a>
                                </div>
                                <input type="text" class="form-control" id="imgLink_{{$row->id}}" value="storage/uploads/{{$row->image}}" readonly/>
                            </div>
                            <div class="modal fade" id="view{{$row->id}}" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">View Media</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <img src="{{asset('storage/uploads/'.$row->image)}}" class="img-responsive">
                                            </div>
                                            <p>
                                                <strong>Image Link:</strong> <span id="imgLink">{{asset('storage/uploads/'.$row->image)}}</span>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        function copy_to_clipboard(id) {
            var splits = id.split("_");
            var linkId = "imgLink_"+splits[1];
            var copyText = document.getElementById(linkId);
            copyText.select();
            document.execCommand("copy");
            //alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection