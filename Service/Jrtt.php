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
    const JRTT_URL = 'http://adx.toutiao.com';

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    //上传广告主资质
    public function createAdvertiser($qualification)
    {
        $advertiser = $qualification->getOwner();

        $response = $this->client->request('post', self::JRTT_URL.'/adxbuyer/api/v1.0/creatives/put', [
            'headers' => [
                'dspid' => $advertiser->getDspId(),
                'signature' => $advertiser->getDspToken(),

            ],
            'json' => [
                'adid' => $advertiser->getDspId(),
                'height' => $advertiser->getUsername(),
                'width' => $qualification->getType(),
                'qualification' => [
                    [
                        'file_name' => '工商执照',
                        'file_url' => empty($qualification->getBusinessLicense()) ? '' : $qualification->getBusinessLicense()->getCdnPath(),
                    ],
                    [
                        'file_name' => 'ICP执照',
                        'file_url' => empty($qualification->getIcpLicense()) ? '' : $qualification->getIcpLicense()->getCdnPath(),
                    ],
                ],
                'remark' => '',
            ],

        ]);
        return $this->getResponse($response);
    }

    public function getResponse($response)
    {
        if ($response->getStatusCode() == 200) {
            return \GuzzleHttp\json_encode($response->getBody()->getContents(), true);
        }

        return ['status_code' => 500, 'message' => 'request failed '];
    }
}
