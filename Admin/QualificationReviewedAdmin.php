<?php

namespace Appcoachs\Bundle\MaterialBundle\Admin;

use Appcoachs\Bundle\ManageBundle\Admin\BaseAdmin;
use Appcoachs\Bundle\ManageBundle\Document\Qualification;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

class QualificationReviewedAdmin extends BaseAdmin
{

    protected $baseRouteName = 'appcoachs_material_qualificationinfo_reviewed';

    protected $baseRoutePattern = 'qualificationinfo/{qid}/reviewed';

    protected $qid;
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('audit', $this->getRouterIdParameter().'/audit');
        $collection->remove('export');
    }

    public function setRequest(Request $request)
    {
        if (null == $this->qid && null != $request) {
            $this->qid = $request->attributes->get('qid');
        }

        parent::setRequest($request);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (null != $this->qid) {
            $query->field('qualification.id')->equals($this->qid);
        }

        return $query;
    }

    public function generateUrl($name, array $parameters = array(), $absolute = false)
    {
        return parent::generateUrl($name, array_merge($parameters, array('qid' => array_key_exists('qid', $parameters) ? $parameters['qid'] : ($this->qid ? $this->qid : 1))), $absolute);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('qualification.name', 'string', array('label' => 'Client Name', 'sortable' => TRUE))
            ->add('name', 'string', array('label' => 'Video Media', 'sortable' => TRUE))
            ->add('status', 'string', array(
                'label' => 'Review Status', 'sortable' => TRUE,
                ))
            ->add('note', 'string', array('label' => 'Note', 'sortable' => TRUE))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'audit' => array(
                        'template' => 'AppcoachsMaterialBundle:ReviewedAdmin:audit.html.twig'
                    ),
                ),
            ));
    }



    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'choice', array(
                'choices' => array(
                    'pptv' => 'PPTV',
                    'youku' => 'Youku',
                    'iqiyi' => 'iQIYI',
                    'jrtt' => '今日头条',
                ),
                'label' => 'Video Media', ))
            ->add('qualification', 'sonata_type_model_list', [
            ],['admin_code'    => 'appcoachs.admin.qualification'])
            ->end();
    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $qualification = $this->getConfigurationPool()->getContainer()->get('doctrine_mongodb')->getManager()->getRepository(Qualification::class)->find($this->qid);
        $object->setOwner($user);
        $object->setQualification($qualification);

        parent::prePersist($object);
    }
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        if (
            $this->hasRoute('delete') && $this->isGranted('DELETE')
        ) {
            unset($actions['delete']);
        }

        return $actions;
    }

    public function getQid()
    {
        return $this->qid;
    }
//    public function preUpdate($object)
//    {
//        $object->getProperty()->setMethod(array('promotion'));

//        parent::preUpdate($object);
//    }
}
