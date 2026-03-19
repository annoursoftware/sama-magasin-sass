let isSubmitting = false;

$('#vente').submit(function (e) {
    e.preventDefault();
    
    $('#savebtn').html(' En cours...');

    /* const $submitButton = $(this).find('button[type="submit"]');
    $submitButton.prop('disabled', true).text('Submitting...'); */
    if (isSubmitting) {
        return; // Prevent multiple submissions
    }
    isSubmitting = true;

    /* var url = $(this).attr("action"); */
    let formData = new FormData(this);

    url = "{{ url('api/ventes') }}";

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: (response) => {
            $('#savebtn').html('Enregistrement');
            $('#vente')[0].reset();
            var url = window.location.origin+'/admin/transactions/ventes/';
            window.open(url, '_self');

            Toast.fire({
                icon: 'success',
                title: 'Vente enregistrée avec succès !'
            });
        },
        error: function (response) {
            $('#vente').find(".print-error-msg").find("ul").html('');
            $('#vente').find(".print-error-msg").css('display', 'block');
            $.each(response.responseJSON.errors, function (key, value) {
                $('#vente').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        },
        complete: function() {
            isSubmitting = false; // Reset the flag
        }
    });
});
