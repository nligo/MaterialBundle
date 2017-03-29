<?php
/**
 * Created by PhpStorm.
 * User: coffey
 * Date: 23/3/17
 * Time: AM10:39
 */

namespace Appcoachs\Bundle\MaterialBundle\Service;


class Jrtt
{
    protected $client;
    protected $container;

    public function __construct($client,$container)
    {
        $this->client = $client;
        $this->container = $container;
    }

    function createSignature($url, $key) {
        return base64_encode(hash_hmac('sha1', $url, $key, true));
    }

    /**
     * @author coffey
     *
     * send Material to Jrtt
     * @param $obj
     * @return array|string
     */
    public function sendMaterial($obj,$creative_num = 1)
    {
        $provider = $this->container->get($obj->getMedia()->getProviderName());
        $fileUrl = $this->container->getParameter('material.file_url').str_replace('/uploads/media/default','',$provider->generatePublicUrl($obj->getMedia(), 'reference'));
        $signature = $this->createSignature("http://adx.toutiao.com/adxbuyer/api/v1.0/creatives/put?dspid={$obj->getMediaInfo->getDspId()}&creative_num={$creative_num}",$obj->getMediaInfo->getDspToken());
        $url = "http://adx.toutiao.com/adxbuyer/api/v1.0/creatives/put?dspid={$obj->getMediaInfo->getDspId()}&creative_num={$creative_num}&signature=".$signature;
        $response = $this->client->request('post', $url, [
                'json'=>array(
                    'creatives' => array (
                        0 => array(
                            'adid'  => $obj->getAdid(),
                            'width' => '690',
                            'height'=> '286',
                            'title' => $obj->getName(),
                            'description' => 'coffey',
                            'download_url' => $fileUrl,
                            'source' => 'dsp',
                            'ad_type' => '1',
                            'app_type' => 'ios',
                            'app_name' => 'coffey',
                            'nurl' => 'http://platform.sandbox.appcoachs.com/uploads/media/default/58d9/e8/cd0671369ad0c75ca7c715b85da2743b3971edf2.jpeg',
                            'show_url' =>
                                array (
                                    0 => 'http://platform.sandbox.appcoachs.com/uploads/media/default/58d9/e8/cd0671369ad0c75ca7c715b85da2743b3971edf2.jpeg',
                                ),
                            'click_url' =>
                                array (
                                    0 => 'http://platform.sandbox.appcoachs.com/uploads/media/default/58d9/e8/cd0671369ad0c75ca7c715b85da2743b3971edf2.jpeg',
                                ),
                            'img_url' => 'http://platform.sandbox.appcoachs.com/uploads/media/default/58d9/e8/cd0671369ad0c75ca7c715b85da2743b3971edf2.jpeg',
                            'click_through_url' => 'http://platform.sandbox.appcoachs.com/uploads/media/default/58d9/e8/cd0671369ad0c75ca7c715b85da2743b3971edf2.jpeg',
                        ),
                    ),
                ),
            ]
        );
        return $this->getResponse($response);
    }


    /**
     * @author  coffey
     *
     * Check the material status
     * @param $obj
     * @param int $adid
     * @return array|string
     */
    public function viewStatus($obj,$mediaManagement)
    {
        $signature = $this->createSignature("http://adx.toutiao.com/adxbuyer/api/v1.0/creatives/get?dspid={$mediaManagement->getDspId()}&adid={$obj->getAdid()}",$mediaManagement->getDspToken());
        $url = "http://adx.toutiao.com/adxbuyer/api/v1.0/creatives/get?dspid={$mediaManagement->getDspId()}&adid={$obj->getAdid()}&signature=".$signature;
        $response = $this->client->request('get', $url);
        return $this->getResponse($response);
    }


    public function getResponse($response)
    {
        if ($response->getStatusCode() == 200) {
            return json_encode($response->getBody()->getContents(), true);
        }
        return ['status_code' => 500, 'message' => 'request failed '];
    }
}
