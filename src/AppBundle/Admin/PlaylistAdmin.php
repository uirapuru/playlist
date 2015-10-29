<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class PlaylistAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
//        $listMapper->add('_action', 'actions', array(
//            'actions' => array(
//                'play' => array(
//                    'template' => 'AppBundle:CRUD:list__action_play.html.twig'
//                ),
//                'delete' => [],
//
//            )
//        ));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('play', $this->getRouterIdParameter().'/play');
    }
}