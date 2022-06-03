<script>
    // jQuery

    $(function() {
        // ============================================================== 
        // date-time picker
        // ============================================================== 
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'dd/mm/yyyy',
            onClose: true,
            lang: 'id',
        });
        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false,
        });
    })
</script>