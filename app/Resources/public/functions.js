function muestraCuentaAtras(fecha,div){
					var horas, minutos, segundos;
					var ahora = new Date();
					var fechaExpiracion = new Date(fecha);
					var falta = Math.floor( (fechaExpiracion.getTime() - ahora.getTime()) /
					1000 );
					if (falta < 0) {
					cuentaAtras = '-';
					}
					else {
					horas = Math.floor(falta/3600);
					falta = falta % 3600;
					minutos = Math.floor(falta/60);
					falta = falta % 60;
					segundos = Math.floor(falta);
					cuentaAtras = (horas < 10 ? '0' + horas : horas) + 'h '
					+ (minutos < 10 ? '0' + minutos : minutos) + 'm '
					+ (segundos < 10 ? '0' + segundos : segundos) + 's ';
					setTimeout('muestraCuentaAtras()', 1000);
					}
					document.getElementById(div).innerHTML = '<strong>Faltan:</strong> ' +
					cuentaAtras;
}