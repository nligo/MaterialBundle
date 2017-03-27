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
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;

/**
 * @author  coffey  <coffey.gao@appcoachs.com>
 * Class CreativeAdmin
 * @package Appcoachs\Bundle\MaterialBundle\Admin
 */
class CreativeAdmin extends BaseAdmin
{
    protected $baseRouteName = 'material_creative';

    protected function configureRoutes(RouteCollection $collection)
    {

        $collection->add('sendMaterial', $this->getRouterIdParameter().'/send-material');
    }


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
            ->add('upload', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context' => 'default',
                'required' => false,
            ))
            ->add('mediaManagement', 'sonata_type_model', array(
            ), array(
                'placeholder' => 'Media Management'
            ))
            ->add('campaign')

        ;
    }

    //  input search condition
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('status',null,array('label'=>'Status',));
        $datagridMapper->add('name',null,array('label'=>'Creative'));
        $datagridMapper->add('campaign.name',null,array('label'=>'Campaign'));
        $datagridMapper->add('adgroup.name',null,array('label'=>'Adgroup'));
    }

    //  list fileds
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->add('id', 'string',
                array(
                    'label' => 'ID'
                )
            )
            ->add('status', 'string',
                array(
                    'label' => 'Status'
                )
            )
            ->addIdentifier('name', null, array(
                'label' =>  "Creative",
                'route' => array('name' => 'show')
            ))
            ->add('campaign.name', 'url',
                array(
                'label' => 'Campaign Name',
                'route' => array('name' => 'appcoachs_campaign_list')
                )
            )
            ->add('mediaManagement.mediaName','url',array(
                    'label' => 'Media Management Name',
                    'route' => array('name' => 'material_mediamanagement_list')
                )
            )

            ->add('createdAt','date',
                array('label' => 'Created At')
            )

            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('label'=>'Media Management'),
                    'Media Management' => array(
                        'template' => 'AppcoachsMaterialBundle:CreativeAdmin:media.html.twig'
                    )

                )
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper

            /*
             * The default option is to just display the value as text (for boolean this will be 1 or 0)
             */
            ->add('name','string',array('label'=>'Creative'))
            ->add('adgroup',null,array('label'=>'Adgroup'))
            ->add('campaign','string',array('label'=>'Campaign'))
        ;
    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $media = $this->getForm()->getData();
        $object->setOwner($user);
        parent::prePersist($object);
    }
}