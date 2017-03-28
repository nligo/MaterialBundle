<?php

namespace Appcoachs\Bundle\MaterialBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CreativeController extends Controller
{
    /**
     * List action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $list = $dm->getRepository('AppcoachsMaterialBundle:Creative')->findAll();
        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();


        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        return $this->render($this->admin->getTemplate('list'), array(
            'action' => 'list',
            'form' => $formView,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'list' => $list,
        ));
    }

    public function sendMaterialAction($id = 0)
    {

        $dm = $this->get('doctrine_mongodb')->getManager();
        $creativeInfo = $dm->getRepository('AppcoachsMaterialBundle:Creative')->find($id);
        $managementInfo = $dm->getRepository('AppcoachsMaterialBundle:MediaManagement')->find($creativeInfo->getMediaManagement()->getId());
        if(empty($managementInfo))
        {
            $this->addFlash('sonata_flash_error', 'Media Management info Not Found ');
            return $this->redirect($this->generateUrl('material_creative_list'));
        }
        $creativeInfo->getMediaInfo = $managementInfo;
        $api = $this->get('api.jrtt');
        $this->getData($api,$creativeInfo);
        return $this->redirect($this->generateUrl('material_creative_list'));
        $ownerId = $creativeInfo->getOwner()->getId() ? $creativeInfo->getOwner()->getId() : 0;
        $url = $this->get('sonata.admin.pool')->getAdminByAdminCode('appcoachs.admin.material.mediamanagement')->generateUrl('list', array('cid' => $id));
        return new RedirectResponse($url);
    }

    public function getData($api, $object)
    {
        $result = json_decode($api->sendMaterial($object),true);
        if(is_string($result))
        {
            $result = json_decode($result,true);
        }
        if(isset($result['status']) == "fail")
        {
            $this->addFlash('sonata_flash_error', '对方'.$result['msg']);
            return $object;
        }
        $msg = isset($result['result'][0]['msg']) ? urldecode($result['result'][0]['msg']) : null;
        $this->addFlash('sonata_flash_error', $msg);
        return $object;
    }
}
