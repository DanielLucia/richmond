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
})
