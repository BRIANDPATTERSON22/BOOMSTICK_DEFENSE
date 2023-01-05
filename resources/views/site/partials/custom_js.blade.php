<script src="{{asset('plugins/toastr-master/build/toastr.min.js')}}"></script>
<script>
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}", ' ', {
            // timeOut: 0,
            // "closeButton": true,
            "progressBar": true,
            "newestOnTop": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            // "extendedTimeOut": "5000",
            // "extendedTimeOut": "0",
            // "positionClass": "toast-top-center",
        });
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}", ' ', {
            // timeOut: 0,
            // "closeButton": true,
            "progressBar": true,
            "newestOnTop": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            // "extendedTimeOut": "5000",
            // "positionClass": "toast-top-center",
        });
    @endif

    @if (count($errors) > 0)
        toastr.error("There were some problems with your input. Please,Enter all required(*) input fields!", 'Required fields missing!', {
            // timeOut: 0,
            // "closeButton": true,
            "progressBar": true,
            "newestOnTop": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            // "extendedTimeOut": "5000",
            // "positionClass": "toast-top-center",
        });
    @endif
</script>

<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<script src="{{asset('/plugins/select2/select2.full.min.js')}}"></script>
<script>
  $(function () {
    $('.select2').select2();
  })
</script>


<script>
    jQuery(".search-bar-input").keyup(function () {
        $(".search-box-container").css("display", "block");
        let name = $(".search-bar-input").val();
        if (name.length > 0) {
            $.get({
                url: '{{url('/')}}/searched-products',
                dataType: 'json',
                data: {
                    q: name
                },
                beforeSend: function () {
                    // $('.loader-wrapper').show();
                    // $(".loader-wrapper").css("display", "block");
                },
                success: function (data) {
                    $('.search-result-box').empty().html(data.result)
                },
                complete: function () {
                    // $('.loader-wrapper').hide();
                    // $(".loader-wrapper").css("display", "none");
                },
            });
        } else {
            $('.search-result-box').empty();
        }
    });
</script>

@yield('page-script')