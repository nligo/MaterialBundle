<?php

namespace Appcoachs\Bundle\MaterialBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaManagementController extends Controller
{
//    /**
//     * List action.
//     *
//     * @return Response
//     *
//     * @throws AccessDeniedException If access is not granted
//     */
//    public function listAction($cid = null)
//    {
//        if (false === $this->admin->isGranted('LIST')) {
//            throw new AccessDeniedException();
//        }
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        $list = $dm->getRepository('AppcoachsMaterialBundle:MediaManagement')->findAll();
//        $datagrid = $this->admin->getDatagrid();
//        $formView = $datagrid->getForm()->createView();
//        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
//        return $this->render($this->admin->getTemplate('list'), array(
//            'action' => 'listbyowner',
//            'form' => $formView,
//            'csrf_token' => $this->getCsrfToken('sonata.batch'),
//            'list' => $list,
//            'cid' => $cid
//        ));
//
//
//    }

    /**
     * List action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function listAction($cid = null)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $templateKey = 'list_admin';
        }
        $cid = $this->getRequest()->get('cid');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $list = $dm->getRepository('AppcoachsMaterialBundle:MediaManagement')->findAll();
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }
        $this->admin->createQuery('list', $cid);
        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        return $this->render($this->admin->getTemplate('list'), array(
            'action' => 'list',
            'form' => $formView,
            'datagrid' => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'cid' => $cid,
            'list' => $list,
        ));
    }


    /**
     * sendMaterial action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function sendMaterialAction($id = null ,$cid = null)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $info = $dm->getRepository('AppcoachsMaterialBundle:MediaManagement')->find($id);
        $creativeInfo = $dm->getRepository('AppcoachsMaterialBundle:Creative')->find($cid);
        if(empty($info))
        {
            $this->addFlash('sonata_flash_error', 'Media Management info Not Found ');
            return $this->redirect($this->generateUrl('material_mediamanagement_list',array('id'=>$id,'cid'=>$cid)));
        }
        $creativeInfo->getMediaInfo = $info;
        $api = $this->get('api.jrtt');
        $this->getData($api,$creativeInfo);
        return $this->redirect($this->generateUrl('material_mediamanagement_list',array('id'=>$id,'cid'=>$cid)));
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

    private function getData($api, $object)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        if(empty($object->getAdid()))
        {
            $object->setAdid(time().rand(5, 15));
            $dm->persist($object);
            $dm->flush($object);
        }
        $result = json_decode($api->sendMaterial($object),true);
        if(is_string($result))
        {
            $result = json_decode($result,true);
        }
        if(isset($result['status']) && $result['status'] == "fail")
        {
            $this->addFlash('sonata_flash_error', '对方'.$result['msg']);
            return $object;
        }

        if(isset($result['result'][0]['status']) && $result['result'][0]['status'] == 'success')
        {

            $object->setReviewStatus('Reviewing by Media');
            $dm->persist($object);
            $dm->flush($object);
            $this->addFlash('sonata_flash_success', 'Material submitted successfully！');
            return $object;
        }
        $msg = isset($result['result'][0]['msg']) ? urldecode($result['result'][0]['msg']) : null;
        $this->addFlash('sonata_flash_error', $msg);
        return $object;
    }
}
