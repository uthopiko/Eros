<?
namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * Encuentra todas las empresa con las preferencias del usuario indicado
     *
     * @param string $userid El id del usuario
     */
    public function findEmpresasByPreferencias($userid)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('SELECT cli FROM ErosFrontendBundle:Article art,ErosFrontendBundle:Empresas cli,ErosFrontendBundle:Product pro WHERE art.empresa=cli AND art.producto=pro AND pro.sidsubcategoria IN(SELECT p.pidSubCategoria FROM ErosFrontendBundle:User u JOIN u.sidSubCategoria p WHERE u.id =:user_id)');
        $consulta->setParameter('user_id',$userid);
        return $consulta->getResult();
    }
	
	/**
     * Encuentra todas las preferencias del usuario
     *
     * @param string $usuario El id del usuario
     */
    public function findPreferenciasByUser($userid)
    {
        $em = $this->getEntityManager();
        
		$consulta_preferencias = $em->createQuery("SELECT p.pidsubcategoria FROM ErosFrontendBundle:User u JOIN u.sidSubCategoria p WHERE u.id =:user_id");
        $consulta_preferencias->setParameter('user_id',$userid);
               
        return $consulta->getResult();
    }
}