<?php

namespace Appcoachs\Bundle\MaterialBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

                $this->getData($api,$v,$dm->getRepository('AppcoachsMaterialBundle:MediaMangement')->findOneBy(array('mediaName'=>'今日头条')));
            }
        }
        // Now you can get repositories
        // $usersRepo = $em->getRepository("myBundle:Users");
        // $user = $usersRepo->find(1);
        // outputs multiple lines to the console (adding "\n" at the end of each line)
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
        if(isset($result['status']) == "refused")
        {
            $object->setReviewStatus('Rejected by Media');

        }
        if(isset($result['status']) == "approved")
        {
            $object->setReviewStatus('Passed');
        }
        $dm->persist($object);
        $dm->flush($object);
        return $object;
    }
}
