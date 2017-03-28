<?php

namespace Appcoachs\Bundle\MaterialBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaManagementController extends Controller
{
    /**
     * List action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function listAction($cid = null)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $list = $dm->getRepository('AppcoachsMaterialBundle:MediaManagement')->findAll();
        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        return $this->render($this->admin->getTemplate('list'), array(
            'action' => 'listbyowner',
            'form' => $formView,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'list' => $list,
            'cid' => $cid
        ));
    }

    /**
     * sendMaterial action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function sendMaterialAction($id = 0 ,$cid = 0)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $list = $dm->getRepository('AppcoachsManageBundle:MediaManagement')->find($id);
        $creativeInfo = $dm->getRepository('AppcoachsMaterialBundle:Creative')->find($cid);
        dump($list);exit;
        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();
        $actionForm = $this->get('form.factory')->createNamedBuilder('', 'form')
            ->add('status','choice',array('label' => 'status','choices' => array('active' => 'active', 'Inactive' => 'Inactive'),))
            ->getForm();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        return $this->render($this->admin->getTemplate('list'), array(
            'action' => 'listbyowner',
            'form' => $formView,
            'actionForm' => $actionForm->createView(),
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'list' => $list,
        ));
    }

    public function adunitAction($id = 0,$type = 0)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $info = $dm->getRepository('AppcoachsManageBundle:Media')->find($id);
        if($type == 0)
        {
            $info->setReviewStatus('Reviewing by Media');
        }
        else
        {
            $info->setReviewStatus('Rejected by Media');
        }

        $dm->persist($info);
        $dm->flush($info);
        $url = $this->get('sonata.admin.pool')->getAdminByAdminCode('appcoachs.material.media')->generateUrl('listbyowner', array('id' => $info->getOwner()->getId()));
        return new RedirectResponse($url);
    }
}
