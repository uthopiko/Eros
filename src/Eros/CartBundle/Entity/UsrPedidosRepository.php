<?
namespace Eros\CartBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsrPedidosRepository extends EntityRepository
{
	/**
     * Cuenta todos los pedidos que tiene un usuario
     *
     * @param string $userid El id del usuario
     */
    public function CountItemsByUser($userid)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT COUNT(u.id) FROM ErosCartBundle:UsrPedidos u WHERE u.user =:userid');
        $consulta->setParameter('userid',$userid);
        $count = $consulta->getSingleScalarResult();
        return $count;
    }

    /**
     * Sumar precios de los pedidos
     *
     * @param string $userid El id del usuario
     */
    public function SumarPrecioByUser($userid)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT SUM(u.precio * u.numeroarticulos) FROM ErosCartBundle:UsrPedidos u WHERE u.user =:userid');
        $consulta->setParameter('userid',$userid);
        $sum = $consulta->getSingleScalarResult();
        return $sum;
    }


    /**
     * Cuenta todos los pedidos activos que tiene la empresa en todos los usuarios
     *
     * @param string $userid El id del usuario
     */
    public function CountPedidosByEmpresaEstado($pidestado,$pidempresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT COUNT(u.id) FROM ErosCartBundle:UsrPedidos u WHERE u.articulo IN (SELECT art.pidarticulo FROM ErosFrontendBundle:Article art WHERE art.empresa =:empresa) AND u.sidestadopedido =:pidestado');
        $consulta->setParameter('empresa',$pidempresa);
        $consulta->setParameter('pidestado',$pidestado);
        $count = $consulta->getSingleScalarResult();
        return $count;
    }


    /**
     * Cuenta todos los pedidos pagados que tiene la empresa en todos los usuarios
     *
     * @param string $userid El id del usuario
     */
   /* public function CountPedidosByEmpresaEstadoPagados($pidempresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT COUNT(u.id) FROM ErosCartBundle:UsrPedidos u WHERE u.articulo IN (SELECT art.pidarticulo FROM ErosFrontendBundle:Article art WHERE art.empresa =:empresa) AND u.sidestadopedido =3');
        $consulta->setParameter('empresa',$pidempresa);
        $count = $consulta->getSingleScalarResult();
        return $count;
    }*/

    /**
     * Muestralos pedidos de cada empresa.
     *
     * @param int $empresaid El id de la empresa
     */
    public function SelectPedidosByEmpresa($empresaid)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery(
            'SELECT u FROM ErosCartBundle:UsrPedidos u 
            WHERE u.articulo IN 
            (SELECT art.pidarticulo FROM ErosFrontendBundle:Article art 
            WHERE art.empresa =:empresaid)');
        $consulta->setParameter('empresaid',$empresaid);
        $count = $consulta->getResult();
        return $count;
    }
}