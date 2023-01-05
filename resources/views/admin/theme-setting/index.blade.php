@extends('admin.layouts.app')

@section('htmlheader_title')
    Theme Settings
@endsection

@section('contentheader_title')
    Theme Settings
@endsection

@section('contentheader_description')
    Manage web-site settings and options
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Theme Settings</li>
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
                        <div class="form-group {{ $errors->has('top_bar_color') ? 'has-error' : '' }}">
                            {!!Form::label("Top Bar Color")!!}
                            <div class="" style="background-color: {{$singleData->top_bar_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('top_bar_color', null, ['class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Top Bar Color'])!!}
                            <em class="error-msg">{!!$errors->first('top_bar_color')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('logo_size') ? 'has-error' : '' }}">
                            {!!Form::label("logo size")!!}
                            <?php $logo_size = ['1' => 'Small', '2' => 'Large'] ?>
                            {!!Form::select('logo_size', $logo_size, null, ['class' => 'form-control', 'placeholder' => 'Select logo size'])!!}
                            <em class="error-msg">{!!$errors->first('logo_size')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            {!!Form::label("logo background color")!!}
                             <div class="" style="background-color: {{$singleData->logo_background_color}}; width: 30px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('logo_background_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select logo background color'))!!}
                            <em class="error-msg">{!!$errors->first('description')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('logo_background_block_color') ? 'has-error' : '' }}">
                            {!!Form::label("logo background block color")!!}
                             <div class="" style="background-color: {{$singleData->logo_background_block_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('logo_background_block_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select logo background block color'))!!}
                            <em class="error-msg">{!!$errors->first('logo_background_block_color')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('logo_block_border_color') ? 'has-error' : '' }}">
                            {!!Form::label("logo block right border color")!!}
                              <div class="" style="background-color: {{$singleData->logo_block_border_color}}; width: 30px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('logo_block_border_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select logo block right border color'))!!}
                            <em class="error-msg">{!!$errors->first('logo_block_border_color')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('footer_background') ? 'has-error' : '' }}">
                            {!!Form::label("Footer Background Color")!!}
                              <div class="" style="background-color: {{$singleData->footer_background}}; width: 30px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('footer_background', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Footer Background Colorr'))!!}
                            <em class="error-msg">{!!$errors->first('footer_background')!!}</em>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('search_bgc') ? 'has-error' : '' }}">
                            {!!Form::label("Search Box background")!!}
                              <div class="" style="background-color: {{$singleData->search_bgc}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('search_bgc', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Search box background'))!!}
                            <em class="error-msg">{!!$errors->first('search_bgc')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('search_box_shape') ? 'has-error' : '' }}">
                            {!!Form::label("Search Box shape")!!}
                            <?php $search_box_shape = ['1' => 'Oval', '2' => 'Square'] ?>
                            {!!Form::select('search_box_shape', $search_box_shape, null, ['class' => 'form-control', 'placeholder' => 'Select search box shape'])!!}
                            <em class="error-msg">{!!$errors->first('search_box_shape')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('social_media_bgc') ? 'has-error' : '' }}">
                            {!!Form::label("Social media icon background")!!}
                             <div class="" style="background-color: {{$singleData->social_media_bgc}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('social_media_bgc', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Social media icon background'))!!}
                            <em class="error-msg">{!!$errors->first('social_media_bgc')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('social_media_border_color') ? 'has-error' : '' }}">
                            {!!Form::label("Social media border color")!!}
                             <div class="" style="background-color: {{$singleData->social_media_border_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('social_media_border_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Select Social media icon border color'))!!}
                            <em class="error-msg">{!!$errors->first('social_media_border_color')!!}</em>
                        </div>
                        
                        <div class="form-group {{ $errors->has('is_active_social_media') ? 'has-error' : '' }}">
                            {!!Form::label("Enable/Disable Social media icon block")!!}
                            <?php $is_active_social_media = ['1' => 'Enable', '2' => 'Disable'] ?>
                            {!!Form::select('is_active_social_media', $is_active_social_media, null, ['class' => 'form-control', 'placeholder' => 'Enable/ Disable Social Media'])!!}
                            <em class="error-msg">{!!$errors->first('is_active_social_media')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('tool_bar_color') ? 'has-error' : '' }}">
                                {!!Form::label("Wishlist/account/cart background color")!!}
                                   <div class="" style="background-color: {{$singleData->tool_bar_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                                {!!Form::text('tool_bar_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Wishlist/account/cart background color'))!!}
                                <em class="error-msg">{!!$errors->first('tool_bar_color')!!}</em>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('tool_bar_border_color') ? 'has-error' : '' }}">
                            {!!Form::label("Wishlist/account/cart border color")!!}
                            <div class="" style="background-color: {{$singleData->tool_bar_border_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('tool_bar_border_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Wishlist/account/cart border color'))!!}
                            <em class="error-msg">{!!$errors->first('tool_bar_border_color')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('top_bar_botom') ? 'has-error' : '' }}">
                            {!!Form::label("Top bar bottom border")!!}
                            <div class="" style="background-color: {{$singleData->top_bar_botom}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('top_bar_botom', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Top bar bottom border'))!!}
                            <em class="error-msg">{!!$errors->first('top_bar_botom')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('main_menu_bgc') ? 'has-error' : '' }}">
                            {!!Form::label("Main menu background")!!}
                            <div class="" style="background-color: {{$singleData->main_menu_bgc}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('main_menu_bgc', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Main menu background'))!!}
                            <em class="error-msg">{!!$errors->first('main_menu_bgc')!!}</em>
                        </div>
    
                        <div class="form-group {{ $errors->has('main_menu_font_color') ? 'has-error' : '' }}">
                            {!!Form::label("Main menu font color")!!}
                            <div class="" style="background-color: {{$singleData->main_menu_font_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('main_menu_font_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Main menu font color'))!!}
                            <em class="error-msg">{!!$errors->first('main_menu_font_color')!!}</em>
                        </div>
                        
                        <div class="form-group {{ $errors->has('main_menu_active_font_color') ? 'has-error' : '' }}">
                            {!!Form::label("Main menu active font color")!!}
                             <div class="" style="background-color: {{$singleData->main_menu_active_font_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('main_menu_active_font_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Main menu active font color'))!!}
                            <em class="error-msg">{!!$errors->first('main_menu_active_font_color')!!}</em>
                        </div>

                        <div class="form-group {{ $errors->has('main_menu_type') ? 'has-error' : '' }}">
                            {!!Form::label("Main Menu Type")!!}
                            <?php $main_menu_type = ['1' => 'Categories Only', '2' => 'Categories and Other links'] ?>
                            {!!Form::select('main_menu_type', $main_menu_type, null, ['class' => 'form-control', 'placeholder' => 'Select Main Menu Type'])!!}
                            <em class="error-msg">{!!$errors->first('main_menu_type')!!}</em>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="box box-primary"><div class="box-header with-border"><h3 class="box-title">Section Header Colors</h3></div></div>
            <div class="row">
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('featured_products_title') ? 'has-error' : '' }}">
                            {!!Form::label("Featured Products Title")!!}
                            {!!Form::text('featured_products_title', null, array('class' => 'form-control', 'placeholder' => 'Featured Products Title'))!!}
                            <em class="error-msg">{!!$errors->first('featured_products_title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('featured_products_title_color') ? 'has-error' : '' }}">
                            {!!Form::label("Featured Products Title Color")!!}
                             <div class="" style="background-color: {{$singleData->featured_products_title_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('featured_products_title_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'Featured Products Title Color'))!!}
                            <em class="error-msg">{!!$errors->first('featured_products_title_color')!!}</em>
                        </div>
                    </div> 
                </div>
                
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('limited_time_offer_title') ? 'has-error' : '' }}">
                            {!!Form::label("Limited Time Offer title")!!}
                            {!!Form::text('limited_time_offer_title', null, array('class' => 'form-control', 'placeholder' => 'Limited Time Offer title'))!!}
                            <em class="error-msg">{!!$errors->first('limited_time_offer_title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('limited_time_offer_title_color') ? 'has-error' : '' }}">
                            {!!Form::label("limited time offer color")!!}
                             <div class="" style="background-color: {{$singleData->limited_time_offer_title_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('limited_time_offer_title_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'limited time offer Title Color'))!!}
                            <em class="error-msg">{!!$errors->first('limited_time_offer_title_color')!!}</em>
                        </div>
                    </div> 
                </div>
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('staff_picks_title') ? 'has-error' : '' }}">
                            {!!Form::label("Staff picks title")!!}
                            {!!Form::text('staff_picks_title', null, array('class' => 'form-control', 'placeholder' => 'Limited Time Offer title'))!!}
                            <em class="error-msg">{!!$errors->first('staff_picks_title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('staff_picks_title_color') ? 'has-error' : '' }}">
                            {!!Form::label("Staff picks title color")!!}
                             <div class="" style="background-color: {{$singleData->staff_picks_title_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('staff_picks_title_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'limited time offer Title Color'))!!}
                            <em class="error-msg">{!!$errors->first('staff_picks_title_color')!!}</em>
                        </div>
                    </div> 
                </div>
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('popular_brands_title') ? 'has-error' : '' }}">
                            {!!Form::label("Popular Brands title")!!}
                            {!!Form::text('popular_brands_title', null, array('class' => 'form-control', 'placeholder' => 'Popular Brands title'))!!}
                            <em class="error-msg">{!!$errors->first('popular_brands_title')!!}</em>
                        </div>
                        <div class="form-group {{ $errors->has('popular_brands_title_color') ? 'has-error' : '' }}">
                            {!!Form::label("Popular brand title color")!!}
                             <div class="" style="background-color: {{$singleData->popular_brands_title_color}}; width: 25px; height: 10px; display: inline-block;"></div>
                            {!!Form::text('popular_brands_title_color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element', 'placeholder' => 'popular brand Title Color'))!!}
                            <em class="error-msg">{!!$errors->first('popular_brands_title_color')!!}</em>
                        </div>
                    </div> 
                </div>
            </div>
            
            <div class="box box-primary"><div class="box-header with-border"><h3 class="box-title">Footer Titles</h3></div></div>
            <div class="row">
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('first_footer_column') ? 'has-error' : '' }}">
                            {!!Form::label("1st footer column")!!}
                            {!!Form::text('first_footer_column', null, array('class' => 'form-control', 'placeholder' => '1st footer column Title'))!!}
                            <em class="error-msg">{!!$errors->first('first_footer_column')!!}</em>
                        </div>
                    </div> 
                </div>
                
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('second_footer_column') ? 'has-error' : '' }}">
                            {!!Form::label("2nd footer column")!!}
                            {!!Form::text('second_footer_column', null, array('class' => 'form-control', 'placeholder' => '2nd footer column title'))!!}
                            <em class="error-msg">{!!$errors->first('second_footer_column')!!}</em>
                        </div>
                    </div> 
                </div>
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('third_footer_column') ? 'has-error' : '' }}">
                            {!!Form::label("3rd footer column")!!}
                            {!!Form::text('third_footer_column', null, array('class' => 'form-control', 'placeholder' => '3rd footer column title'))!!}
                            <em class="error-msg">{!!$errors->first('third_footer_column')!!}</em>
                        </div>
                    </div> 
                </div>
                
                <div class="col-md-3">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('fourth_footer_column') ? 'has-error' : '' }}">
                            {!!Form::label("4th footer column")!!}
                            {!!Form::text('fourth_footer_column', null, array('class' => 'form-control', 'placeholder' => '4th footer column title'))!!}
                            <em class="error-msg">{!!$errors->first('fourth_footer_column')!!}</em>
                        </div>
                    </div> 
                </div>
            </div>
            

          <div class="clearfix"></div>
            
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