
!function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {
        
    //Basic
    $('#sa-basic').click(function(){
        swal("Here's a message!");
    });

    //A title with a text under
    $('#sa-title').click(function(){
        swal("Here's a message!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.")
    });

    //Success Message
    $('#sa-success').click(function(){
        swal("Good job!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.", "success")
    });

    // Hapus Tidak Jadi 
    $('.sa-warning').click(function(){
        var form = $(this).closest('form')
        e.preventDefault()

        swal({   
            title: "Apakah Anda yakin?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yakin",   
            closeOnConfirm: false 
        }, function(){   
            swal(
                'Terhapus!',
                'Data berhasil dihapus.',
                'success',
            ).then(function() {
                form.submit()
            })
        });
    });

    // Hapus Data
    $('.sa-delete').click(function(e){
        var form = $(this).closest('form')
        e.preventDefault()

        swal({   
            title: "Apakah Anda Yakin?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yakin",   
            cancelButtonText: "Batal",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                form.submit()
            } else {     
                swal("Dibatalkan", "", "error");   
            } 
        });
    });

    //Custom Image
    $('#sa-image').click(function(){
        swal({   
            title: "Govinda!",   
            text: "Recently joined twitter",   
            imageUrl: "../../assets/images/users/1.jpg" 
        });
    });

    //Auto Close Timer
    $('#sa-close').click(function(){
         swal({   
            title: "Auto close alert!",   
            text: "I will close in 2 seconds.",   
            timer: 2000,   
            showConfirmButton: false 
        });
    });


    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.SweetAlert.init()
}(window.jQuery);