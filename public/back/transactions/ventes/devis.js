const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$(function() {
    function toNumber(val) {
        return parseFloat(val) || 0;
    }

    function recalculerRestant() {
        var total_def_val = toNumber($("#total_def_val").val());
        var encaissement = toNumber($("#encaissement").val());
        var restant = total_def_val - encaissement;
        $("#restant").val(restant.toFixed(2));
        $("#restant").css("color", restant < 0 ? "red" : "black");
    }

    /* Gestion des remises */
    $("#remise").keyup(function() {
        var sous_total = toNumber($("#sous_total").val());
        var remise = toNumber($("#remise").val());

        if (remise < 0) {
            Swal.fire('Attention !','La remise ne doit pas être négative','error');
            remise = 0;
        }
        if (remise > 100) {
            Swal.fire('Attention !','La remise ne peut pas dépasser 100%','warning');
            remise = 100;
        }

        var total_def = sous_total - (sous_total * remise / 100);
        $("#total_def").html(total_def.toFixed(2));
        $("#total_def_val").val(total_def.toFixed(2));

        recalculerRestant();

    });

    /* Fin gestion des remises */
});