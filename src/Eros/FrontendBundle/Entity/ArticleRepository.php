<?
namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function findDiscountByArticle($empresa){
        $em = $this->getEntityManager();

        $proquery = $em->createQuery(
            'SELECT param.value,art.pidarticulo,emp.id as empresa FROM ErosFrontendBundle:ProPromoArticuloParametros param
             JOIN param.sidarticulopromocion ppa1
             JOIN ppa1.sidarticulo art
             JOIN art.empresa emp
             WHERE param.sidarticulopromocion IN 
             (SELECT ppa.id FROM ErosFrontendBundle:ProPromocionArticulo ppa 
             JOIN ppa.sidpromocion pro 
             WHERE pro.empresa IN (:empresa) AND pro.estadopromocion = 2)');
        $proquery->setParameter('empresa',$empresa);
        return $proquery->getResult();       
    }

    public function findDiscountByPromocion($empresa){
        $em = $this->getEntityManager();

        $proquery = $em->createQuery(
            'SELECT pro.descuento,emp.id as empresa
             FROM ErosFrontendBundle:CliPromociones pro 
             JOIN pro.empresa emp
             WHERE pro.empresa IN (:empresa) AND pro.estadopromocion = 2  ORDER BY pro.descuento DESC'); 
        $proquery->setParameter('empresa',$empresa);
        return $proquery->getResult();
    }

    public function findArticlesByEmpresa($empresa){
        $em = $this->getEntityManager();

        $query = $em->createQuery(
        		'SELECT 
        		art.pidarticulo,
        		art.nombre,
        		art.imagen,
        		art.precio,
        		emp.id as empresaid,
        		emp.nombrecomercial as nombreempresa,
        		0 as precio_descuento,
        		(SELECT ppa.value FROM ErosFrontendBundle:ProPromoArticuloParametros ppa 
                                                      JOIN ppa.sidarticulopromocion ap 
                                                      JOIN ap.sidarticulo art2 
                                                      WHERE art2.pidarticulo = art.pidarticulo) as descuento,
         		ud.unidadmedida as unidadmedida
        		FROM ErosFrontendBundle:Article art 
        		JOIN art.empresa emp 
        		LEFT JOIN art.unidadmedida ud 
        		WHERE art.empresa = :PidEmpresa ORDER BY art.orden');
        $query->setParameter('PidEmpresa',$empresa); 

        return $query->getResult();
    }

    //TODO: Quitar esta funcion ya que se repite con findArticlesByEmpresa
    //      Revisar donde se utiliza
    /**
     * Encuentra los articulos de cada empresa 
     *
     * @param int $empresa El id de la empresa
     */
    public function findArticulosByEmpresa($empresa)
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT art FROM ErosFrontendBundle:Article art WHERE art.empresa = :PidEmpresa ORDER BY art.orden');
        $query->setParameter('PidEmpresa',$empresa);
        return $query->getResult();
    }
    
    /**
     * Encuentra todas las empresa con las preferencias del usuario indicado
     *
     * @param string $userid El id del usuario
     */
    public function findArticulosByEmpresaAndSubCategoria($empresa,$SubCategoria)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT art FROM ErosFrontendBundle:Article art WHERE art.producto IN(SELECT pro.id FROM ErosFrontendBundle:Product pro WHERE pro.subcategoria = :SubCategoria)');
        $query->setParameter('SubCategoria',$SubCategoria);
        return $query->getResult();
    }

    /**
     * Encuentra todos los articulos con el pattern especificado
     *
     * @param string $pattern Es el patron de busqueda que buscara tanto por categoria,marca, articulo
     */
    public function findArticulosByPattern($pattern, $field, $provincia)
    {
        //TODO:Mirar que hacemos con la Marca!!
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT  
                                    art.pidarticulo,
                                    art.nombre,
                                    art.precio,
                                    art.imagen,
                                    emp.id as empresaid,
                                    emp.nombrecomercial as nombreempresa,
                                    unidad.unidadmedida as unidadmedida,
                                    0 as precio_descuento,
                                    (SELECT ppa.value FROM ErosFrontendBundle:ProPromoArticuloParametros ppa 
                                                      JOIN ppa.sidarticulopromocion ap 
                                                      JOIN ap.sidarticulo art2 
                                                      WHERE art2.pidarticulo = art.pidarticulo) as descuento
                                    FROM ErosFrontendBundle:Article art 
                                    JOIN art.empresa emp 
                                    JOIN art.producto pro 
                                    JOIN pro.subcategoria subcat 
                                    JOIN subcat.categoria cat
                                    JOIN emp.usuario user
                                    JOIN user.userdata ud 
                                    LEFT JOIN art.unidadmedida unidad 
                                   	WHERE (:field = :field AND CONCAT(art.nombre,CONCAT(pro.nombre,CONCAT(subcat.subcategoria,cat.categoria))) LIKE :datos)
                                   	OR (:field = 'Product' AND pro.nombre LIKE :datos)
                                   	OR (:field = 'Category' AND cat.categoria LIKE :datos)
                                   	OR (:field = 'SubCategory' AND subcat.subcategoria LIKE :datos)"
                                  );
        
        $query->setParameter('datos', '%'.$pattern.'%');
       /* $query->setParameter('provincia',$provincia);*/
        $query->setParameter('field',$field);

        return $query->getResult();
    }
    
    /**
     * Update de orden articulos(Mas tarde intentare update pasando campos y valores)
     *
     * @param string $userid El id del usuario
     */
    public function updateOrden($pidArticulo,$orden)
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('UPDATE ErosFrontendBundle:Article art SET art.orden = :orden WHERE art.pidarticulo = :pidarticulo');
        $query->setParameter('orden',$orden);
        $query->setParameter('pidarticulo',$pidArticulo);
        return $query->execute();
    }

     /**
     * Buscar Productos y devolverlo como array
     *
     */
    public function findAllAsArray($sidx,$sord,$limitstart,$limitend,$pattern,$empresa)
    {
        $em = $this->getEntityManager();
       
        $qb = $em->createQueryBuilder();
        $qb->add('select', 'a.pidarticulo,a.nombre,a.precio,emp.nombrecomercial')
        ->add('from', 'ErosFrontendBundle:Article a')
        ->join('a.producto','pro')
        ->join('pro.subcategoria','subcat')
        ->join('subcat.categoria','cat')
        ->join('a.empresa','emp')
        ->add('where','a.pormayor = 1 AND a.empresa != :empresa AND CONCAT(a.nombre,CONCAT(pro.nombre,CONCAT(subcat.subcategoria,cat.categoria))) LIKE :datos')
        ->setParameter('datos', '%'.$pattern.'%')
        ->setParameter('empresa', $empresa);
        //->add('where','CONCAT(a.nombre,CONCAT(pro.nombre,CONCAT(mar.marca,CONCAT(subcat.subcategoria,cat.categoria)))) LIKE "lech"');
        $qb->addOrderBy($sidx,$sord);
        $query = $qb->GetQuery();

        return $query->getArrayResult();
    }

    /**
    * Buscar descuentos de una empresa
    *
    *
    */
   /* public function findDiscounts($strEmpresas)
    {
        $discount = $this->findDiscountByArticle($strEmpresas);
        $discountPromocion = $this->findDiscountByPromocion($strEmpresas);
        $arrParams = array();
        foreach ($discount as $param) {
            $arrParams[$param['pidarticulo']]['descuento'] = $param['value'] > $this->getArrayMaxValue($discountPromocion,'empresa','descuento',$param['empresa']) ?
            									$param['value'] :
            									$this->getArrayMaxValue($discountPromocion,'empresa','descuento',$param['empresa']);

        }
        $arrParams['general'] = $this->getArrayMaxValue($discountPromocion,'empresa','descuento',$param['empresa'])
        var_dump($arrParams);
    }*/

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
}
