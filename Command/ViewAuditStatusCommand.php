<?php

namespace Appcoachs\Bundle\MaterialBundle\Command;

use Appcoachs\Bundle\MaterialBundle\Document\Toutiaologs;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;

class ViewAuditStatusCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('appcoachs_material:send_material_status')
            ->setDescription('Timing to JRTT to check the material status');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Is the operation...',// A line
            '============',// Another line
        ]);


        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $list = $dm->getRepository('AppcoachsMaterialBundle:Creative')->findBy(array('reviewStatus'=>'Reviewing by Media'));
        if(!empty($list))
        {
            foreach ($list as $k=>$v)
            {
                $api = $this->getContainer()->get('api.jrtt');

                $this->getData($api,$v,$dm->getRepository('AppcoachsMaterialBundle:MediaManagement')->findOneBy(array('mediaName'=>'今日头条')));
            }
        }
        $returnArray = array();
        $passedList = $dm->getRepository('AppcoachsMaterialBundle:Creative')->findBy(array('reviewStatus'=>'Passed'),array('createdAt'=>'DESC'));
        if(!empty($passedList))
        {
            foreach ($passedList as $key=>$val)
            {
                $returnArray['image_ads'][$key]['id'] = $val->getId();
                $passedInfo = $dm->getRepository('AppcoachsMaterialBundle:Toutiaologs')->findOneByAdId(intval($val->getAdId()));
                if(!empty($passedInfo))
                {
                    $returnArray['image_ads'][$key]['width'] = $passedInfo->getWidth() ? $passedInfo->getWidth() : "";
                    $returnArray['image_ads'][$key]['height'] = $passedInfo->getHeight() ? $passedInfo->getHeight() : "";
                    $returnArray['image_ads'][$key]['url'] = $passedInfo->getClickThroughUrl() ? $passedInfo->getClickThroughUrl() : "";
                }
            }
            $result = new JsonResponse($returnArray);
            if(file_exists($this->getContainer()->getParameter('kernel.root_dir').'/../web/myconfig/site_resources.json'))
            {
                file_put_contents($this->getContainer()->getParameter('kernel.root_dir').'/../web/myconfig/site_resources.json', $result);
            }
            else
            {
                $fs = new Filesystem();
                $fs->mkdir($this->getContainer()->getParameter('kernel.root_dir').'/../web/myconfig/');
                file_put_contents($this->getContainer()->getParameter('kernel.root_dir').'/../web/myconfig/site_resources.json', $result);

            }
            $process = new Process('aws s3 cp /home/deployer/platform/web/myconfig/site_resources.json s3://m.config/site_resources.json');
            $process->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo 'ERR > '.$buffer;
                } else {
                    echo 'OUT > '.$buffer;
                }
            });

        }
        $output->writeln('Operation Successfully！');
    }

    private function getData($api, $object,$mediaManagement)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $result = json_decode($api->viewStatus($object,$mediaManagement),true);
        if(is_string($result))
        {
            $result = json_decode($result,true);
        }
        if(isset($result['status']) && $result['status'] == "refused")
        {
            $object->setReviewStatus('Rejected by Media');

        }
        if(isset($result['status']) && $result['status'] == "approved")
        {
            $object->setReviewStatus('Passed');
            $toutiaologs = !empty($dm->getRepository('AppcoachsMaterialBundle:Toutiaologs')->findOneBy(array('adId'=>$object->getAdId()))) ? $dm->getRepository('AppcoachsMaterialBundle:Toutiaologs')->findOneBy(array('adId'=>$object->getAdId())) : new Toutiaologs();
            $toutiaologs->setAdId(isset($result['adid']) ? $result['adid'] : '');
            $toutiaologs->setTargetUrl(isset($result['targetUrl']) ? $result['targetUrl'] : '');
            $toutiaologs->setTitle(isset($result['title']) ? $result['title'] : '');
            $toutiaologs->setSourceAvatar(isset($result['source_avatar']) ? $result['source_avatar'] : '');
            $toutiaologs->setSource(isset($result['source']) ? $result['source'] : '');
            $toutiaologs->setReason(isset($result['reason']) ? $result['reason'] : '');
            $toutiaologs->setImgUrl(isset($result['image_url']) ? json_encode($result['image_url']) : '');
            $toutiaologs->setClickThroughUrl(isset($result['click_through_url']) ? $result['click_through_url'] : '');
            $toutiaologs->setQualification(isset($result['qualification']) ? $result['qualification'] : '');
            $toutiaologs->setWidth(isset($result['width']) ? $result['width'] : '');
            $toutiaologs->setHeight(isset($result['height']) ? $result['height'] : '');
            $toutiaologs->setStatus(isset($result['status']) ? $result['status'] : '');
            $dm->persist($toutiaologs);
            $dm->flush($toutiaologs);
        }
        $dm->persist($object);
        $dm->flush($object);
        return $object;
    }
}
