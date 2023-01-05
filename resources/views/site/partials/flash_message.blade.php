    @if(session('success'))
        <div class="alert alert-success flash_msg_bg" style="border-radius: 0px;">
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> --}}
                {{-- <span aria-hidden="true">&times;</span></button> --}}
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger flash_msg_bg" style="border-radius: 0px;">
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> --}}
                {{-- <span aria-hidden="true">&times;</span></button> --}}
            {{ session('error') }} </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger flash_msg_bg"  style="border-radius: 0px;">
            {{-- <strong>Whoops!</strong> --}}
            {{-- There were some problems with your input. Please Fill required* input fields! --}}
            <strong> Please fill in all required(*) fields. </strong>
        </div>
    @endif

{{--     @if(count($errors)>0)
        <div class="alert alert-danger flash_msg_bg" style="border-radius: 0px;">
            @foreach ($errors->all() as $error)
                <strong>[ {{ $error }} ]</strong>
            @endforeach
        </div>
    @endif --}}

    @if(session('info'))
        <div class="alert alert-info flash_msg_bg" style="border-radius: 0px;">
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> --}}
                {{-- <span aria-hidden="true">&times;</span></button> --}}
            {{ session('info') }} </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning flash_msg_bg" style="border-radius: 0px;">
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> --}}
                {{-- <span aria-hidden="true">&times;</span></button> --}}
            {{ session('warning') }} </div>
    @endif