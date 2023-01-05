@extends('admin.layouts.app')

@section('htmlheader_title')
    Service not available
@endsection

@section('contentheader_title')
    Service not available
@endsection

@section('$contentheader_description')
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">503</li>
    </ol>
@endsection

@section('main-content')
    <div class="error-page">
        <h2 class="headline text-red">503</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! Service not available</h3>
            <p>
                We could not find the service you were looking for. Meanwhile, you may return to <a href='{{ url('admin/dashboard') }}'>dashboard</a> or try using the search form.
            </p>
            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="{{ trans('adminlte_lang::message.search') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div><!-- /.input-group -->
            </form>
        </div>
    </div><!-- /.error-page -->
@endsection