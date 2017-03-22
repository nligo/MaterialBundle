<?php

/*
 * This file is the creative's admin.
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
/**
 * @author  coffey  <coffey.gao@appcoachs.com>
 * Class CreativeAdmin
 * @package Appcoachs\Bundle\MaterialBundle\Admin
 */
class CreativeAdmin extends BaseAdmin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('name')
            ->add('media')
            ->add('adgroup','choice',array(
                'required'=>false
            ))
            ->add('campaign')
            ->add('type');
    }

    //  input search condition
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name',null,array('label'=>'Creative'));
        $datagridMapper->add('campaign.name',null,array('label'=>'Campaign'));
        $datagridMapper->add('adgroup.name',null,array('label'=>'Adgroup'));
    }

    //  list fileds
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('status', 'string',
                array(
                    'label' => 'Status'
                )
            )
            ->add('campaign.name', 'url',
                array(
                'label' => 'Campaign Name',
                'route' => array('name' => 'appcoachs_campaign_list')
                )
            )
            ->add('adgroup.name','url',array(
                'label' => 'Adgroup',
                )
            )
            ->add('media.name', 'url', array(
                'label' => 'Active Video Media',
                'route' => array('name' => 'admin_appcoachs_manage_media_list')
                )
            )
            ->add( 'name', null,
                array(
                    'label' => 'Creative',
                    'route' => array( 'name' => 'edit')
                )
            )
            ->add('createdAt','date',
                array('label' => 'Created At')
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}