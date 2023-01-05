@extends('admin.layouts.app')

@section('htmlheader_title')
	Options
@endsection

@section('contentheader_title')
    Options
@endsection

@section('contentheader_description')
    Manage web-site settings and options
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Options</li>
    </ol>
@endsection


@section('page-style')
    <style>
        #editor { width: 100%; height: 150px;}
    </style>
@endsection

@section('main-content')

{!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
{!!csrf_field()!!}
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!!Form::label("Site Name *")!!}
                            {!!Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter the site name'))!!}
                            <em class="error-msg">{!!$errors->first('name')!!}</em>
                        </div>
                         <div class="col-md-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Site Title *")!!}
                            {!!Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter the site title'))!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('phone_no') ? 'has-error' : '' }}">
                            {!!Form::label("Phone No")!!}
                            {!!Form::text('phone_no', null, array('class' => 'form-control', 'placeholder' => 'Enter phone number'))!!}
                            <em class="error-msg">{!!$errors->first('phone_no')!!}</em>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!!Form::label("Email Address *")!!}
                            {!!Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Enter email address'))!!}
                            <em class="error-msg">{!!$errors->first('email')!!}</em>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                            {!!Form::label("Mobile No")!!}
                            {!!Form::text('mobile_no', null, array('class' => 'form-control', 'placeholder' => 'Enter mobile number'))!!}
                            <em class="error-msg">{!!$errors->first('mobile_no')!!}</em>
                        </div>
                        <div class="col-md-3 form-group {{ $errors->has('fax_no') ? 'has-error' : '' }}">
                            {!!Form::label("Fax No")!!}
                            {!!Form::text('fax_no', null, array('class' => 'form-control', 'placeholder' => 'Enter fax number'))!!}
                            <em class="error-msg">{!!$errors->first('fax_no')!!}</em>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 {{ $errors->has('address') ? 'has-error' : '' }}">
                            {!!Form::label("Address")!!}
                            {!!Form::textarea('address', null, array('class' => 'form-control', 'placeholder' => 'Enter the address', 'rows' => 3))!!}
                            <em class="error-msg">{!!$errors->first('address')!!}</em>
                        </div>
                        <div class="form-group col-md-6 {{ $errors->has('branch') ? 'has-error' : '' }}">
                            {!!Form::label("Branch")!!}
                            {!!Form::textarea('branch', null, array('class' => 'form-control', 'placeholder' => 'Enter the branch', 'rows' => 3))!!}
                            <em class="error-msg">{!!$errors->first('branch')!!}</em>
                        </div>
                        {{-- <div class="form-group col-md-6 {{ $errors->has('address_1') ? 'has-error' : '' }}">
                            {!!Form::label("Address 2")!!}
                            {!!Form::textarea('address_1', null, array('class' => 'form-control', 'placeholder' => 'Enter the address', 'rows' => 3))!!}
                            <em class="error-msg">{!!$errors->first('address_1')!!}</em>
                        </div> --}}
                        {{-- <div class="form-group col-md-6 {{ $errors->has('branch_1') ? 'has-error' : '' }}">
                            {!!Form::label("Branch 2")!!}
                            {!!Form::textarea('branch_1', null, array('class' => 'form-control', 'placeholder' => 'Enter the branch', 'rows' => 3))!!}
                            <em class="error-msg">{!!$errors->first('branch_1')!!}</em>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="{{url('admin/'.$module.'s')}}">
                    <i class="fa fa-list"></i> <span>SEO</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group  col-md-6{{ $errors->has('title') ? 'has-error' : '' }}">
                            {!!Form::label("Meta Title")!!}
                            {!!Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter meta title'))!!}
                            <em class="error-msg">{!!$errors->first('title')!!}</em>
                        </div>
                        <div class="form-group  col-md-6{{ $errors->has('keywords') ? 'has-error' : '' }}">
                            {!!Form::label("Meta Keywords")!!}
                            {!!Form::text('keywords', null, array('class' => 'form-control', 'placeholder' => 'Enter meta keywords'))!!}
                            <em class="error-msg">{!!$errors->first('keywords')!!}</em>
                        </div>
                        <div class="form-group  col-md-12{{ $errors->has('description') ? 'has-error' : '' }}">
                            {!!Form::label("Meta Description")!!}
                            {!!Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => 'Enter meta description', 'rows'=>4))!!}
                            <em class="error-msg">{!!$errors->first('description')!!}</em>
                        </div>
                        <div class="form-group col-md-4{{ $errors->has('google_analytics') ? 'has-error' : '' }}">
                            {!!Form::label("Google Analytics Code")!!}
                            {!!Form::text('google_analytics', null, array('class' => 'form-control', 'placeholder' => 'Enter google analytics code'))!!}
                            <em class="error-msg">{!!$errors->first('google_analytics')!!}</em>
                        </div>
                        <div class="col-md-4 form-group {{ $errors->has('latitude') ? 'has-error' : '' }}">
                            {!!Form::label("Latitude")!!}
                            {!!Form::text('latitude', null, array('class' => 'form-control', 'placeholder' => 'Enter latitude'))!!}
                            <em class="error-msg">{!!$errors->first('latitude')!!}</em>
                        </div>
                        <div class="col-md-4 form-group {{ $errors->has('longitude') ? 'has-error' : '' }}">
                            {!!Form::label("Longitude")!!}
                            {!!Form::text('longitude', null, array('class' => 'form-control', 'placeholder' => 'Enter longitude'))!!}
                            <em class="error-msg">{!!$errors->first('longitude')!!}</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="{{url('admin/'.$module.'s')}}">
                    <i class="fa fa-list"></i> <span>Social Media</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('viber_no') ? 'has-error' : '' }}">
                            {!!Form::label("viber_no")!!}
                            {!!Form::text('viber_no', null, array('class' => 'form-control', 'placeholder' => 'Enter the viber no'))!!}
                            <em class="error-msg">{!!$errors->first('viber_no')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('whatsapp_no') ? 'has-error' : '' }}">
                            {!!Form::label("whatsapp_no")!!}
                            {!!Form::text('whatsapp_no', null, array('class' => 'form-control', 'placeholder' => 'Enter the whatsapp no'))!!}
                            <em class="error-msg">{!!$errors->first('whatsapp_no')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('skype_id') ? 'has-error' : '' }}">
                            {!!Form::label("skype_id")!!}
                            {!!Form::text('skype_id', null, array('class' => 'form-control', 'placeholder' => 'Enter the skype id'))!!}
                            <em class="error-msg">{!!$errors->first('skype_id')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('facebook') ? 'has-error' : '' }}">
                            {!!Form::label("Facebook")!!}
                            {!!Form::url('facebook', null, array('class' => 'form-control', 'placeholder' => 'Enter facebook url'))!!}
                            <em class="error-msg">{!!$errors->first('facebook')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('twitter') ? 'has-error' : '' }}">
                            {!!Form::label("Twitter")!!}
                            {!!Form::url('twitter', null, array('class' => 'form-control', 'placeholder' => 'Enter twitter url'))!!}
                            <em class="error-msg">{!!$errors->first('twitter')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('youtube') ? 'has-error' : '' }}">
                            {!!Form::label("Youtube")!!}
                            {!!Form::url('youtube', null, array('class' => 'form-control', 'placeholder' => 'Enter youtube url'))!!}
                            <em class="error-msg">{!!$errors->first('youtube')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('pinterest') ? 'has-error' : '' }}">
                            {!!Form::label("Pinterest")!!}
                            {!!Form::url('pinterest', null, array('class' => 'form-control', 'placeholder' => 'Enter pinterest url'))!!}
                            <em class="error-msg">{!!$errors->first('pinterest')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('instagram') ? 'has-error' : '' }}">
                            {!!Form::label("Instagram")!!}
                            {!!Form::url('instagram', null, array('class' => 'form-control', 'placeholder' => 'Enter instagram url'))!!}
                            <em class="error-msg">{!!$errors->first('instagram')!!}</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="{{url('admin/'.$module.'s')}}">
                    <i class="fa fa-list"></i> <span>Styles</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6 {{ $errors->has('is_sidebar_collapsed') ? 'has-error' : '' }}">
                            <?php $sideBarOptions = ['0' => 'No Collapse', '1' => 'Collapsed'] ?>
                            {!!Form::label("admin_sidebar_style")!!}
                            {!!Form::select('is_sidebar_collapsed', $sideBarOptions, null ,array('class' => 'form-control select2', 'placeholder' => 'Select side bar style'))!!}
                            <em class="error-msg">{!!$errors->first('is_sidebar_collapsed')!!}</em>
                        </div>
                        <div class="form-group col-md-6 {{ $errors->has('sidebar_skin_color') ? 'has-error' : '' }}">
                            <?php $sideBarOptions = ['skin-blue' => 'skin-blue', 'skin-blue-light' => 'skin-blue-light', 'skin-yellow' => 'skin-yellow', 'skin-yellow-light' => 'skin-yellow-light', 'skin-green' => 'skin-green', 'skin-green-light' => 'skin-green-light', 'skin-purple' => 'skin-purple', 'skin-purple-light' => 'skin-purple-light', 'skin-red' => 'skin-red', 'skin-red-light' => 'skin-red-light', 'skin-black' => 'skin-black', 'skin-black-light' => 'skin-black-light'] ?>
                            {!!Form::label("admin_skin_color")!!}
                            {!!Form::select('sidebar_skin_color', $sideBarOptions, null ,array('class' => 'form-control select2', 'placeholder' => 'Select side bar style'))!!}
                            <em class="error-msg">{!!$errors->first('sidebar_skin_color')!!}</em>
                        </div>
                        <div class="col-md-12 form-group">
                            {!!Form::label("CSS Editor")!!} <a href="{{ url('/site/css/styles.css') }}" target="_blank"> (View Default Style sheet)</a>
                            <div id="editor">
                                {{ $singleData->custom_css_style }}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('custom_css_style') ? 'has-error' : '' }}">
                            {!!Form::hidden('content_value', null, ['id' => 'editorValue'])!!}
                            <em class="error-msg">{!!$errors->first('custom_css_style')!!}</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="{{url('admin/'.$module.'s')}}">
                    <i class="fa fa-list"></i> <span>Credits</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                            {!!Form::label("Site developed by")!!}
                            {!!Form::text('company_name', null, array('class' => 'form-control', 'placeholder' => 'Company Name'))!!}
                            <em class="error-msg">{!!$errors->first('company_name')!!}</em>
                        </div>
                        <div class="col-md-6 form-group {{ $errors->has('company_website') ? 'has-error' : '' }}">
                            {!!Form::label("URL")!!}
                            {!!Form::text('company_website', null, array('class' => 'form-control', 'placeholder' => 'Company Web URL'))!!}
                            <em class="error-msg">{!!$errors->first('company_website')!!}</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="{{url('admin/'.$module.'s')}}">
                    <i class="fa fa-list"></i> <span>Logo</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                            {!!Form::label("Site developed by")!!}
                            {!!Form::text('company_name', null, array('class' => 'form-control', 'placeholder' => 'Company Name'))!!}
                            <em class="error-msg">{!!$errors->first('company_name')!!}</em>
                        </div>
                        <div class="col-md-6 form-group {{ $errors->has('company_website') ? 'has-error' : '' }}">
                            {!!Form::label("URL")!!}
                            {!!Form::text('company_website', null, array('class' => 'form-control', 'placeholder' => 'Company Web URL'))!!}
                            <em class="error-msg">{!!$errors->first('company_website')!!}</em>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('logo') ? 'has-error' : '' }}">
                            {!!Form::label("Logo [270 x 70]")!!}
                            {!!Form::file('logo', ['accept'=>'image/*'])!!}
                            @if ($singleData->logo)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image-close"><a href="{{url('admin/options/delete-logo')}}"><i class="fa fa-close"></i></a></div>
                                    <img src="{{asset('storage/options/'.$singleData->logo)}}" alt="Logo" class="img-thumbnail"/>
                                </div>
                            </div>
                            @endif
                        </div>
                        <em class="error-msg">{!!$errors->first('logo')!!}</em>

                        <div class="form-group col-md-4 {{ $errors->has('favicon') ? 'has-error' : '' }}">
                            {!!Form::label("Favicon [100x100]")!!}
                            {!!Form::file('favicon', ['accept'=>'image/*'])!!}
                            @if($singleData->favicon)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image-close"><a href="{{url('admin/options/delete-favicon')}}"><i class="fa fa-close"></i></a></div>
                                    <img src="{{asset('storage/options/'.$singleData->favicon)}}" alt="Favicon" class="img-thumbnail"/>
                                </div>
                            </div>
                            @endif
                        </div>
                        <em class="error-msg">{!!$errors->first('favicon')!!}</em>

                        <div class="form-group col-md-4 {{ $errors->has('bg_breadcrumb') ? 'has-error' : '' }}">
                            {!!Form::label("breadcrumb [1400x600]")!!}
                            {!!Form::file('bg_breadcrumb', ['accept'=>'image/*'])!!}
                            @if($singleData->bg_breadcrumb)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image-close"><a href="{{url('admin/options/delete-bg_breadcrumb')}}"><i class="fa fa-close"></i></a></div>
                                    <img src="{{asset('storage/options/'.$singleData->bg_breadcrumb)}}" alt="Favicon" class="img-thumbnail"/>
                                </div>
                            </div>
                            @endif
                        </div>
                        <em class="error-msg">{!!$errors->first('bg_breadcrumb')!!}</em>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-success" onclick="get_editor_value()">
                        <i class="fa fa-check-circle-o"></i> Update
                    </button>
                    <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-times-circle-o"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
{!!Form::close()!!}
   
@endsection

@section('page-script')
    <script src="{{asset('/plugins/ace-editor/ace.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/javascript");

        function get_editor_value(){
            var code = editor.getValue();
            document.getElementById("editorValue").value = code;
        }
    </script>
@endsection