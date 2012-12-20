	$(document).ready(function(){
			
		// set up block configuration
			$('.clicka').live('dblclick',function(){
				$.post(Routing.generate('_articulo_details',{'PidArticulo':$(this).data('itemid')}),function(data){
					$('.back').html(data.status);
					$('#ArticuloForm_Nombre').val(data.articulo.nombre);
					$('#ArticuloForm_Stock').val(data.articulo.stock);
					$('#ArticuloForm_Precio').val(data.articulo.precio);
					$('#ArticuloForm_Medidas').val(data.articulo.unidadmedida);
					$('#ArticuloForm_description').val(data.articulo.descripcion);
					$('#ArticuloForm_sidproducto').val(data.articulo.producto);
					$('#ArticuloForm_pidarticulo').val(data.articulo.pidarticulo);
					$('.block').addClass('flip');
				});
			});
			$('.edit-submit').live('click',function(e){
				$('#articulo_form').each (function(){
  					this.reset();
				});
				$('.block').removeClass('flip');
				
				// why not update that list for fun?
				$('#list-title').text($('#form_title').val());
				$('#list-items').empty();
				for (var num = 1; num <= $('#form_items').val(); num++) {
					$('#list-items').append('<li>Name '+num+'</li>');
				}
				e.preventDefault();
			});
			
		});
