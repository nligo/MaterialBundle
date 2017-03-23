<?php

namespace Appcoachs\Bundle\MaterialBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\AdminBundle\Exception\ModelManagerException;

class QualificationReviewedController extends Controller
{
    public function AuditAction()
    {
        $object = $this->admin->getSubject();
        $media = $object->getName();
        $api = $this->get('api.'.$media);
        $object = $this->getData($api, $object, $media);

        try {
            $object = $this->admin->update($object);

        } catch (ModelManagerException $e) {
        }

        return $this->redirect($this->generateUrl('appcoachs_material_qualificationinfo_reviewed_list', ['qid' => $object->getQualification()->getId()]));
    }

    public function getData($api, $object, $media)
    {

        //平台接口返回格式不一样
        $statusCode = [
            'pptv' => ['status_code', 200],
            'iqiyi' => ['code', '0'],
            'youku' => ['result', 0],
            'jrtt' => ['code', 200],

        ];
        if ($object->getStatus() == 'ready' || $object->getStatus() == 'rejected') {

            $data = $api->createAdvertiser($object->getQualification());
            if($media == 'jrtt')
            {
                return $object;
            }

            if ($data[$statusCode[$media][0]] == $statusCode[$media][1]) {
                $object->setStatus('waiting');
                $object->setNote('');
                $this->addFlash('sonata_flash_success', 'Qualification has been submitted');
            } else {
                $object->setStatus('rejected');
                $object->setNote(json_encode($data, JSON_UNESCAPED_UNICODE));   // json_encode  不转义中文
                $this->addFlash('sonata_flash_error', 'There is some error ,please check the note');
            }
        } else {
            $this->addFlash('sonata_flash_error', 'Advertisers are being reviewed or approved ');
        }

        return $object;
    }
}
