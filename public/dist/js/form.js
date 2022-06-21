// jQuery

$(function() {

    // ============================================================== 
    // auto complete tanggal
    // ============================================================== 
    $('#study_date').change(function () {
        var input = $(this).val()

        $('input[name="study_date"]').val(input)
    })
    // ============================================================== 
    // guru/siswa selected
    // ============================================================== 
    $('.role_present').change(function () {
        var check = $('option:selected', this).val()

        if (check == 'student') {
            $('#teacher').prop('disabled', true)
            $('#student').prop('disabled', false)
        } else {
            $('#teacher').prop('disabled', false)
            $('#student').prop('disabled', true)
        }
    })
    // ============================================================== 
    // guardian setting switch
    // ============================================================== 
    $('#sw_guardian:checkbox').click(function () {
        var input = $(this).closest('form').find(':input[id="guardian"]')
        
        if ($(this).prop('checked')) {
            input.prop('disabled', false)
        } else {
            input.prop('disabled', true)
        }
    })
    // ============================================================== 
    // auto currency
    // ============================================================== 
    // formatCurrency($('input[data-type="currency"]'))
    $('input[data-type="currency"]').on({
        load: function (){
            formatCurrency($(this))
        },
        keyup: function () {
            formatCurrency($(this))
        },
        blur: function () {
            formatCurrency($(this), "blur")
        }
    })
    function formatNumber(n) {
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }

    function formatCurrency(input, blur) {
        var input_val = input.val()
        
        if (input_val === "") { return }
        
        var original_len = input_val.length
        var car_pos = input.prop("selectionStart")

        if (input_val.indexOf(",") >= 0) {
            var decimal_pos = input_val.indexOf(",")
            var left_side = input_val.substring(0, decimal_pos)
            var right_side = input_val.substring(decimal_pos)

            left_side = formatNumber(left_side)
            right_side = formatNumber(right_side)

            if (blur === "blur") {
                right_side += "00"
            }

            right_side = right_side.substring(0, 2)
            input_val = "Rp " + left_side + "," + right_side
        } else {
            input_val = formatNumber(input_val)
            input_val = "Rp " + input_val

            if (blur === "blur") {
                input_val += ",00"
            }
        }

        input.val(input_val)

        var updated_len = input_val.length
        car_pos = updated_len - original_len + car_pos
        input[0].setSelectionRange(car_pos, car_pos)
    }
    // ============================================================== 
    // button disabled/enabled
    // ============================================================== 
    $('#btn_edit').click(function () {
        $(this).hide()
        $('#btn_cancel').show()
        $('#btn_save').show()
        $('input').not('#guardian').prop('disabled', false)
        $('select').not('#guardian').prop('disabled', false)
        $('textarea').not('#guardian').prop('disabled', false)
    })
    $('#btn_cancel').click(function () {
        $(this).hide()
        $('#btn_save').hide()
        $('#btn_edit').show()
        $('input').not('#guardian').prop('disabled', true)
        $('select').not('#guardian').prop('disabled', true)
        $('textarea').not('#guardian').prop('disabled', true)
    })
});