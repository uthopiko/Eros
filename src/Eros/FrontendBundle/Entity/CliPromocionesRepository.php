<?
namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CliPromocionesRepository extends EntityRepository
{
	/**
     * Encuentra todas las Promociones para esta empresa o articulo
     *
     * @param string $userid El id del usuario
     */
    public function findPromocionesByEmpresa($PidEmpresa,$PidArticulo)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT pro.descuento FROM ErosFrontendBundle:CliPromociones pro WHERE pro.sidempresa = :pidempresa AND pro.estado = (SELECT est.pidestado FROM ErosBackendBundle:MstEstadosPromocion est WHERE est.codigo = "ACT") AND pro.tipopromocion = 1');
        $consulta->SetParameter('pidarticulo',$PidArticulo);
        return $consulta->getSingleScalarResult();
    }
}