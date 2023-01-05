@extends('admin.layouts.app')

@section('htmlheader_title')
    {{ $module }}(s)
@endsection

@section('contentheader_title')
    <span class="text-capitalize">@if(Request::is('*trash')) List of Deleted {{$module}}(s) @else List of {{$module}}(s) Created in the Year {{$year}}@endif</span>
@endsection

@section('contentheader_description')
    Manage {{ $module }}(s) of the site
@endsection

@section('breadcrumb_title')
    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @if(Request::is('*trash'))
            <li class="text-capitalize"><a href="{{url('admin/'.$module.'s')}}">{{$module}}(s)</a></li>
            <li class="text-capitalize active">Deleted {{$module}}(s)</li>
        @else
            <li class="text-capitalize active">{{$module}}(s)</li>
        @endif
    </ol>
@endsection

@section('page-style')
  <style>
    .jscroll-loading{
        text-align: center;
    }
  </style>
@endsection

@section('main-content')
    <div class="nav-tabs-custom">
        @include('admin.'.$module.'.header')
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="box-body infinite-scroll">

                    <div class="table-responsive no-padding">
                          <table id="dataTable_" class="table table-bordered">
                              <tbody>
                                  <tr>
                                      <th style="width: 10px">#</th>
                                      <th style="white-space: nowrap_;"> 
                                      STORE INFO <br>
                                      <small style="white-space: nowrap; font-weight: 500;">Division / Banner / StoreId</small>
                                        </th>
                                      @foreach ($productsData as $product)
                                          <th style="white-space: nowrap_;"><a href="{{url('admin/product/'.$product->id.'/view')}}">{{ $product->title }}</a></th>
                                      @endforeach
                                  </tr>

                                  @php $count = 0; @endphp
                                  @foreach ($storesData as $store)
                                      @php $count++; @endphp
                                      <tr>
                                            <td>{{$count}}</td>
                                            <td style="white-space: nowrap_;">
                                                <a href="{{url('admin/store/'.$store->id.'/view')}}"> {{ $store->division }}/ {{ $store->banner }}/ {{ $store->store_id }} </a>
                                            </td>
                                                @foreach ($productsData as $product)
                                                    <td class="text-center">
                                                      @php $isDataExist = $product->check_cell($product->id, $store->store_id); @endphp  
                                                            <input 
                                                                    name="status" 
                                                                    value="{{ $isDataExist ? 1 : 0 }}" 
                                                                    type="checkbox" 
                                                                    id="" 
                                                                    data-product-id="{{ $product->id }}" 
                                                                    data-store-id="{{ $store->store_id }}" 
                                                                    @if($isDataExist) checked @endif >
                                                   </td>
                                               @endforeach 
                                      </tr>
                                  @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        @if ($storesData)
                            {{ $storesData->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ajaxStart(function () {
            Pace.restart()
        })
    </script>
    <script>
        $(document).ready(function(){
          $("input:checkbox").change(function() {
            
            if ( this.checked ) {
                // document.getElementById("subscription-id").value = "1";
                this.value = "1";
                // alert( this.value );
            } else {
                // if not checked ...
                // document.getElementById("subscription-id").value = "0";
                this.value = "0";
                // aalert( this.value );lert( this.value );
            }

            // var user_id = $(this).closest('tr').attr('id');
            // var statusId = $(this).val();
            // var productId = $('#product_id').val();
            // var storeId = $('#store_id').val(); 

            var productId = $(this).attr("data-product-id");
            var storeId = $(this).attr("data-store-id");
            var statusId = $(this).val();
            console.log(productId);
            console.log(storeId);
            console.log(statusId);

            if ( this.checked ) {
                // document.getElementById("subscription-id").value = "1";
                this.value = "1";
                // alert( this.value );
            } else {
                // if not checked ...
                // document.getElementById("subscription-id").value = "0";
                this.value = "0";
                // aalert( this.value );lert( this.value );
            }

            $.ajax({
                    type:'POST',
                    url:'store-product-status',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: { "product_id" : productId, "store_id":storeId, "status" :  statusId},
                    success: function(data){
                      if(data.message){
                        // console.log(data);
                      }
                    }
                });

            });
        });
    </script>

    {{-- <script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<img src="http://demo.itsolutionstuff.com/plugin/loader.gif" alt="Loading...">',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
      });
    </script> --}}
@endsection