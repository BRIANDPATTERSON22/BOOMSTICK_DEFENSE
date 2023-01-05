<div class="col-sm-3 collection-filter category-side category-page-side mb-5">
    {!!Form::open(['url'=> 'products', 'autocomplete'=>'off', 'name' => 'filter_form', 'method' => 'get', 'id' => 'id_category_filter_form'])!!}

    <input type="hidden" name="products_per_page" value="{{ request()->products_per_page }}">
    <input type="hidden" name="sort_by" value="{{ request()->sort_by }}">

    @if(count(request()->all()) > 0)
        <div class="collection-filter-block creative-card creative-inner mb-0 pt-3 pb-3">
           <h4> <a class="text-uppercase text-danger" href="{{ url()->current() }}"><i class="fa fa-times" aria-hidden="true"></i> Clear all Filter </a></h4>
        </div>
    @endif

    <div class="collection-filter-block creative-card creative-inner mb-0">
        <div class="collection-collapse-block @if(request()->stock_availability) open @endif">
            <h3 class="collapse-block-title mt-0">Availability</h3>
            <div class="collection-collapse-block-content" @if(request()->calibers) style="display: block;" @else style="display: none;" @endif>
                <div class="collection-brand-filter">
                    <div class="custom-control custom-checkbox collection-filter-checkbox">
                        <input type="checkbox" class="custom-control-input" id="stock_availability_id" name="stock_availability" value="1" @if(request()->stock_availability == 1) checked @endif onchange="$('#id_category_filter_form').submit();">
                        <label class="custom-control-label" for="stock_availability_id">Exclude out of stock</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="collection-filter-block creative-card creative-inner mb-0">
        <div class="collection-collapse-block @if(request()->from_price || request()->to_price) open @endif">
            <h3 class="collapse-block-title mt-0">price range({{ $option->currency_symbol }})</h3>
            <div class="collection-collapse-block-content" @if(request()->from_price || request()->to_price) style="display: block;" @else style="display: none;" @endif>
                <div class="collection-brand-filter">
                    <div class="input-group mt-3">
                        <input type="text" class="form-control" id="inlineFormInputGroupUsername1" placeholder="From" name="from_price" value="{{ request()->from_price }}">
                        {{-- <div class="input-group-prepend">
                          <div class="input-group-text">to</div>
                        </div> --}}
                        <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="To" name="to_price" value="{{ request()->to_price }}">
                      </div>
                </div>
            </div>
        </div>
    </div>

    @if($rsrCategoriesComposerData->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                <div class="collection-collapse-block @if(request()->category_ids) open @endif">
                    <h3 class="collapse-block-title mt-0">Categories</h3>
                    <div class="collection-collapse-block-content" @if(request()->category_ids) style="display: block;" @else style="display: none;" @endif>
                        <div class="collection-brand-filter">
                            @foreach ($rsrCategoriesComposerData as $row)
                              <div class="custom-control custom-checkbox collection-filter-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="{{ $row->id }}" name="category_ids[]" value="{{ $row->department_id }}" @if(request()->category_ids && in_array($row->department_id, request()->category_ids)) checked @endif>
                                  <label class="custom-control-label" for="{{ $row->id }}">{{ $row->category_name }}</label>
                              </div>
                            @endforeach

                            {{-- <button type="submit" class="btn btn-normal bg-info btn-block">Search</button> --}}
                        </div>
                    </div>
                </div>
        </div>
    @endif

    
    {{-- <div class="mt-3">
        <button type="submit" class="btn btn-normal bg-info btn-block mb-5">Search</button>
    </div> --}}

    {{-- {!!csrf_field()!!} --}}
    {!! Form::close() !!}
</div>