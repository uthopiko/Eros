<?
namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TarifaRepository extends EntityRepository
{
    /**
     *  Encuentra todos los articulos que no estan en la tarifa 
     *
     * @param int $Tarifa El id de la tarifa
     */
	function findArticulosNotInTarifa($Tarifa){
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT art.pidarticulo,art.nombre FROM ErosFrontendBundle:Article art WHERE art.pidarticulo NOT IN(SELECT art2.pidarticulo FROM ErosExtranetBundle:TarifaArticulo art_tarif JOIN art_tarif.articulo art2  WHERE art_tarif.tarifa =:tarifa)');
        $consulta->setParameter('tarifa',$Tarifa);
        
        return $consulta->getArrayResult();
    }

    /**
     * Encuentra todos los articulos que estan en la tarifa 
     *
     * @param int $Tarifa El id de la tarifa
     */
    function findArticulosInTarifa($Tarifa){
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT art.pidarticulo,art.nombre FROM ErosFrontendBundle:Article art WHERE art.pidarticulo IN(SELECT art2.pidarticulo FROM ErosExtranetBundle:TarifaArticulo art_tarif JOIN art_tarif.articulo art2  WHERE art_tarif.tarifa =:tarifa)');
        $consulta->setParameter('tarifa',$Tarifa);
        
        return $consulta->getArrayResult();
    }

     /**
     * Encuentra la tarifa adecuada para los Articulos
     *
     * @param int $PidArticulo El id del articulo
     * @param int $Cantidad La cantidad del articulos
     */
    function findTarifaByArticulo($PidArticulo,$Cantidad){
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT t FROM ErosExtranetBundle:Tarifa t JOIN t.empresa emp WHERE :cantidad BETWEEN t.limitemenor AND t.limitemayor AND emp.id = (SELECT emp1.id FROM ErosFrontendBundle:Article art JOIN art.empresa emp1 WHERE art.pidarticulo =:pidarticulo)');
        $consulta->setParameter('cantidad',$Cantidad);
        $consulta->setParameter('pidarticulo',$PidArticulo);
        
        try {
            $tarifa = $consulta->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $tarifa = null;
        }

        return $tarifa;
    }
}