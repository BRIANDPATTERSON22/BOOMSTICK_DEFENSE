<!-- REQUIRED JS SCRIPTS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type='text/javascript'></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('admin/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/js/app.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/pace/pace.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('admin/js/myFunctions.js') }}" type="text/javascript"></script>

<!-- DataTables -->
<script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#dataTable,#dataTablePrice').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": false,
            "bAutoWidth": false,
            "scrollX": true,
             "pageLength": 25
        });

        $('#dataTableProducts').dataTable({
            "bPaginate": false,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": false,
            "bAutoWidth": false,
            "scrollX": true,
            "iDisplayLength": 50,
            "searching": false
        });

        $('#dataTableCategories').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": false,
            "bAutoWidth": false,
            "scrollX": true,
            "pageLength": 50
        });
    });
</script>

<!-- Select2 -->
<script src="{{asset('/plugins/select2/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
  })
</script>

<!-- iCheck -->
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
</script>

<!--Date Picker-->
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script>
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<!--Time Picker-->
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script>
    $(".timepicker").timepicker({
        showInputs: false
    });
</script>

<!--Validation with password confirming-->
<script>
    function passConfirming() {
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2").value;
        if (pass1 != pass2) {
            //alert("Passwords Do not match");
            document.getElementById("pass1").style.borderColor = "red";
            document.getElementById("pass2").style.borderColor = "red";
        }
        else {
            document.getElementById("pass1").style.borderColor = "green";
            document.getElementById("pass2").style.borderColor = "green";
        }
    }
</script>

<!-- CK Editor -->
<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script>
    $(function () {
        CKEDITOR.replace("page",
            {
                height: 355,
                // toolbarCanCollapse:true
            });
        CKEDITOR.replace("page1",
            {
                height: 355
            });
    });
</script>

<!--Change table row order-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
    //Helper function to keep table row from collapsing when being sorted
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index)
        {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    //Make diagnosis table sortable
    $(".innovay-sortable-order tbody").sortable({
        helper: fixHelperModified,
        stop: function(event,ui) {renumber_table(".innovay-sortable-order")

            var idsInOrder = [];
            $(".innovay-sortable-order tr").each(function() { idsInOrder.push($(this).attr('id')) });

            var APP_URL = {!! json_encode(url('/')) !!};

            var idx = APP_URL+'/admin/sortable-order';
            var id_array=[];
            id_array =idsInOrder;

            var data="table_name="+$('#table_name').val()+"&order_id="+JSON.stringify(id_array);
            $.ajax({
                type:'GET', url:idx, data:data,
                success:function(data){
                    //alert(data)
                }
            })
        }

    }).disableSelection();

    function renumber_table(tableID) {
        $(tableID + " tr").each(function() {
            count = $(this).parent().children().index($(this)) + 1;
            $(this).find('.priority').html(count);
        });
    }

</script>

<!-- Color Picker -->
<script src="{{asset('/plugins/colorpicker/bootstrap-colorpicker.min.js')}}" type="text/javascript"></script>
<script>
   $(function () {
     //Colorpicker
     $('.my-colorpicker1').colorpicker()
     //color picker with addon
     $('.my-colorpicker2').colorpicker()
   })
</script>

<script src="{{asset('site/plugins/bootstrap-input-spinner-master/src/bootstrap-input-spinner.js')}}"></script>

{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

{{-- <script src="{{ asset('admin/js/sweetalert.min.js') }}" type="text/javascript"></script>
<style>
    .swal-footer {
      text-align: center !important;
    }
</style>
<script>
    @if(Session::has('success'))
        swal({
          title: "Good job!",
          text: "You clicked the button!",
          icon: "success",
          button: "Aww yiss!",
        });
    @endif
</script> --}}

@yield('page-script')