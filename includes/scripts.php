<!-- Mainly scripts -->
<script src="../public/js/jquery-3.1.1.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- iCheck -->
<script src="../public/js/plugins/iCheck/icheck.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="../public/js/inspinia.js"></script>
<script src="../public/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="../public/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Datatables -->
<script src="../public/js/plugins/dataTables/datatables.min.js"></script>

<!-- ChartJS-->
<script src="../public/js/plugins/chartJs/Chart.min.js"></script>
<!-- SweetAlert -->
<script src="../public/js/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Toastr -->
<script src="../public/js/plugins/toastr/toastr.min.js"></script>
<!-- Moment -->
<script src="../public/js/moment.min.js"></script>

<!-- Flot -->
<script src="../public/js/plugins/flot/jquery.flot.js"></script>
<script src="../public/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="../public/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="../public/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="../public/js/plugins/flot/jquery.flot.time.js"></script>

<!-- Ladda -->
<script src="../public/js/plugins/ladda/spin.min.js"></script>
<script src="../public/js/plugins/ladda/ladda.min.js"></script>
<script src="../public/js/plugins/ladda/ladda.jquery.min.js"></script>

<script>
    $(document).bind('keydown', function(e) {
        if(e.ctrlKey && (e.which == 83)) {
            e.preventDefault();
            return false;
        }
    });
    
    function toastrOptions() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>