<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SuggestionAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('category')
            ->add('approved')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('category')
            ->add('name')
            ->add('surname')
            ->add('organization')
            ->add('email')
            ->add('text')
            ->add('created')
            ->add('approved', null, array('editable' => true))
            ->add('ip')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('category')
            ->add('name')
            ->add('surname')
            ->add('organization')
            ->add('email')
            ->add('text')
            ->add('created')
            ->add('approved', null, array('label' => 'Approved'))
            ->add('ip')
            ->add('fingerprint')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('category')
            ->add('name')
            ->add('surname')
            ->add('organization')
            ->add('email')
            ->add('text')
            ->add('created')
            ->add('approved')
            ->add('ip')
            ->add('fingerprint')
        ;
    }

    public function getExportFields() {
    return array('category','name','surname',
        'organization','email', 'text', 'created'
        );
}
}
