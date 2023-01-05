@extends('admin.layouts.app')

@section('htmlheader_title')
    {{$singleData->title}} | {{ $module }}
@endsection

@section('contentheader_title')
    <span class="text-capitalize"> View {{$module}} ID: {{$singleData->id}}</span>
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li class="text-capitalize"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}"> {{$module}}(s)</a></li>
        <li class="text-capitalize active">{{$singleData->title}}</li>
    </ol>
@endsection

@section('actions')
    <li @if(Request::is('*edit')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/edit')}}"><i class="fa fa-edit"></i> <span>Edit</span></a></li>
    <li @if(Request::is('*view')) class="active" @endif><a href="{{url('admin/'.$module.'/'.$singleData->id.'/view')}}"><i class="fa fa-search-plus"></i> <span>View</span></a></li>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active @if($singleData->status==0) bg-danger @endif">
                <div class="box-header">
                    {{-- <a class="btn btn-primary pull-right" href="{{url($module.'/'.$singleData->id)}}" target="_blank"><i class="fa fa-eye"></i> Preview</a> --}}
                    {{-- <h3 class="box-title">{{$singleData->title}}</h3> --}}
                </div>
                <div class="box-body">
                  <table class="table">
                      <tr>
                          <th>First Name</th>
                          <td> <strong>{{ $singleData->first_name }}</strong> <br> </td>
                      </tr>
                      <tr>
                          <th>Last Name</th>
                          <td>{{$singleData->last_name}}</td>
                      </tr>
                      <tr>
                          <th>Email</th>
                          <td><span class="badge bg-black">{{ $singleData->email }}</span></td>
                      </tr>
                      @if ($singleData->user_id)
                        <tr>
                            <th>Account Verification</th>
                            <td>
                              
                                @if($singleData->user->status == 0)
                                    <span class="badge bg-red">Not Verified</span>
                                @else
                                    <span class="badge bg-green">Verified</span>
                                @endif
                            </td>
                        </tr>
                      @endif
                      <tr>
                          <th>Discount Percentage</th>
                          <td><span class="badge bg-blue">{{ $singleData->discount_percentage ? $singleData->discount_percentage . '%' : 'Default' }}</span></td>
                      </tr>
                      <tr>
                          <th>Phone</th>
                          <td><span class="badge bg-black">{{ $singleData->phone ?  $singleData->phone : '--'  }}</span></td>
                      </tr>

                      <tr>
                          <th>Mobile</th>
                          <td><span class="badge bg-black">{{ $singleData->mobile ? $singleData->mobile : '--'  }}</span></td>
                      </tr>
                      <tr>
                          <th>Company Name</th>
                          <td>{{ $singleData->company_name ? $singleData->company_name : '--' }}</td>
                      </tr>
                      <tr>
                          <th>Country</th>
                          <td>{{ $singleData->billing_country_id ? $singleData->billingCountry->nicename : '--' }}</td>
                      </tr>
                      <tr>
                          <th>Address</th>
                          <td> {{$singleData->address1}}</td>
                      </tr>
                      <tr>
                          <th>City</th>
                          <td>{{ $singleData->city }}</td>
                      </tr>
                      <tr>
                          <th>State</th>
                          <td>{{ $singleData->state}}</td>
                      </tr>
                      <tr>
                          <th>Postal Code</th>
                          <td>{{ $singleData->postal_code }}</td>
                      </tr>
                      
                      <tr>
                          <th> Delivery Country</th>
                          <td>{{ $singleData->delivery_country_id ? $singleData->deliveryCountry->nicename : '--' }}</td>
                      </tr>
                      <tr>
                          <th>Delivery Address</th>
                          <td> {{$singleData->address2 ? $singleData->address2 : '--'}}</td>
                      </tr>
                      <tr>
                          <th>Delivery City</th>
                          <td>{{ $singleData->delivery_city ? $singleData->delivery_city : '--' }}</td>
                      </tr>
                      <tr>
                          <th>Delivery State</th>
                          <td>{{ $singleData->delivery_state ? $singleData->delivery_state : '--'}}</td>
                      </tr>
                      <tr>
                          <th>Delivery Postal_code</th>
                          <td>{{ $singleData->delivery_postel_code ? $singleData->delivery_postel_code : '--' }}</td>
                      </tr>
                    {{--   <tr>
                          <th>Short Description</th>
                          <td>{{$singleData->short_description}}</td>
                      </tr> --}}
                      {{-- <tr>
                          <th>Content</th>
                          <td class="text-justify">{!! $singleData->content !!}</td>
                      </tr>
 --}}                      {{-- <tr>
                          <th></th>
                          <td> Offer starts at <u>{{$singleData->offer_started_at}}</u> and ends at <u>{{$singleData->offer_ended_at}}</u></td>
                      </tr> --}}
                      {{-- <tr>
                          <th>Product Purchasing/ Shopping Cart</th>
                          <td>
                              @if($singleData->is_purchase_enabled == 0)
                                  <span class="badge bg-red">Disabled</span>
                              @else
                                  <span class="badge bg-green">Enabled</span>
                              @endif
                          </td>
                      </tr> --}}
                  </table>
                </div>
                <div class="box-footer">
                    <em class="pull-right">Created on {{$singleData->created_at}} & Updated on {{$singleData->updated_at}} by {{Auth::user()->name}}</em>
                </div>
            </div>
        </div>
    </div>
@endsection