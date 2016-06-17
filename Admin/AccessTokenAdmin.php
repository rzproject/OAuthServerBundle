<?php

namespace Rz\OAuthServerBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use OAuth2\OAuth2;

use Sonata\AdminBundle\Route\RouteCollection;

class AccessTokenAdmin extends Admin
{
	protected $parentAssociationMapping = 'user';

	/**
	 * @inherit
	 */
	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->clearExcept(array('list', 'export'));
	}


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('client')
            ->add('token')
            ->add('expiresAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('client', null, array('associated_property' => 'name'))
            ->add('token',  null,array('footable'=>array('attr'=>array('data-breakpoints'=>array('xs', 'sm')))))
            ->add('scope',  null,array('footable'=>array('attr'=>array('data-breakpoints'=>array('xs', 'sm')))))
            ->add('expiresAt', 'string', array('footable'=>array('attr'=>array('data-breakpoints'=>array('all'))), 'template' => 'RzOAuthServerBundle:AccessTokenAdmin:list_expires_at.html.twig'))
            ->add('createdAt', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
        ;
    }
}
