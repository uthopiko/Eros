<?
# src/Cupon/OfertaBundle/Twig/Extension/CuponExtension.php
namespace Eros\FrontendBundle\Twig\Extension;

class ErosFrontendExtension extends \Twig_Extension
{
		public function getFilters()
		{
			return array('cuenta_atras' => new \Twig_Filter_Method($this, 'cuentaAtras',array('is_safe' => array('html'))),);
		}
		
		 public function getFunctions()
		{
			return array(
				'descuento' => new \Twig_Function_Method($this, 'descuento'),
				'ResizeImage' => new \Twig_Function_Method($this, 'ResizeImage'),
				'EsCliente' => new \Twig_Function_Method($this, 'EsCliente')
			);
		}
		
		
    /**
     * Calcula el porcentaje que supone el descuento indicado en euros.
     * El precio no es el precio original sino el precio de venta (también en euros)
     *
     * @param string $precio Precio de venta del producto (en euros)
     * @param string $descuento Descuento sobre el precio original (en euros)
     * @param string $decimales Número de decimales que muestra el descuento
     */
    public function descuento($pidArticulo,$precio_articulo, $pidEmpresa, $decimales = 0)
    {
		/*$em = $this->get('doctrine.orm.entity_manager');
        $empresas = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->findPromocionByClienteAndArticulo($pidArticulo,$pidEmpresa); 
        */
                
        /*if ($descuento == 0 || $descuento == null) {
            return '0%';
        }
        
        $precio_original = $precio + $descuento;
        $porcentaje = ($descuento / $precio_original) * 100;
        */
        return '350';
    }


    /**
     * Mira si la empresa esta contenido en el string serializado
     *
     * @param string $strClientes Clientes del user
     * @param string $PidEmpresa Descuento sobre el precio original (en euros)
     */
    public function ResizeImage($src,$width,$height)
    {
		$targ_w = $targ_h = 250;
		$jpeg_quality = 90;

		$src = '/var/www/Eros/web/uploads/productos/demo.jpg';
		$tam =getimagesize($src);
		$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

		imagecopyresampled($dst_r,$img_r,0,0,0,0,
		$targ_w,$targ_h,$tam[0],$tam[1]);

		header('Content-type: image/jpeg');
		return imagejpeg($dst_r,null,$jpeg_quality);

    }

    /**
     * Mira si la empresa esta contenido en el string serializado
     *
     * @param string $strClientes Clientes del user
     * @param string $PidEmpresa Descuento sobre el precio original (en euros)
     */
    public function EsCliente($strClientes,$PidEmpresa)
    {
		$part = explode(',',$strClientes);
		if(in_array($PidEmpresa,$part)){
			return false;
		}else{
			return true;
		}
    }
		
	public function cuentaAtras($fecha)
	{
		//echo $fecha;
		//$fecha = $fecha->format('Y,').($fecha->format('m')-1).$fecha->format(',d,H,i,s');
		$html = "<script type=\"text/javascript\">
				function muestraCuentaAtras(){
				var horas, minutos, segundos;
				var ahora = new Date();
				var fechaExpiracion = new Date($fecha);
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
				document.getElementById('tiempo').innerHTML = '<strong>Faltan:</strong> ' +
				cuentaAtras;
				}
				muestraCuentaAtras();
			</script>";
		return $html;
	}
	
	public function getName()
	{
			return 'erosfrontend';
	}
}
