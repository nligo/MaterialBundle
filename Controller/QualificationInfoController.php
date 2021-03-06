<?php

namespace Appcoachs\Bundle\MaterialBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class QualificationInfoController extends Controller
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

        $adgroup = $dm->getRepository('AppcoachsManageBundle:Qualification')->findAll();

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        $actionForm = $this->get('form.factory')->createNamedBuilder('', 'form')
            ->add('status','choice',array('label' => 'status','choices' => array('active' => 'active', 'pause' => 'pause'),))
            ->getForm();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        return $this->render($this->admin->getTemplate('list'), array(
            'action' => 'list',
            'form' => $formView,
            'actionForm' => $actionForm->createView(),
            'datagrid' => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'adgroup' => $adgroup,
        ));
    }


}
