$(function() {

	// Confirm an action before proceeding.
    var confirmAction = function(e) {
        var input = $(this);
        //cari form paling dekat dengan butang
        var form = input.closest('form');

        input.prop('disabled', 'disabled');

        swal({
          title: "Adakah anda pasti?",
          text: "Data anda akan dikemaskinikan",
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Tidak!",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, teruskan!",
          closeOnConfirm: false
        },
        function(){
          form.submit();
        });

        input.removeAttr('disabled');
    };

	// Confirm an action before proceeding.
    var confirmDestroy = function(e) {
        var input = $(this);
        //cari form paling dekat dengan butang
        var form = input.closest('form');
        //cari row paling dekat dengan butang
        var row = input.closest('tr');

        input.prop('disabled', 'disabled');

        swal({
          title: "Adakah anda pasti?",
          text: "Data ini tidak akan dapat dikembalikan!",
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Tidak!",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, hapuskan!",
          closeOnConfirm: false
        },
        function(){
          form.submit();
          row.fadeOut('slow');//hide row sementara form submit request
        });

        input.removeAttr('disabled');
    };

	var submitAjaxRequest = function(e){

		var form = $(this);
		var method = form.find('input[name="_method"]').val() || 'POST';

		$.ajax({
			url: form.prop('action'),
			type: method,
			data: form.serialize(),
			success: function(response)
			{
				swal(response.flag, response.message, response.result);
			}
		});

		e.preventDefault();

	};

	$('input[data-confirm], button[data-confirm]').on('click', confirmAction);
	$('input[data-destroy], button[data-destroy]').on('click', confirmDestroy);
	$('form[data-remote]').on('submit', submitAjaxRequest);
});
