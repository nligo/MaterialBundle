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
use Symfony\Component\Form\FormEvent;

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
            ->add('status', 'choice', array(
                'required' => true,
                'choices' => array('active' => 'active', 'pause' => 'pause'),
                'data' => 'active',
            ))
            ->add('type', 'choice', array(
                'required' => false,
                'choices' => $choices = array('banner' => 'Banner', 'text' => 'Text', 'icon' => 'Icon'),
                'data' => 'banner',
            ))
            ->add('name', 'text', array())
            ->add('media', 'appcoachs_media_selector', array(
                'model_manager' => $this->getModelManager(),
                'class' => 'Appcoachs\Bundle\ManageBundle\Document\Media',
                'provider' => 'sonata.media.provider.image',
                'required' => false,
                'btn_add' => false,
                'attr' => array('data-sonata-select2' => 'false', 'class' => 'form-control')
            ))
            ->add('campaign')
            ->add('upload', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context' => 'default',
                'required' => false,
            ))
        ;
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
            ->addIdentifier( 'name', null,
                array(
                    'label' => 'Creative',
                    'route' => array( 'name' => 'edit')
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
            ->addIdentifier('media.name', 'url', array(
                'label' => 'Active Video Media',
                'route' => array('name' => 'admin_appcoachs_manage_media_list')
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