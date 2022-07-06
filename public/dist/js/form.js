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
    // function to preview image
    // ============================================================== 
    $('#photo').change(function () {
        const image = $(this)
        const imgPreview = $('.img-preview')

        imgPreview.style.display = 'block'

        const ofReader = new FileReader()
        ofReader.readAsDataURL(image.files[0])

        ofReader.onload = function (oFREvent) {
            imgPreview.src = oFREvent.target.result
        }
    })
    // ============================================================== 
    // auto calculate for score student
    // ============================================================== 
    $('.auto_calculate').on('change', function () {
        // Variabel untuk nilai tugas
        var id = $(this).attr('data-id')
        var name = $(this).attr('name')

        // Variabel untuk perhitungan
        var hitung = $('#'+name)
        let value = 0
        if (hitung.val() != '') value = parseFloat(hitung.val())
        let bagi = 1
        let kkm = $('input[name="kkm"]').val()

        // Variabel untuk Perhitungan NPA
        var pts = $('#pts'+id)
        var pas = $('#pas'+id)
        
        for (let i = 1; i < 6; i ++) {
            let total
            // Variabel untuk Nilai Tugas
            if (name.match(/t.*/)) var sum = $('#t'+i+'_'+id)
            if (name.match(/k.*/)) var sum = $('#k'+i+'_'+id)
            if (name.match(/ph.*/)) var sum = $('#ph'+i+'_'+id)
            if (name.match(/r.*/)) var sum = $('#r'+i+'_'+id)

            if (name != sum.attr('id') && sum.val() != '') {
                // Nilai Bagi
                if (value != 0) bagi++ 

                // Penjumlahan Nilai Tugas
                total = (parseFloat(value) + parseFloat(sum.val()))
                value = total
            }

        }

        if (name.match(/t.*/)) var avg_name = 'avg_t'+id
        if (name.match(/k.*/)) var avg_name = 'avg_k'+id
        if (name.match(/ph.*/)) {
            var avg_name = 'avg_ph'+id
            var n_name = name.replace('ph', 'n')

            // Variabel untuk N atau Nilai Pembelajaran Harian
            var n_det = $('#'+n_name)
            n_det.val(parseFloat(hitung.val()))
            if (n_det.val() < parseFloat(kkm)) {
                n_det.attr('style', 'color: red')
            } else {
                n_det.attr('style', 'color: black')
            }
        }
        if (name.match(/r.*/)) {
            var ph_name = name.replace('r', 'ph')
            var n_name = name.replace('r', 'n')

            // Variabel untuk N atau Nilai Pembelajaran Harian
            var ph_det = $('#'+ph_name)
            var n_det = $('#'+n_name)
            if (value > ph_det.val()) {
                if (parseFloat(value) > parseFloat(kkm)) {
                    n_det.val(kkm)
                } else {
                    n_det.val(parseFloat(hitung.val()))
                }
            } else {
                n_det.val(ph_det.val())
            }
            if (n_det.val() < parseFloat(kkm)) {
                n_det.attr('style', 'color: red')
            } else {
                n_det.attr('style', 'color: black')
            }
        }
        
        var avg = $('input[name="'+avg_name+'"]')
        
        // Perhitungan Nilai Rata-Rata
        if (name.match(/ph.*/) || name.match(/r.*/)) {

        } else {
            avg.val((value/bagi).toFixed(2))
        }

        if (avg.val() < parseFloat(kkm)) {
            avg.attr('style', 'color: red')
        } else {
            avg.attr('style', 'color: black')
        }

        // Perhitungan Nilai Akhir (NPA)
        if (pts.val() != '' && pas.val() != '') {
            var avg_ph = $('#avg_ph'+id)
            var avg_t = $('#avg_t'+id)

            if (avg_ph.val() != '' && avg_t != '') {

            }
            console.log(pts.val(), pas.val(), avg_ph.val(), avg_t.val())
        }
    })
    // ============================================================== 
    // auto calculate for npa
    // ============================================================== 
    $('.auto_npa').on('change', function () {
        // Variabel Utama
        var id = $(this).attr('data-id')
        var kkm = $('input[name="kkm"]').val()

        // Variabel untuk Perhitungan NPA
        var pts = $('#pts'+id)
        var pas = $('#pas'+id)

        // Perhitungan Nilai Akhir (NPA)
        if (pts.val() != '' && pas.val() != '') {
            var avg_ph = $('#avg_ph'+id)
            var avg_t = $('#avg_t'+id)

            if (avg_ph.val() != '' && avg_t != '') {

            }
            console.log(pts.val(), pas.val(), avg_ph.val(), avg_t.val())
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