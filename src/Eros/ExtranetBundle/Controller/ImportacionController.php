<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ImportacionController extends Controller
{
     /**
     * @Route("/import",name="_import_data")
     * @Template()
     */
    public function importAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createFormBuilder()
        ->add('csv', 'file')
        ->getForm();

        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            $data = $form->getData();
            $fichero = uniqid().".".$data['csv']->GuessExtension();
            $data['csv']->move('/tmp/',$fichero);
            $fcontents = file ("/tmp/".$fichero);
            $trozos = explode(',',trim($fcontents[0]));
            $entity_new = $trozos[0];
            $entity = new \Eros\FrontendBundle\Entity\Article();
            $line1 = trim($fcontents[1]);
            $methods = explode(',', $line1);
            for($i=2; $i<sizeof($fcontents); $i++){
                $trozos = explode(',',$fcontents[$i]);
                $cont = 0;
                foreach ($methods as $met) {
                    if($met == "Empresa"){
                        $empresa = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findBynombrecomercial($trozos[$cont]);
                        $entity->{'set'.ucfirst($met)}($empresa[0]);
                    }else if($met == "Producto"){
                        $producto = $em->getRepository('Eros\FrontendBundle\Entity\Product')->findBynombre(trim($trozos[$cont]));
                        $entity->{'set'.ucfirst($met)}($producto[0]);
                    }else{
                        $entity->{'set'.ucfirst($met)}($trozos[$cont]);
                    }
                    $cont++;
                }
                $entity->setOrden(1500);
                $entity->setPormayor(true);
                $entity->setPormenor(true);
                $em->persist($entity);
            }
            $em->flush();         
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/import/categories",name="_import_data")
     */
    public function importCategoriesAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createFormBuilder()
        ->add('csv', 'file')
        ->getForm();

        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            $data = $form->getData();
            $fichero = uniqid().".".$data['csv']->GuessExtension();
            $data['csv']->move('/tmp/',$fichero);
            $fcontents = file ("/tmp/".$fichero);
            $trozos = explode(';',trim($fcontents[0]));
            $encabezado = $trozos;
            for($i=1; $i<sizeof($fcontents); $i++){
            	$categoria = new \Eros\FrontendBundle\Entity\Category();
            	$subcategoria = new \Eros\FrontendBundle\Entity\SubCategory();
            	$producto = new \Eros\FrontendBundle\Entity\Product();
                $trozos = explode(';',$fcontents[$i]);
                $cont = 0;
                echo trim($encabezado[0],'"'); 
                if(trim($encabezado[0],'"') == "categoria"){
                    $c = $em->getRepository('Eros\FrontendBundle\Entity\Category')->findByCategoria(trim($trozos[0],'"'));
                    if(!$c){
                    	echo "Crear Categoria =>";
                    	$categoria->setCategoria(trim($trozos[0],'"'));
                    	$em->persist($categoria);
                    }
                    else {
                    	$categoria =  $c[0];
                    }
                }
                if(trim($encabezado[1],'"') == "subcategoria"){
                    $sc = $em->getRepository('Eros\FrontendBundle\Entity\SubCategory')->findBySubcategoria(trim($trozos[1],'"'));
                    if(!$sc){
                    	echo "Crear SubCategoria =>";
                    	$subcategoria->setSubcategoria(trim($trozos[1],'"'));
                    	$subcategoria->setCategoria($categoria);
                    	$em->persist($subcategoria);

                    }
                    else {
                    	$subcategoria =  $sc[0];
                    }
                }
                echo "Crear Producto =>";
          		$producto->setNombre(trim($trozos[2],'"'));
          		$producto->setSubCategoria($subcategoria);
          		$producto->setDescripcion('Descripcion');
          		$producto->setRutaImagen('/var');
          		$em->persist($producto);
          		$em->flush(); 
                

                echo $producto->getNombre()."<br />";
 
                /*$entity->setOrden(1500);
                $entity->setPormayor(true);
                $entity->setPormenor(true);
                $em->persist($entity);*/
            }
            $em->flush();         
        }

        return $this->render('ErosExtranetBundle:Importacion:import.html.twig',array('form'=>$form->createView()));
    }
}

?>
