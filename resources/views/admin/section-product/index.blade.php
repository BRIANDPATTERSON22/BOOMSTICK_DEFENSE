@extends('admin.layouts.app')

@section('htmlheader_title')
   Section Offer
@endsection

@section('contentheader_title')
   Section Offer
@endsection

@section('contentheader_description')
    Manage web-site settings and options
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Section Offer</li>
    </ol>
@endsection

@section('main-content')

<div class="nav-tabs-custom">
     @include('admin.'.$module.'.header')
    <div class="tab-content">
        <div class="tab-pane active">
            {!!Form::model($singleData, array('files' => true, 'autocomplete' => 'off'))!!}
            {!!csrf_field()!!}

            <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('section_title_word_1') ? 'has-error' : '' }}">
                            {!!Form::label("Section Title 1st word")!!}
                            {!!Form::text('section_title_word_1', null, ['class' => 'form-control', 'placeholder' => 'Enter section title first word'])!!}
                            <em class="error-msg">{!!$errors->first('section_title_word_1')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('column_title_1') ? 'has-error' : '' }}">
                            {!!Form::label("Column 1 title")!!}
                            {!!Form::text('column_title_1', null, ['class' => 'form-control', 'placeholder' => 'Column title 1'])!!}
                            <em class="error-msg">{!!$errors->first('column_title_1')!!}</em>
                        </div>

                        <div class="form-group">
                            <label for="" style="display: block">Enable/ Disable Column 1</label>
                            <label class="switch" title="@if($singleData->is_active_column_1 == 1) Enabled @else Disabled @endif">
                                <input type="checkbox" name="is_active_column_1" value="1" @if($singleData->is_active_column_1 == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('section_title_word_1_color') ? 'has-error' : '' }}">
                            {!!Form::label("Section Title 1st word Color")!!}
                            <div class="" style="background-color: {{$singleData->section_title_word_1_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('section_title_word_1_color', null, ['class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Enter section title 1st word color'])!!}
                            <em class="error-msg">{!!$errors->first('section_title_word_1_color')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('column_title_2') ? 'has-error' : '' }}">
                            {!!Form::label("Column 2 title")!!}
                            {!!Form::text('column_title_2', null, ['class' => 'form-control', 'placeholder' => 'Column title 1'])!!}
                            <em class="error-msg">{!!$errors->first('column_title_2')!!}</em>
                        </div>
                        <div class="form-group">
                            <label for="" style="display: block">Enable/ Disable Column 2</label>
                            <label class="switch" title="@if($singleData->is_active_column_2 == 1) Enabled @else Disabled @endif">
                                <input type="checkbox" name="is_active_column_2" value="1" @if($singleData->is_active_column_2 == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">

                        <div class="form-group {{ $errors->has('section_title_word_2') ? 'has-error' : '' }}">
                            {!!Form::label("Section Title 2nd word")!!}
                            {!!Form::text('section_title_word_2', null, ['class' => 'form-control', 'placeholder' => 'Enter section title secound word'])!!}
                            <em class="error-msg">{!!$errors->first('section_title_word_2')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('column_title_3') ? 'has-error' : '' }}">
                            {!!Form::label("Column 3 title")!!}
                            {!!Form::text('column_title_3', null, ['class' => 'form-control', 'placeholder' => 'Column title 3'])!!}
                            <em class="error-msg">{!!$errors->first('column_title_3')!!}</em>
                        </div>

                        <div class="form-group">
                            <label for="" style="display: block">Enable/ Disable Column 3</label>
                            <label class="switch" title="@if($singleData->is_active_column_3 == 1) Enabled @else Disabled @endif">
                                <input type="checkbox" name="is_active_column_3" value="1" @if($singleData->is_active_column_3 == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>
                      
                    </div>
                </div>

            </div>

            <div class="box box-primary"><div class="box-header with-border"><h3 class="box-title">Product Global Settings</h3></div></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" style="display: block">Globally Enable/ Disable shopping</label>
                            <label class="switch" title="@if($siteThemeSettings->is_active_shopping == 1) Enabled @else Disabled @endif">
                                <input type="checkbox" name="is_active_shopping" value="1" @if($siteThemeSettings->is_active_shopping == 1) checked @endif >
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('section_display_type') ? 'has-error' : '' }}">
                            {!!Form::label("Display Type")!!}
                            <?php $section_display_type = ['1' => 'Blocks', '2' => 'Carosol'] ?>
                            {{-- {!!Form::select('section_display_type', $section_display_type, null, ['class' => 'form-control', 'placeholder' => 'Display Type',])!!} --}}
                            <select class="form-control" name="section_display_type">
                                <option value="" name="">Display Type</option>
                                @foreach($section_display_type as $key => $value)
                                    <option value="{{$key}}" name="" {{$siteThemeSettings->section_display_type == $key ? 'selected="selected"' : ''}}> {{$value}} </option>
                                @endforeach
                            </select>
                            <em class="error-msg">{!!$errors->first('section_display_type')!!}</em>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('carosel_category') ? 'has-error' : '' }}">
                            {!!Form::label("Carosel Category")!!}
                            <?php $carosel_category = ['1' => 'Best Sellers', '2' => 'New Arrivals', 'Top Viewed'] ?>
                            {{-- {!!Form::select('carosel_category', $carosel_category, null, ['class' => 'form-control', 'placeholder' => 'Carosol Category'])!!} --}}
                            <select class="form-control" name="carosel_category">
                                <option value="" name="">Display Type</option>
                                @foreach($carosel_category as $key => $value)
                                    <option value="{{$key}}" name="" {{$siteThemeSettings->carosel_category == $key ? 'selected="selected"' : ''}}> {{$value}} </option>
                                @endforeach
                            </select>
                            <em class="error-msg">{!!$errors->first('carosel_category')!!}</em>
                        </div>
                    </div>
                </div>

            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check-circle-o"></i> Save
                </button>
                <a class="btn btn-default" href="{{url('admin/dashboard')}}"><i class="fa fa-times-circle-o"></i> Cancel</a>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection