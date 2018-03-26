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
        if (confirm(Texto)) {
            location.href = Url
        }
        return false;
    })

    $('.showMenuAction').click(function() {
        $('body').toggleClass('showSidebar')
    })

})
