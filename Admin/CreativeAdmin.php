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
    protected $baseRouteName = 'appcoachs_material_creavite';
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('name')
            ->add('status')
            ->add('media')
            ->add('type');
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', 'string', array('label' => 'Name', 'sortable' => false))
            ->add('status', 'string', array('label' => 'Status', 'sortable' => false))
            ->add('type', 'string', array('label' => 'Ad Type', 'sortable' => false))
            ->add('createdAt', 'date', array('label' => 'Created At'));
    }
}