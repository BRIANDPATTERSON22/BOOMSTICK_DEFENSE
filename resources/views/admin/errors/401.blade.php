@extends('admin.layouts.app')

@section('htmlheader_title')
    Unauthorized page
@endsection

@section('contentheader_title')
    Unauthorized page
@endsection

@section('contentheader_description')
    Your are looking for unauthorized page
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Unauthorized</li>
    </ol>
@endsection

@section('main-content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 401</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Unauthorized.</h3>
            <p>
                The user does not have the necessary permissions for the resource.
                Meanwhile, you may <a href='{{ url('admin/dashboard') }}'>return to dashboard</a> or try using the search form.
            </p>
            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search something ..."/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection