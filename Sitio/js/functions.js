$(document).ready(function() {
    $.validarFormSimple();

    $('#tablaUsuarios').DataTable();
    $('#tablaPizza').DataTable();
    $('#tablaIngrediente').DataTable();
    $("#tablaBebida").DataTable();

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
