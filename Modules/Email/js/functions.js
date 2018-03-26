$(document).ready(function() {
    $( ".Draggable" ).draggable({
        revert: 'invalid',
        helper: 'clone',
        cursor: 'move'
    });
    $( ".Droppable" ).droppable({
        drop: function(ev, ui) {
            $(this).append(ui.draggable)
            console.log(ui.draggable);
        }
    });
})
