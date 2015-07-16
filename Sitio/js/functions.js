
    var page; // Pagina php que se encarga de hacer la consulta
	var content; // Div donde se cargan los datos retornados de la consulta
	var load; // Div para mostrar un gif de carga
	var impresosDiv; // Div que almacena la cantidad de registros impresos
	var posicionDiv; // Div que almacena la posicion de registros que han sido impresos
	var cantidad; // Variable para almacenar la cantidad de registros que se van a imprimir en cada consulta
	var posicion; // Variable que almacena la cantidad de registros impresos
	var modificar = false; // Variable para mostrar un boton para modificar
	var eliminar = false; // Variable para mostrar un boton para eliminar

$(document).ready(function() {
    $.validarFormSimple();
    $.cargarDatosDeListas();

    $("#myTab a").click(function(e) {
        e.preventDefault();
        $(this).tab('show')
    });

    $("input:radio[name=rdbBebida]").click(function(){
        var bebida = $('input:radio[name=rdbBebida]:checked').val();

        if (bebida == "GAS")
        {
            $("#cantidad").removeAttr("disabled");
        }else {
            $("#cantidad").attr("disabled", "disabled");
            $("#cantidad").val("");
        }
    });
});

$.cargarDatosDeListas = function(){
    page = $("#page").text();
    content = $("#listar");
    load = $(".cargando");
}
