<!-- Action session messages-->
<div class="s-message" style="z-index:9; position: relative;width: 100%">
{{--     @if(session('success'))
        <div class="alert alert-success" style="border-radius: 0px;margin-bottom: 0px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            {{ session('success') }}
        </div>
    @endif --}}

{{--     @if(session('error'))
        <div class="alert alert-danger" style="border-radius: 0px;margin-bottom: 0px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            {{ session('error') }} </div>
    @endif --}}

    {{--@if(count($errors)>0)--}}
        {{--<div class="alert alert-danger" style="border-radius: 0px;margin-bottom: 0px;"><strong>Whoops!</strong> There--}}
            {{--were some problems with your input!--}}
            {{--@foreach ($errors->all() as $error)--}}
                {{--<strong>[ {{ $error }} ]</strong>--}}
            {{--@endforeach--}}
        {{--</div>--}}
    {{--@endif--}}

   {{--  @if (count($errors) > 0)
        <div class="alert alert-danger"  style="border-radius: 0px;margin-bottom: 0px;">
            <strong>Whoops!</strong>
            There were some problems with your input. Fill required* input fields!
        </div>
    @endif --}}
</div>