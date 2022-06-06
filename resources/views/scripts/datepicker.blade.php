<script>
    // jQuery

    $(function() {
        // ============================================================== 
        // date-time picker
        // ============================================================== 
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            onClose: true,
            time: false,
            cancelText: 'Batal',
        });
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY HH:mm',
            onClose: true,
            time: true,
            date: true,
            cancelText: 'Batal',
        });
        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false,
            cancelText: 'Batal',
        });
    })
</script>