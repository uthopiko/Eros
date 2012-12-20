<?php
/**
 * <b>Name :  Util.php</b><br>
 * <b>Desc :  This file contains the general functions for app</b><br>
 *
 * PHP version 5.3
 *
 * @category  Eros
 * @package   Util
 * @author    Asier Ramos <asier@asier-ramos.com>
 * @copyright 2012 www.asier-ramos.com
 * @license   GPL (http://www.asier-ramos.com)
 * @version   SVN:<7:2fa7f9fccdc1>
 * @link      http://localhost
 * @since     File available since Release 0.1
 */


/**
 * Class that stores all information to manage a Asset on memory.
 * It should be a real bean structure.
 *
 * @category   Eros
 * @package	Util
 * @subpackage Util
 * @author	 Asier Ramos <asier@asier-ramos.com>
 * @copyright  2012 www.asier-ramos.com
 * @license	GPL (http://www.asier-ramos.com)
 * @version	Release: <package_version>
 * @link	   http://www.filmquity.com
 * @since      Class available since Release 0.1
 */
namespace Eros\FrontendBundle\Util;

use Symfony\Component\Form\Util\PropertyPath;

class Util
{
	private $security;
	private $em;

	public function __construct($security,$em)
	{
		$this->security = $security;
		$this->em = $em;
	}

	/**
	* Function to get distance between two points
	*
	* @param string $origen  Origin point
	* @param string $destino Destination point
	*
	* @return int Value in km
	*/
	public function getDistancia($origen, $destino)
	{
		$urlPanoramio = "http://maps.googleapis.com/maps/api/directions/json?origin=".$origen."&destination=".$destino."&sensor=false";

		$contenidoUrl = $this->leerContenidoCompleto($urlPanoramio);
	
		$JSON = json_decode($contenidoUrl);
	
		return $JSON->routes[0]->legs[0]->distance->value;
	}
	
	/**
	* Function to read maps api URL
	*
	* @param string $url Url to read
	*
	* @return JSON Json with response of API
	*/
	function leerContenidoCompleto($url)
	{
		$ficheroUrl = fopen($url, "r");
		$texto = "";
		while ($trozo = fgets($ficheroUrl, 1024)) {
			$texto .= $trozo;
		}
		return $texto;
		}

	/**
	* Function to get price under tarifa
	*
	* @param string $price    Original price
	* @param string $discount Destination point
	*
	* @return int Value in km
	*/
	function getPrecio($price, $discount)
	{
		$devol = $price - ($price * ($discount->getDescuento()/100));	   

		return $devol;
	}

	/**
	* Function to transform object in array
	*
	* @param object $objects object to transform
	*
	* @return array Value in km
	*/
	function objectToArray($objects)
	{
		$arrParams = array();
		foreach ($objects as $param) {
			$arrParams[$param['pidarticulo']] = $param['value'];
		}
		return $arrParams;
	}

	/**
	* Function to transform entity in array
	*
	* @param object $entity object to transform
	*
	* @return array Value
	*/
	function entityToArray($entity)
	{
		$reflectedClass = new \ReflectionClass($entity);
		$objectProperties = $reflectedClass->getProperties();
		//\Doctrine\Common\Util\Debug::dump($objectProperties);
		$datas = array();
		foreach ($objectProperties as $objectProperty) {
		    $property = $objectProperty->getName();
		   
		    $path = new PropertyPath($property);
		  	$array[$property] = $path->getValue($entity);
		}
		return $array;
	}

	/**
	* Function to take the biggest value in multidimensional array
	*
	* @param array  $array array
	* @param string $key   key
	*
	* @return string Value
	*/
	function getArrayMaxValue($array, $key, $value, $keyValue)
	{
		$maxValue = 0;
		foreach ($array as $arr) {
			$maxValue = $maxValue < $arr[$value] && $arr[$key] == $keyValue  ? $arr[$value] : $maxValue;
		}
		return $maxValue;
	}

	/**
	*
	*
	*
	*
	*/
	function getUserId()
	{
		if ($this->security->isGranted('ROLE_USER')) {
			$user = $this->security->getToken()->getUser();
			return $user->getId();
		}
		else
			return false;
	}

	/**
	*
	*
	*
	*
	*/
	function getEmpresaId()
	{
		if ($this->security->isGranted('ROLE_USER')) {
			$user = $this->security->getToken()->getUser();
			$userid = $user->GetId();
        	$empresa_user = $this->em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
			return $empresa_user->getId();
		}
		else
			return false;
	}
}