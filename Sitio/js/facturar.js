var lista_factura = [];
var total = 0;
var subtotal = 0;
var iv = 0;

$(document).ready(function(){
    $(".rdbTipoPago").click(function(){
        var tipoPago = $(this).find("input").attr("id");

        if (tipoPago == "rdbTarjeta")
        {
            $("#txtNumeroTarjeta").removeClass("hidden").find("input").focus();
        }else {
            $("#txtNumeroTarjeta").addClass("hidden");
        }
    });

    $("#papelera").droppable({
        activeClass: "ui-state-default",
        hoverClass: "ui-state-hover",
        accept: ":not(.ui-sortable-helper)",
        drop: function(event, ui) {
            if (ui.draggable.attr("role") == "ok-linea-factura")
            {
                var id = ui.draggable.attr("id");
                var object = ui.draggable.attr("object");
                var token = parseInt(ui.draggable.attr("token"));
                ui.draggable.remove();

                for (var i in lista_factura)
                {
                    if (lista_factura[i].id == id && lista_factura[i].object == object)
                    {
                        var tokenLista = 0;

                        switch (lista_factura[i].object)
                        {
                            case "pizza":
                                tokenLista = parseInt(lista_factura[i].total);
                                break;
                            case "PastaDelgada":
                            case "PastaGruesa":
                                tokenLista = parseInt(lista_factura[i].precio);
                                break;
                            case "Ingrediente":
                                tokenLista = parseInt(lista_factura[i].total);
                                break;
                            case "Natural":
                            case "Gaseosa":
                                tokenLista = parseInt(lista_factura[i].precio);
                                break;
                        }

                        if (tokenLista == token)
                        {
                            lista_factura.splice(i, 1);

                            if (lista_factura.length == 0)
                            {
                                $("#detalle-pizza ul").html("<li class=\"placeholder\"><p class=\"text-center\">Arrastre las pizzas, productos o bebidas aqui.</p></li>");
                            }
                            $.calcularTotales();

                            return;
                        }
                    }
                }
            }
        }
    });

    $(".pizza-lista li").draggable({
        appendTo: "body",
        helper: "clone",
        cursor: "move"
    });

    $(".nueva-pizza li").draggable({
        appendTo: "body",
        helper: "clone",
        cursor: "move"
    });

    $(".add-bebida li").draggable({
        appendTo: "body",
        helper: "clone",
        cursor: "move"
    });

    $("detalle-pizza ul").droppable({
        activeClass: "ui-state-default",
        hoverClass: "ui-state-hover",
        accept: ":not(.ui-sortable-helper)",
        drop: function(event, ui){
            if (ui.draggable.attr("role") == "producto") {
                var id = ui.draggable.attr("id");
	    		var object = ui.draggable.attr("object");
	    		var token = ui.draggable.attr("token");
	    		$(this).find(".placeholder").remove();
	    		$("<li role=\"ok-linea-factura\" id=\""+ id +"\" object=\""+ object +"\" token=\""+ token +"\"></li>" ).text(ui.draggable.text()).appendTo(this).
	    		addClass("ok-linea-factura").draggable({
	    			appendTo: "body",
	    			helper: "clone",
	    			cursor: "move"
	    		});

	    		var object = JSON.parse(ui.draggable.parent().find("div").text());
	    		lista_factura.push(object);
	    		$.calcularTotales();
	    		console.log(object);
            }
        }
    });

    $("#slider").slider({
        value:0,
        min:0,
        max:400,
        step:50,
        slide: function(event, ui){
            $("#amount").val(ui.value + "gr.");
        }
    });

    $("#amount").val($("#slider").slider("value") + "gr.");
});

$.calcularTotales = function(){
    subtotal = 0;
    for (i in lista_factura)
    {
        switch (lista_factura[i].object)
        {
            case "pizza":
                subtotal += parseInt(lista_factura[i].total);
                break;
            case "PastaDelgada":
            case "PastaGruesa":
                subtotal += parseInt(lista_factura[i].precio);
                break;
            case "Ingrediente":
                subtotal += parseInt(lista_factura[i].total);
                break;
            case "Natural":
            case "Gaseosa":
                subtotal += parseInt(lista_factura[i].precio);
                break;
        }
    }

    iv = subtotal * 0.13;
    total = subtotal + iv;

    $("#txtSubtotal").val($.formatoNumero(subtotal, 2, ".", ","));
    $("#txtIV").val($.formatoNumero(iv, 2, ".", ","));
    $("#txtTotal").val($.formatoNumero(total, 2, ".", ","));
}

$.formatoNumero = function(numero, decimales, separador_decimal, separador_miles){
    numero = parseFloat(numero);
    if (isNaN(numero))
    {
        return "";
    }

    if (decimales !== undefined)
    {
        numero = numero.ToFixed(decimales);
    }

    numero = numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if (separador_miles)
    {
        var miles =new RegExp("(-?[0-9]+)([0-9]{3})");
        while (miles.test(numero))
        {
            numero = numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}
