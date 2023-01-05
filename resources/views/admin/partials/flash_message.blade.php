@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(count($errors) > 0)
    <div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.</div>
@endif