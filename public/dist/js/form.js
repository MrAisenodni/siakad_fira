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
        if (name.match(/t.*/)) var n_hitung = $('#'+name.replace('t', 'n'))
        if (name.match(/k.*/)) var n_hitung = $('#'+name.replace('k', 'n'))
        if (name.match(/ph.*/)) var n_hitung = $('#'+name.replace('ph', 'n'))
        if (name.match(/r.*/)) var n_hitung = $('#'+name.replace('r', 'n'))
        let value = 0
        let n_value = 0
        if (hitung.val() != '') value = parseFloat(hitung.val())
        let bagi = 1
        let n_bagi = 1
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
            var nh_name = name.replace('ph', 'nh')

            // Variabel untuk N atau Nilai Pembelajaran Harian
            var n_det = $('#'+n_name)
            var nh_det = $('#'+nh_name)
            n_det.val(parseFloat(hitung.val()))
            nh_det.val(parseFloat(hitung.val()))
            if (n_det.val() < parseFloat(kkm)) {
                n_det.attr('style', 'color: red')
            } else {
                n_det.attr('style', 'color: black')
            }
        }
        if (name.match(/r.*/)) {
            var ph_name = name.replace('r', 'ph')
            var n_name = name.replace('r', 'n')
            var nh_name = name.replace('r', 'nh')

            // Variabel untuk N atau Nilai Pembelajaran Harian
            var ph_det = $('#'+ph_name)
            var n_det = $('#'+n_name)
            var nh_det = $('#'+nh_name)
            if (value > ph_det.val()) {
                if (parseFloat(value) > parseFloat(kkm)) {
                    if (ph_det.val() > parseFloat(kkm)) {
                        n_det.val(parseFloat(ph_det.val()))
                        nh_det.val(parseFloat(ph_det.val()))
                    } else {
                        n_det.val(kkm)
                        nh_det.val(kkm)
                    }
                } else {
                    n_det.val(parseFloat(hitung.val()))
                    nh_det.val(parseFloat(hitung.val()))
                }
            } else {
                n_det.val(ph_det.val())
                nh_det.val(ph_det.val())
            }
            if (n_det.val() < parseFloat(kkm)) {
                n_det.attr('style', 'color: red')
            } else {
                n_det.attr('style', 'color: black')
            }
        }

        if (n_hitung.val() != '') n_value = parseFloat(n_hitung.val())
        // console.log(n_hitung.val())

        // Looping untuk Perhitungan Rata-Rata PH
        for (let i = 1; i < 6; i ++) {
            let n_total
            // Variabel untuk Nilai Tugas
            var n_sum = $('#n'+i+'_'+id)

            if (n_hitung.attr('name') != n_sum.attr('id') && n_sum.val() != '') {
                // Nilai Bagi
                if (n_value != 0) n_bagi++

                // Penjumlahan Nilai Tugas
                n_total = (parseFloat(n_value) + parseFloat(n_sum.val()))
                n_value = n_total
            }
        }
        
        var avg = $('input[name="'+avg_name+'"]')
        
        // Perhitungan Nilai Rata-Rata
        if (name.match(/ph.*/) || name.match(/r.*/)) {
            avg.val((n_value/n_bagi).toFixed(2))
        } else {
            avg.val((value/bagi).toFixed(2))
        }

        if (avg.val() < parseFloat(kkm)) {
            avg.attr('style', 'color: red')
        } else {
            avg.attr('style', 'color: black')
        }

        // Perhitungan Nilai Akhir (NPA)
        var npa = $('#npa'+id)
        var npah = $('#npah'+id)
        var avg_ph = $('#avg_ph'+id)
        var avg_t = $('#avg_t'+id)
        var npa_value = 0
        if (pts.val() != '' && pas.val() != '' && avg_ph.val() != '' && avg_t.val() != '') {
            npa_value = ((parseFloat(avg_ph.val())+parseFloat(avg_t.val()))+parseFloat(pts.val())+parseFloat(pas.val()))/4
            console.log(pts.val(), pas.val(), avg_ph.val(), avg_t.val(), npa_value)
        }
        npa.val(npa_value.toFixed(2))
        npah.val(npa_value.toFixed(2))
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
        var npa = $('#npa'+id)
        var npah = $('#npah'+id)
        var avg_ph = $('#avg_ph'+id)
        var avg_t = $('#avg_t'+id)
        var npa_value = 0

        // Perhitungan Nilai Akhir (NPA)
        if (pts.val() != '' && pas.val() != '' && avg_ph.val() != '' && avg_t.val() != '') {
            npa_value = ((parseFloat(avg_ph.val())+parseFloat(avg_t.val()))+parseFloat(pts.val())+parseFloat(pas.val()))/4
            console.log(pts.val(), pas.val(), avg_ph.val(), avg_t.val(), npa_value)
        }
        npa.val(npa_value.toFixed(2))
        npah.val(npa_value.toFixed(2))
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
        $('input').not('#guardian,#nis,#nisn,#full_name,#nik').prop('disabled', false)
        $('select').not('#guardian').prop('disabled', false)
        $('textarea').not('#guardian').prop('disabled', false)
    })
    $('#btn_cancel').click(function () {
        $(this).hide()
        $('#btn_save').hide()
        $('#btn_edit').show()
        $('input').not('#guardian,#nis,#nisn,#full_name,#nik').prop('disabled', true)
        $('select').not('#guardian').prop('disabled', true)
        $('textarea').not('#guardian').prop('disabled', true)
    })
});