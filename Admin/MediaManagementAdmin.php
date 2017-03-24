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
        $collection->add('listbyowner', $this->getRouterIdParameter().'/media-list-by-owner');

    }

    //  input search condition
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    //  list fileds
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('status')
            ->add('name', 'string', array('label' => 'Media', 'sortable' => true))
            ->add('owner.username','string',array('label'=>'Advertiser'))
            ->add('reviewStatus','string',array('label'=>'Review Status'))
        ;
//            ->add('_action', 'actions', array(
//                'actions' => array(
//                    'edit' => array(),
//                    'redirect_adgroup' => array(
//                        'template' => 'AppcoachsManageBundle:CampaignAdmin:list__action_redirect_adgroup.html.twig',
//                    ),
//                )
//            ))
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
    }
}