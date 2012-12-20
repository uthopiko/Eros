jQuery(function($){
    //MODAL DIALOGS
    var alphaBackground=$('<div class="alphaBackground"></div>').prependTo("body"),
    close=$('[class*="modalDialog"] a[title*="cerrar"]'),
    modalDialog =$('[class*="modalDialog"]');
    var openModal = function(event){
        var target = $(event.target);
        alphaBackground.slideDown('slow');
        var modal = $(this).data('open');
        modalDialog.filter('[data-modal=' + modal +']').show('slow');
       	$("#" +modal).data('id',$(this).data('id'));
       	$("#" +modal).data('empresa',$(this).data('empresa'));
       	$("#" +modal).data('precio',$(this).data('precio'));
        event.preventDefault();
    }
    var postOrder = function(event){
        var target = $(event.target);
        var modal = "modal" + target.data('action');
       	var NumeroElementos = $("#txtNumeroElementos").val();
        var Articulo = $("#" + modal).data("id");
        var Precio = $("#" + modal).data("precio");
        $.post(Routing.generate('_ajax_add2_pedido',{'NumeroElementos' : NumeroElementos, 'Articulo' : Articulo,'Precio' : Precio}),function(respuesta){
            /*$.modal.close();
            $("#nElementos").text(respuesta.items);
            $("#sumPrecio").text(respuesta.precio);*/
            closeModal;
        });
        event.preventDefault();
    }
    var postClient = function(event){
        var target = $(event.target);
        var modal = "modal" + target.data('action');
        var empresa =  $("#" + modal).data('empresa');
       
        $.post(Routing.generate('_add_empresa_cliente',{'PidEmpresa' : empresa}),function(respuesta){
	            //$("#dialog").html(mensaje);
	            var id = ".cliente" + empresa + "_add_link";
	            var id2 = ".cliente" + empresa + "_delete_link";
	            if(action == '_add_empresa_cliente'){
	                $(id).css("display","none");
	                $(id2).css("display","block");
	            }else{
	                $(id).css("display","block");
	                $(id2).css("display","none");
	            }
            closeModal;
        });
        event.preventDefault();
    }
    var closeModal = (function(event){
        alphaBackground.slideUp('slow');
        $(this).parent(modalDialog).hide('slow');
        event.preventDefault();
    });
     $(document).bind('keydown',function(e){
        if(e.which==27){
          alphaBackground.slideUp('slow');
          modalDialog.hide('slow');  
        };
    });
    $('.banner a[title*="ver"],[data-open]').click(openModal);
    $('[data-action="Pedido"]').click(postOrder);
    $('[data-action="Cliente"]').click(postClient);
    close.click(closeModal);
    //TOGGLE MENUS
    var showMenu = function(event){
        var target = $(event.target);
        target.next('.menuSecundary').slideToggle('fast');
        event.preventDefault();
    };
    var changeText = function(event){
       var textTarget = $(event.target).text();
       var field = $(event.target).data("field");
       $('form [data-slide="listFilter"]').text(textTarget);
       $('form [data-slide="listFilter"]').attr("data-field",field);
       event.stopPropagation();
        event.preventDefault();
    };
    $('[data-slide]').click(showMenu);
     $('[data-menu="optionsSearch"]>button').click(changeText);
    //DROP DOWN MENU
    $('.dropdown').click(function(event){
            $(this).parents('.articleCollection').find('.bookmarksList').toggleClass('active');
            $('.articleCollection > figure img:not(:last-of-type)').toggleClass('borderGrey');
            event.preventDefault();
    })   
    //DYNAMIC HEIGHT TEXTAREA
    var submitButton = $('.searchForm input[type="submit"]').hide(),
    textarea = $('.searchForm textarea');
    textarea.click(function(){
        submitButton.show();
        $(this).animate({'height':'150px'},'slow');
    });
    var enviaMensaje =function(e){
       if((textarea.val().length)>0){
       textarea.animate({'height':'20px'},'slow');
       e.preventDefault();
    }
    }
    $(submitButton).click(enviaMensaje);
    //TABS ACTIVE LINK CLASS
    $('a[href*="tab"]').click(function(){
        $('a[href*="tab"]').removeClass('active');
        $(this).addClass('active');
    });
    //PASSWORD COMPARE
    var pass1=$("[name='password']"),
    pass2=$("[name='repetir_password']"),
    dataPassword=$("<samp></samp>").insertAfter(pass2);
    var compruebaPass = function(){
        var valor1=pass1.val().length,
        valor2=pass2.val().length;
        if((valor1 != valor2)){
            dataPassword.attr('data-form','Errors').text("Las contraseñas no coinciden.").css('display','block');
        }else{
            dataPassword.attr('data-form','confirmation').text("Las contraseñas coinciden.").css('display','block');
        };  
    }
    pass2.keyup(compruebaPass);

    $("#searchPattern").bind('keydown',function(e){
    	 if(e.which==13){
    	 	var query = $(this).val();
            var fieldSearch = $('[data-slide=listFilter]').attr('data-field')
	     	var url = Routing.generate('_search_article_complete',{'pattern':query,'field':fieldSearch});
	     	window.location.href = url;
	     	return false;
        };
    });

/*
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
*/
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

});

function isEmpty(obj) {
	if (typeof obj == 'undefined' || obj === null || obj === '') return true;
	if (typeof obj == 'number' && isNaN(obj)) return true;
	if (obj instanceof Date && isNaN(Number(obj))) return true;

	return false;
}