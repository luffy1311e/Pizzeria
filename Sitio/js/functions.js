
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

    $('#tabla').DataTable();
    $('#tablaPizza').DataTable();

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

    if ($("#modificar").text() == 1)
    {
        modificar = true;
    }
    if ($("#eliminar").text() == 1)
    {
        eliminar = true;
    }

    cantidad = 10;
    impresosDiv = $("#impresos");
    posicionDiv = $("#posicion");
    posicion = parseInt(posicionDiv.text());

    var impresos = parseInt($('table tbody tr').size());
    impresosDiv.text(impresos);
    posicionDiv.text(0);

    if (impresos < cantidad)
    {
        $(".next").addClass("disabled");
    }else {
        $(".next").removeClass("disabled");
    }

    $('#btn-siguiente').click(function(e){
        var desabled = $(this).parent().attr("class");
        var isDesabled = desabled.split(" ");
        isDesabled.shift();

        if (isDesabled[0] == "disabled")
        {
            return false;
        }

        posicion -= cantidad;
        posicionDiv.text(posicion);

        $.mostrarDatosDeListas();

        e.preventDefault();
    });

    $('#btn-anterior').click(function(e){
        var desabled = $(this).parent().attr("class");
        var isDesabled = desabled.split(" ");
        isDesabled.shift();

        if (isDesabled[0] == "disabled")
        {
            return false;
        }

        posicion -= cantidad;
        posicionDiv.text(posicion);

        $.mostrarDatosDeListas();

        e.preventDefault();
    });

    $("#txtValor").keyup(function(){
        posicion = 0;
        $mostrarDatosDeListas();
    });
}

$.mostrarDatosDeListas = function(){
    var valor = $("#txtValor").val();
    var criterio = $("#cboCriterio").val();
    var activo = $("input[name='rdbIsActivo']:checked").val();

    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: page,
        data: {valor:valor, criterio:criterio, activo:activo, posicion:posicion, modificar:modificar, eliminar:eliminar, cantidad:cantidad},
        beforeSend: function(){
            loa.html('<img src="img/site/cargando1.gif">');
        },
        success: function(data){
            load.html(' ');
            content.html(data);
            var impresos = parseInt($('table tbody tr').size());
            impresosDiv.text(impresos);
            posicionDiv.text(0);

            if (impresos < cantidad)
            {
                $(".next").addClass("disabled");
            }else {
                $(".next").removeClass("disabled");
            }
            if (posicion == 0)
            {
                $(".previous").addClass("disabled");
            }else {
                $(".previous").removeClass("disabled");
            }
        },
        Timeout:400,
        error: function(){
            alert("Se ha producido un error, intente más tarde o consulte con el administrador del sistema");
        }
    });
}

$.validarFormSimple = function(){
    $("form").submit(function(e){
        $("select option:selected").each(function(){
            var erro = $(this).val();

            if(error == -1)
            {
                console.log(error);
                $(this).parent().parent().parent().addClass("has.error");
                $(this).parent().focus();
                var alert = $(this).parent().parent().find("div");
                alert.css("display", "block");
                e.preventDefault();
            }
        });
    });
}
