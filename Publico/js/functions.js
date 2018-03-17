$(document).ready(function() {
    if (flash !== false) {
        flash = $.parseJSON(flash)
        switch (flash.type) {
            case 'info':
                toastr.info(flash.content, flash.title)
                break;
            case 'warning':
                toastr.warning(flash.content, flash.title)
                break;
            case 'error':
                toastr.error(flash.content, flash.title)
                break;
        }
    }

    $('.Question').click(function() {
        var Texto = $(this).data('question')
        var Url = $(this).attr('href')
        $.alertable.confirm(Texto, {
            cancelButton: '<button class="Button Danger" type="button">Cancelar</button>',
            okButton: '<button class="Button" type="button">Aceptar</button>'
        }).then(function(Url) {
            console.log(Url)
            location.href = Url
        })
        return false;
    })


})
