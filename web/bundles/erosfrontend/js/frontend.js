$(document).ready(function() {
    $("#subcategorias_menu").css("display","none");

    function dialog(empresa,action,mensaje){
        $.fx.speeds._default = 2000;
        $("#dialog").dialog({
                resizable: false,
                height:140,
                modal: true,
                show: "highlight",
                hide: "highlight",
                buttons: {
                    Aceptar: function() {
                        var iddialog = $(this);
                        $.post(Routing.generate(action,{'PidEmpresa' : empresa}),function(respuesta){
                                $("#dialog").html(mensaje);
                                var id = ".cliente" + empresa + "_add_link";
                                var id2 = ".cliente" + empresa + "_delete_link";
                                if(action == '_add_empresa_cliente'){
                                    $(id).css("display","none");
                                    $(id2).css("display","block");
                                }else{
                                    $(id).css("display","block");
                                    $(id2).css("display","none");
                                }
                                $(".ui-dialog-buttonset").css("display","none");
                                iddialog.dialog("close");
                            });
                    },
                    Cancelar: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
    }


    $(".modal-popup_add").live("click",function() {
                $("#dialog").html("<p>¿Quieres hacerte cliente de la empresa?</p>");
                dialog($(this).data("cliente"),'_add_empresa_cliente','<p>Te has hecho cliente de esta empresa.</p>');
                return false;
            });

    $(".modal-popup_delete").live("click",function() {
                 $("#dialog").html("<p>¿Deseas dejar de ser cliente de esta tienda?</p>");
                dialog($(this).data("cliente"),'_delete_empresa_cliente','<p>Has dejado de ser cliente de esta empresa.</p>');
                return false;
            });

    $("#btnPedido").click(function(){
        var NumeroElementos = $("#txtNumeroElementos").val();
        var Articulo = $("#txtNumeroElementos").data("id");
        var Precio = $("#txtNumeroElementos").data("precio");

         $.post(Routing.generate('_ajax_add2_pedido',{'NumeroElementos' : NumeroElementos, 'Articulo' : Articulo,'Precio' : Precio}),function(respuesta){
            $.modal.close();
            $("#nElementos").text(respuesta.items);
            $("#sumPrecio").text(respuesta.precio);
        });
        return false;
    });
}