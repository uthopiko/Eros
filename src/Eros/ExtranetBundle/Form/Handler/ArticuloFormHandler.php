<?php
namespace Eros\ExtranetBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Eros\ExtranetBundle\Form\Model\Promocion;
use Doctrine\ORM\EntityManager;
use Eros\FrontendBundle\Entity\CliPromociones;
use Eros\FrontendBundle\Entity\Empresas;

class ArticuloFormHandler
{
    protected $request;
    protected $form;

    public function __construct(Form $form, Request $request)
    {
        $this->form = $form;
        $this->request = $request;
    }

    public function process(EntityManager $em)
    {
        $this->form->setData(new CliPromociones());
        if ('POST' === $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            if ($this->form->isValid()) {   
                $promocion = $this->form->getData();     
                $promocion->SetEmpresa($this->empresa_user);
                $em->persist($promocion);
                $em->flush();
                return $promocion;
            }
        }
        return false;
    }

    public function editprocess(CliPromociones $promocion,EntityManager $em)
    {
        $this->form->setData($promocion);
        //$this->form->setData('Nombre','Asier');
        //\Doctrine\Common\Util\Debug::dump($this->form);
        if ('POST' === $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            if ($this->form->isValid()) {   
                $promocion = $this->form->getData();     
                $em->persist($promocion);
                $em->flush();
                return $promocion;
            }
        }
        return false;
    }
}
