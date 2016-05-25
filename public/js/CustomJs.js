/**
* Created by 7PPZ on 17/05/2016.
*/

$(function() {
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var actions = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text(actions)
        modal.find('.modal-body input').val(actions)
    })
    //EVENT ON CLICK/AFTER CLICK ..etc
    $('#dropD').on('hidden.bs.dropdown', function () {
        alert("Assalamualaikum")
    })
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('#myButton').on('click', function () {
        var $btn = $(this).button('loading')
        // business logic...

        $btn.button('reset')
    })
})
