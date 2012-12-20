<?
namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmpresasRepository extends EntityRepository
{
	/**
     * Encuentra todas las empresa con las preferencias del usuario indicado
     *
     * @param string $userid El id del usuario
     */
    public function findEmpresasWithPromociones()
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT cli FROM ErosFrontendBundle:Empresas cli WHERE cli.pidempresa IN(SELECT cli2.pidempresa FROM ErosFrontendBundle:CliPromociones pro JOIN pro.empresa cli2)');

        return $consulta->getResult();
    }

    /**
     * Borrar cliente de una empresa
     *
     * @param int $PidUsuario El id del usuario
     * @param int $PidEmpresa El id de la empresa
     */
    public function Delete($PidUsuario,$PidEmpresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('DELETE ErosFrontendBundle:ProPromocionArticulo pa WHERE pa.sidarticulo = :pidarticulo AND pa.sidpromocion = :pidpromocion');
        $consulta->setParameter('pidpromocion',$pidPromocion);
        $consulta->setParameter('pidarticulo',$pidArticulo);
        return $consulta->execute();
    }

    /**
     * Saca los clientes de una empresa dada
     *
     * @param int $PidEmpresa El id de la empresa
     */
    public function findUsersClientes($PidEmpresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT u FROM ErosFrontendBundle:User u JOIN u.empresas emp WHERE emp.id = :pidempresa');
        $consulta->setParameter('pidempresa',$PidEmpresa);
        return $consulta->getResult();
    }

    /**
     * Saca la empresa de un usuario
     *
     * @param int $PidUsuario El id de la empresa
     */
    public function findEmpresaByUser($PidUsuario)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT emp FROM ErosFrontendBundle:Empresas emp JOIN emp.usuario u WHERE u.id = :pidusuario');
        $consulta->setParameter('pidusuario',$PidUsuario);
        return $consulta->getOneOrNullResult(); 
    }
}