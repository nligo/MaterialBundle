<?php

namespace Appcoachs\Bundle\ManageBundle\Admin;

use Appcoachs\Bundle\ManageBundle\Document\QualificationReviewed;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class QualificationAdmin extends Admin
{
    const  IQIYI = 'iqiyi';
    const  YOUKU = 'youku';
    const  PPTV = 'pptv';

    protected $baseRouteName = 'appcoachs_qualification';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('redirect_qualification_review', $this->getRouterIdParameter().'/redirect_qualification_review');
        $collection->remove('export');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('owner.username', 'string', array('label' => 'Advertiser', 'sortable' => false))
            ->add('name', 'string', array('label' => 'Client Name', 'sortable' => false))
            ->add('type', 'string', array(
                'label' => 'Client Type', 'sortable' => false,
            ))
            ->add('reviewed', 'string', array('label' => 'Reviewed Video Media', 'sortable' => false))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(
                    ),
                    'redirect_qualification_review' => array(
                        'template' => 'AppcoachsManageBundle:QualificationAdmin:qualification_review.html.twig',
                    ),
                ),
            ));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Client Name'))
            ->add('type', 'choice', array(
                'choices' => array(
                    '游戏' => '游戏',
                    '电商' => '电商',
                    '工具' => '工具',
                    '社交' => '社交',
                    '品牌' => '品牌',
                ),
            ))
            ->add('businessLicense', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.file',
                'context' => 'default',

            ))
            ->add('icpLicense',  'sonata_media_type', array(
                'provider' => 'sonata.media.provider.file',
                'context' => 'default',
            ))
            ->end();
    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setOwner($user);

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

    public function postPersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine_mongodb')->getManager();
        $medias = [
            self::IQIYI,
            self::YOUKU,
            self::PPTV,
        ];
        foreach ($medias as $media) {
            $review = new QualificationReviewed();
            $review->setOwner($user)
                ->setQualification($object)
                ->setStatus('ready')
                ->setName($media);

            $dm->persist($review);
        }
        $dm->flush();
        parent::postPersist($object);
    }
}
