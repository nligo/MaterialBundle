<?php

/*
 * This file is the Media Management's admin.
 *
 * (c)  coffey  <http://www.symfonychina.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Appcoachs\Bundle\MaterialBundle\Admin;

use Appcoachs\Bundle\ManageBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;

/**
 * @author  coffey  <coffey.gao@appcoachs.com>
 * Class MediaManagementAdmin
 * @package Appcoachs\Bundle\MaterialBundle\Admin
 */
class MediaManagementAdmin extends BaseAdmin
{
    protected $baseRouteName = 'material_media_management';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('redirect_material_media_management_review', $this->getRouterIdParameter().'/redirect_material_media_management_review');
    }


    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('owner')
            ->add('campaign')
            ->add('creative', 'sonata_type_model_list', [
            ],['admin_code'    => 'appcoachs.admin.material.creative'])
            ->end();
    }

    //  input search condition
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    //  list fileds
    protected function configureListFields(ListMapper $listMapper)
    {
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
    }
}