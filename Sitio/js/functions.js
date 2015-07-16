$(document).ready(function() {
    $.validarFormSimple();
    $.cargarDatosDeListas();

    $("#myTab a").click(function(e) {
        e.preventDefault();
        $(this).tab('show')
    });
} );
