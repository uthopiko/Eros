<?
namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmpresaPedidoRepository extends EntityRepository
{
	 /**
     * Buscar Productos y devolverlo como array
     *
     */
    public function findAllAsArrayPedidos($sidx,$sord,$limitstart,$limitend,$empresa)
    {
        $em = $this->getEntityManager();
       
        //$query=$em->createQuery('SELECT p FROM ErosExtranetBundle:EmpresaPedido p JOIN p.empresa emp WHERE emp.id =:empresa ORDER BY $sidx $sord');
        $qb = $em->createQueryBuilder();
        $qb->add('select', 'p.id,ep.id as estadopedido,t.id as pidtarifa,t.descuento,a.nombre,a.precio as precioarticulo,p.numeroarticulos,e.nombrecomercial,t.tarifa,p.precio')
        ->add('from', 'ErosExtranetBundle:EmpresaPedido p')
        ->join('p.empresa','e')
        ->join('p.estadopedido','ep')
        ->leftjoin('p.tarifa','t')
        ->join('p.articulo','a')
        ->join('a.empresa','pro')
        ->add('where','pro.id =:empresa')
        ->setParameter('empresa', $empresa);
        //->add('where','CONCAT(a.nombre,CONCAT(pro.nombre,CONCAT(mar.marca,CONCAT(subcat.subcategoria,cat.categoria)))) LIKE "lech"');
        $qb->addOrderBy($sidx,$sord);
        $query = $qb->GetQuery();

        return $query->getArrayResult();
    }

     /**
     * Buscar Productos y devolverlo como array
     *
     */
    public function findAllAsArrayCompras($sidx,$sord,$limitstart,$limitend,$empresa)
    {
        $em = $this->getEntityManager();
       
        //$query=$em->createQuery('SELECT p FROM ErosExtranetBundle:EmpresaPedido p JOIN p.empresa emp WHERE emp.id =:empresa ORDER BY $sidx $sord');
        $qb = $em->createQueryBuilder();
        $qb->add('select', 'p.id,ep.id as estadopedido,t.id as pidtarifa,t.descuento,a.nombre,a.precio as precioarticulo,p.numeroarticulos,e.nombrecomercial,t.tarifa,p.precio')
        ->add('from', 'ErosExtranetBundle:EmpresaPedido p')
        ->join('p.empresa','e')
        ->join('p.estadopedido','ep')
        ->leftjoin('p.tarifa','t')
        ->join('p.articulo','a')
        ->join('a.empresa','pro')
        ->add('where','e.id =:empresa')
        ->setParameter('empresa', $empresa);
        //->add('where','CONCAT(a.nombre,CONCAT(pro.nombre,CONCAT(mar.marca,CONCAT(subcat.subcategoria,cat.categoria)))) LIKE "lech"');
        $qb->addOrderBy($sidx,$sord);
        $query = $qb->GetQuery();

        return $query->getArrayResult();
    }


    /**
     * Pone todos los historicos a Active = false
     *
     * @param PidPedido 
     */
    public function UpdateHistoricoFalse($PidPedido)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery('UPDATE ErosExtranetBundle:HistoricoPedido hp SET hp.active = 0 WHERE hp.pedido = :pidpedido');
        $consulta->setParameter('pidpedido',$PidPedido);
        return $consulta->execute();
    }


    /**
     * Cuenta todos los pedidos segun estado que tenga la empresa proveedora(de otras empresas)
     *
     * @param int $PidEstado El Pid del estado
     */
    public function CountPedidosByCodigoEstado($PidEstado,$Empresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery(
            'SELECT COUNT(ep.id) FROM ErosExtranetBundle:EmpresaPedido ep 
            WHERE ep.articulo IN 
            (SELECT art.pidarticulo FROM ErosFrontendBundle:Article art 
            WHERE art.empresa =:empresa) AND ep.estadopedido =:pidestado');
        $consulta->setParameter('empresa',$Empresa);
        $consulta->setParameter('pidestado',$PidEstado);
        $count = $consulta->getSingleScalarResult();
        return $count;
    }

     /**
     * Cuenta todos los pedidos segun estado que tenga la empresa proveedora(de otras empresas)
     *
     * @param int $PidEstado El Pid del estado
     */
    public function CountPedidosRecibidosByCodigoEstado($PidEstado,$Empresa)
    {
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery(
            'SELECT COUNT(ep.id) FROM ErosExtranetBundle:EmpresaPedido ep 
            WHERE ep.empresa =:empresa AND ep.estadopedido =:pidestado');
        $consulta->setParameter('empresa',$Empresa);
        $consulta->setParameter('pidestado',$PidEstado);
        $count = $consulta->getSingleScalarResult();
        return $count;
    }
}