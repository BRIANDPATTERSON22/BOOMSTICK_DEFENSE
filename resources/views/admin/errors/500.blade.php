@extends('admin.layouts.app')

@section('htmlheader_title')
    Error found
@endsection

@section('contentheader_title')
    Error found
@endsection

@section('$contentheader_description')
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">500</li>
    </ol>
@endsection

@section('main-content')
    <div class="error-page">
        <h2 class="headline text-red">500</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! Error Found</h3>
            <p>
                Some arror found on the page/server. Meanwhile, you may return to <a href='{{ url('admin/dashboard') }}'>dashboard</a> or try using the search form.
            </p>
            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search something ..."/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div><!-- /.input-group -->
            </form>
        </div>
    </div><!-- /.error-page -->
@endsection