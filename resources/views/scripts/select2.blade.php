<script>
    // jQuery

    $(function() {
        // ============================================================== 
        // select2
        // ============================================================== 
        $('select').not('.disabled').formSelect();

        $('.auto_fill').change(function (){
            var id = $('option:selected', this).val()

            $.ajax({
                url: '/api/spp/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response != null) {
                        $('#year').val(response.data.payment.year)
                        $('#amount').val('Rp '+formatNumber(response.data.payment.amount))
                    }
                }
            })
        })

        $('.modal_auto_fill').change(function (){
            var id = $('option:selected', this).val()

            $.ajax({
                url: '/api/spp/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response != null) {
                        $('#mod_year').val(response.data.payment.year)
                        $('#mod_amount').val('Rp '+formatNumber(response.data.payment.amount))
                    }
                }
            })
        })

        function formatNumber(nStr) {
            nStr += '';
            x = nStr.split(',');
            x1 = x[0];
            x2 = x.length > 1 ? ',' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
    })
</script>