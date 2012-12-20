<?php
// src/Acme/DemoBundle/Menu/Builder.php
namespace Eros\FrontendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => '_portada'));
        $menu->addChild('Empresa');
        // ... add more children

        return $menu;
    }
}