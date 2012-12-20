$(document).ready(function (){ 
   	$(".contentLink").live("click",function(event){
		if (isEmpty($(this).data("action"))) {
			var route = $(this).attr('href');
		}
	    else {
	    	var route = $(this).data("action");
	    }
		    
		$.post(route,function(respuesta){
			$("#Content").html(respuesta);
		});
		event.preventDefault();
		return false;
	});

	$("#ArticuloForm_Medidas").on("change",function(){
		$("#valoresMedidas").remove();
		var url = Routing.generate('_get_value_param',{'entity':'ErosBackendBundle:MstValoresMedidas','param':'unidadmedida','value':$(this).val()});
		$.ajax({
			url: url,
			success: function(data) {
				if(data.statusCode == 0){
					var html = '<div id="valoresMedidas">';
					html += '<label for="ArticuloForm_ValoresMedidas">Valor Medidas</label>';
					html += '<select id="ArticuloForm_ValoresMedidas" multiple="multiple" name="ValoresMedidas[]">';
				
					$.each(data.result,function(k,v){
						html += '<option value="' + v.id + '">' + v.valor + '</option>';
					});
					html += '</select>';
					html += '</div>'
					$(html).insertBefore($("#ArticuloForm_Stock").parent());
					$("select[multiple=multiple]").multiselect({
						selectedList: 2,
					});
				}
			},
			error: function(){
				alert("fail");
			}
		});
	});

	$("#ArticuloForm_categoria").change(function(){
		$("#ArticuloForm_divsubcategoria").remove();
		var url = Routing.generate('_get_value_param',{'entity':'ErosFrontendBundle:SubCategory','param':'categoria','value':$(this).val()});
		$.ajax({
			url: url,
			success: function(data) {
				var div = $(document.createElement('div'));
				var select = $(document.createElement('select'));
				var label = $(document.createElement('label'));
				div.attr({
					id: 'ArticuloForm_divsubcategoria'
				});
				label.attr({
					for: 'ArticuloForm_subcategoria',
				});
				label.text('Sub-Categoria');
				select.attr({
					id: 'ArticuloForm_subcategoria',
					name: 'ArticuloForm[subcategoria]'
				});
				$.each(data.result,function(k,v){
					select.append('<option value="' + v.id +'">' + v.subcategoria + '</option>');
				});
				div.append(label);
				div.append(select);
				div.insertBefore("input[type=submit]");
			},
			error: function() {
				alert("fail");
			}
		});
	});

	$("#ArticuloForm_subcategoria").live('change',function(){
		$("#ArticuloForm_divproducto").remove();
		var url = Routing.generate('_get_value_param',{'entity':'ErosFrontendBundle:Product','param':'subcategoria','value':$(this).val()});
		$.ajax({
			url: url,
			success: function(data) {
				var div = $(document.createElement('div'));
				var select = $(document.createElement('select'));
				var label = $(document.createElement('label'));
				div.attr({
					id: 'ArticuloForm_divproducto'
				});
				label.attr({
					for: 'ArticuloForm_sidproducto',
				});
				label.text('Producto');
				select.attr({
					id: 'ArticuloForm_sidproducto',
					name: 'ArticuloForm[sidproducto]'
				});
				$.each(data.result,function(k,v){
					select.append('<option value="' + v.id +'">' + v.nombre + '</option>');
				});
				div.append(label);
				div.append(select);
				div.insertAfter("#ArticuloForm_divsubcategoria");
			},
			error: function() {
				alert("fail");
			}
		});
	});
});

function isEmpty(obj) {
	if (typeof obj == 'undefined' || obj === null || obj === '') return true;
	if (typeof obj == 'number' && isNaN(obj)) return true;
	if (obj instanceof Date && isNaN(Number(obj))) return true;

	return false;
}


