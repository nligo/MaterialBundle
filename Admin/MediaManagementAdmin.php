<?php

/*
 * This file is the Media ManagementAdmin's admin.
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
    protected $baseRouteName = 'material_mediamanagement';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('delete');
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
            ->add('mediaName', 'string', array('label' => 'Media Name', 'sortable' => true))
            ->add('siteId', 'string', array('label' => 'Site Id', 'sortable' => true))
            ->add('dspId', 'string', array('label' => 'dspId / Username', 'sortable' => true))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                )
            ));

    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Media Management')
            ->add('mediaName','text',array('label'=>'Media Name'),array())
            ->add('status', 'choice', array(
                'required' => true,
                'choices' => array('active' => 'active', 'Inacitve' => 'Inacitve'),
                'data' => 'active',
                'label' =>  "Status"
            ))
            ->add('siteId','text',array('label'=>'Site id'),array())
            ->add('allowRdStatus','choice', array(
                'required' => true,
                'choices' => array('Yes' => 'Yes', 'No' => 'No'),
                'data' => 'No',
                'label' =>  "Allowed to redirect ad request to other DSP"
            ))
            ->add('dspId','text',array('label'=>'DSPID/Username'),array())
            ->add('dspToken','password',array('label'=>'Token/Password'),array())

            ->end()


        ;
    }
}