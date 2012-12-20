<?
namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProPromocionArticuloRepository extends EntityRepository
{
 
    /**
     * Borrar elementos
     *
     * @param string $userid El id del usuario
     */
    public function Delete($pidArticulo,$pidPromocion)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('DELETE ErosFrontendBundle:ProPromocionArticulo pa WHERE pa.sidarticulo = :pidarticulo AND pa.sidpromocion = :pidpromocion');
        $consulta->setParameter('pidpromocion',$pidPromocion);
        $consulta->setParameter('pidarticulo',$pidArticulo);
        return $consulta->execute();
    }
    
    /**
     * Sacar si hay una promocion para este articulo
     *
     * @param string $userid El id del usuario
     */
    public function findPromocionByEmpresaAndArticulo($pidArticulo,$pidempresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT pa FROM ErosFrontendBundle:ProPromocionArticulo pa JOIN pa.sidpromocion p WHERE pa.sidarticulo = :pidarticulo AND p.empresa = :PidEmpresa');
        $consulta->setParameter('PidEmpresa',$pidempresa);
        $consulta->setParameter('pidarticulo',$pidArticulo);
        return $consulta->getResult();
    }
}
