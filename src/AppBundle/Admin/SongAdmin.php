<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SongAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('playlist', null, [
            "required" => true
        ]);
        $formMapper->add('url', 'text', [
            "required" => true,
            "label" => "Youtube video url"
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('playlist');
        $datagridMapper->add('title');
        $datagridMapper->add('url');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('playlist');
        $listMapper->addIdentifier('title');
        $listMapper->addIdentifier('url');
    }
}