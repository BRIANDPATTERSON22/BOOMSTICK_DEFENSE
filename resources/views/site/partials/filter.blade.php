<style>
  select.form-control:not([size]):not([multiple]) {height: 50px;border-radius: 0px;}
  .form-control, .submit {font-family: 'Oswald', sans-serif; font-size: 16px;}
</style>
<div class="search-bar">
    {!!Form::open(['url'=>'ymd'])!!}
    <div class="row">
        {{ csrf_field() }}
        <div class="col-lg-3">
            <div class="form-group">
              <select name="year" id="year" class="form-control input-lg dynamic" data-dependent="make">
                  <option value="">Select Year...</option>
                @foreach($years as $country)
                    <option value="{{$country->year}}">{{$country->year}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
              <select name="make" id="make" class="form-control input-lg dynamic" data-dependent="model">
                <option value="">Select Make...</option>
              </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group" style="margin-bottom: 0px !important;">
              <select name="model" id="model" class="form-control input-lg">
                <option value="">Select Model...</option>
              </select>
            </div>
        </div>
        <div class="col-lg-3">
            <input class="submit" id="submit" type="submit" value="GO" class="submit btn btn-lg btn-primary">
        </div>

    </div>
    {!!Form::close()!!}
</div>