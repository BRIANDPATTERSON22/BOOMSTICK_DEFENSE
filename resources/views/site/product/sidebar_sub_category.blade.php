<div class="col-sm-3 collection-filter category-side category-page-side">
    {!!Form::open(['autocomplete'=>'off', 'name' => 'category_filter_form', 'method' => 'get', 'id' => 'id_category_filter_form'])!!}

    <input type="hidden" name="products_per_page" value="{{ request()->products_per_page }}">
    <input type="hidden" name="sort_by" value="{{ request()->sort_by }}">
    
    <!-- side-bar colleps block stat -->
    {{-- <div class="collection-filter-block creative-card creative-inner mb-0">
        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
        <div class="collection-collapse-block @if(request()->types) open @endif">
            <h3 class="collapse-block-title mt-0">Caliber</h3>
            <div class="collection-collapse-block-content" @if(request()->types) style="display: block;" @else style="display: none;" @endif>
                <div class="collection-brand-filter">
                    @foreach ($rsrCalibersBySubCategory as $row)
                      <div class="custom-control custom-checkbox collection-filter-checkbox">
                          <input type="checkbox" class="custom-control-input" id="{{ $row->caliber }}" name="calibers[]" value="{{ $row->caliber }}" @if(request()->calibers && in_array($row->caliber, request()->calibers)) checked @endif>
                          <label class="custom-control-label" for="{{ $row->caliber }}">{{ $row->caliber }}</label>
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="collection-collapse-block @if(request()->types) open @endif">
            <h3 class="collapse-block-title">Barrel Length</h3>
            <div class="collection-collapse-block-content" @if(request()->types) style="display: block;" @else style="display: none;" @endif>
                <div class="collection-brand-filter">
                    @foreach ($rsrProductAttributeBarrelLength as $row)
                      <div class="custom-control custom-checkbox collection-filter-checkbox">
                          <input type="checkbox" class="custom-control-input" id="{{ $row->barrel_length }}" name="barrel_lengths[]" value="{{ $row->barrel_length }}" @if(request()->barrel_lengths && in_array($row->barrel_length, request()->barrel_lengths)) checked @endif>
                          <label class="custom-control-label" for="{{ $row->barrel_length }}">{{ $row->barrel_length }}</label>
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}

    
    @if(count(request()->all()) > 0)
        <div class="collection-filter-block creative-card creative-inner mb-0 pt-3 pb-3">
           <h4> <a class="text-uppercase text-danger" href="{{ url()->current() }}"><i class="fa fa-times" aria-hidden="true"></i> Clear all Filter </a></h4>
        </div>
    @endif

    <div class="collection-filter-block creative-card creative-inner mb-0">
        <div class="collection-collapse-block open">
            <h3 class="collapse-block-title mt-0">Availability</h3>
            <div class="collection-collapse-block-content">
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
        <div class="collection-collapse-block open">
            <h3 class="collapse-block-title mt-0">price range({{ $option->currency_symbol }})</h3>
            <div class="collection-collapse-block-content">
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

    @if($rsrCalibersBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                <div class="collection-collapse-block @if(request()->calibers) open @endif">
                    <h3 class="collapse-block-title mt-0">Caliber</h3>
                    <div class="collection-collapse-block-content" @if(request()->calibers) style="display: block;" @else style="display: none;" @endif>
                        <div class="collection-brand-filter">
                            @foreach ($rsrCalibersBySubCategory as $row)
                              <div class="custom-control custom-checkbox collection-filter-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="{{ $row->caliber }}" name="calibers[]" value="{{ $row->caliber }}" @if(request()->calibers && in_array($row->caliber, request()->calibers)) checked @endif>
                                  <label class="custom-control-label" for="{{ $row->caliber }}">{{ $row->caliber }}</label>
                              </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    @endif

    @if($rsrBarrelLengthsBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->barrel_lengths) open @endif">
                <h3 class="collapse-block-title mt-0">Barrel Length</h3>
                <div class="collection-collapse-block-content" @if(request()->barrel_lengths) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrBarrelLengthsBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->barrel_length }}" name="barrel_lengths[]" value="{{ $row->barrel_length }}" @if(request()->barrel_lengths && in_array($row->barrel_length, request()->barrel_lengths)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->barrel_length }}">{{ $row->barrel_length }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrActionsBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->actions) open @endif">
                <h3 class="collapse-block-title mt-0">Action</h3>
                <div class="collection-collapse-block-content" @if(request()->actions) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrActionsBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->action }}" name="actions[]" value="{{ $row->action }}" @if(request()->actions && in_array($row->action, request()->actions)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->action }}">{{ $row->action }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrColorsBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->colors) open @endif">
                <h3 class="collapse-block-title mt-0">Color</h3>
                <div class="collection-collapse-block-content" @if(request()->colors) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrColorsBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->color }}" name="colors[]" value="{{ $row->color }}" @if(request()->colors && in_array($row->color, request()->colors)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->color }}">{{ $row->color }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrManufacturerBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->manufacturers) open @endif">
                <h3 class="collapse-block-title mt-0">Manufacturers</h3>
                <div class="collection-collapse-block-content" @if(request()->manufacturers) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrManufacturerBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->manufacturer_id }}" name="manufacturers[]" value="{{ $row->manufacturer_id }}" @if(request()->manufacturers && in_array($row->manufacturer_id, request()->manufacturers)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->manufacturer_id }}">{{ $row->manufacturer_id }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrfinishesBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->finishes) open @endif">
                <h3 class="collapse-block-title mt-0">Finish</h3>
                <div class="collection-collapse-block-content" @if(request()->finishes) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrfinishesBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->finish }}" name="finishes[]" value="{{ $row->finish }}" @if(request()->finishes && in_array($row->finish, request()->finishes)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->finish }}">{{ $row->finish }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrGripsBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->grips) open @endif">
                <h3 class="collapse-block-title mt-0">Grips</h3>
                <div class="collection-collapse-block-content" @if(request()->grips) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrGripsBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->grips }}" name="grips[]" value="{{ $row->grips }}" @if(request()->grips && in_array($row->grips, request()->grips)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->grips }}">{{ $row->grips }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrHandsBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->hands) open @endif">
                <h3 class="collapse-block-title mt-0">Hand</h3>
                <div class="collection-collapse-block-content" @if(request()->hands) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrHandsBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->hand }}" name="hands[]" value="{{ $row->hand }}" @if(request()->hands && in_array($row->hand, request()->hands)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->hand }}">{{ $row->hand }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrTypesBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->types) open @endif">
                <h3 class="collapse-block-title mt-0">Type</h3>
                <div class="collection-collapse-block-content" @if(request()->types) style="display: block;" @else @if(request()->types) style="display: block;" @else style="display: none;" @endif @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrTypesBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->type }}" name="types[]" value="{{ $row->type }}" @if(request()->types && in_array($row->type, request()->types)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->type }}">{{ $row->type }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rsrWtCharacteristicsBySubCategory->isNotEmpty())
        <div class="collection-filter-block creative-card creative-inner mb-0 filter-box filterbox-overflow">
            <div class="collection-collapse-block @if(request()->wt_characteristics) open @endif">
                <h3 class="collapse-block-title mt-0">wt characteristics</h3>
                <div class="collection-collapse-block-content" @if(request()->wt_characteristics) style="display: block;" @else style="display: none;" @endif>
                    <div class="collection-brand-filter">
                        @foreach ($rsrWtCharacteristicsBySubCategory as $row)
                          <div class="custom-control custom-checkbox collection-filter-checkbox">
                              <input type="checkbox" class="custom-control-input" id="{{ $row->wt_characteristics }}" name="wt_characteristics[]" value="{{ $row->wt_characteristics }}" @if(request()->wt_characteristics && in_array($row->wt_characteristics, request()->wt_characteristics)) checked @endif>
                              <label class="custom-control-label" for="{{ $row->wt_characteristics }}">{{ $row->wt_characteristics }}</label>
                          </div>
                        @endforeach
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