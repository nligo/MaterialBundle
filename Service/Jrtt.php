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

    function createSignature($url, $key) {
        return base64_encode(hash_hmac('sha1', $url, $key, true));
    }

    /**
     * @author coffey
     * @param $obj
     * @return array|string
     */
    public function sendMaterial($obj,$creative_num = 1)
    {
        $signature = $this->createSignature("http://adx.toutiao.com/adxbuyer/api/v1.0/creatives/put?dspid={$obj->getMediaInfo->getDspId()}&creative_num={$creative_num}",$obj->getMediaInfo->getDspToken());
        $url = "http://adx.toutiao.com/adxbuyer/api/v1.0/creatives/put?dspid={$obj->getMediaInfo->getDspId()}&creative_num={$creative_num}&signature=".$signature;
        $response = $this->client->request('post', $url, [
            'json'=>array(
                'creatives' => array (
                    0 => array(
                        'adid' => '1234567890',
                        'width' => '690',
                        'height' => '286',
                        'title' => 'test',
                        'source' => 'dsp',
                        'ad_type' => '1',
                        'nurl' => 'http://app.coachs.dev:1111/uploads/media/default/58d9/d3/8610b8acbcfc73c62cbf2689d3011eaf29f8dbd4.jpeg',
                        'show_url' =>
                            array (
                                0 => 'http://app.coachs.dev:1111/uploads/media/default/58d9/d3/8610b8acbcfc73c62cbf2689d3011eaf29f8dbd4.jpeg',
                            ),
                        'click_url' =>
                            array (
                                0 => 'http://app.coachs.dev:1111/uploads/media/default/58d9/d3/8610b8acbcfc73c62cbf2689d3011eaf29f8dbd4.jpeg',
                            ),
                        'img_url' => 'http://app.coachs.dev:1111/uploads/media/default/58d9/d3/8610b8acbcfc73c62cbf2689d3011eaf29f8dbd4.jpeg.jpeg',
                        'click_through_url' => 'http://app.coachs.dev:1111/uploads/media/default/58d9/d3/8610b8acbcfc73c62cbf2689d3011eaf29f8dbd4.jpeg.jpeg',
                    ),
                ),
            ),
            ]
        );
        dump(\GuzzleHttp\json_decode($this->getResponse($response)));exit;
        return $this->getResponse($response);
    }

    /**
     * @author  coffey
     *
     * curl 函数
     * @param string $url 请求的地址
     * @param string $type POST/GET/post/get
     * @param array $data 要传输的数据
     * @param string $err_msg 可选的错误信息（引用传递）
     * @param int $timeout 超时时间
     * @param array 证书信息
     */
    function curl($url, $type, $data = false, &$err_msg = null, $timeout = 20, $cert_info = array())
    {
        $type = strtoupper($type);
        if ($type == 'GET' && is_array($data)) {
            $data = http_build_query($data);
        }

        $option = array();

        if ( $type == 'POST' ) {
            $option[CURLOPT_POST] = 1;
        }
        if ($data) {
            if ($type == 'POST') {
                $option[CURLOPT_POSTFIELDS] = $data;
            } elseif ($type == 'GET') {
                $url = strpos($url, '?') !== false ? $url.'&'.$data :  $url.'?'.$data;
            }
        }

        $option[CURLOPT_URL]            = $url;
        $option[CURLOPT_FOLLOWLOCATION] = TRUE;
        $option[CURLOPT_MAXREDIRS]      = 4;
        $option[CURLOPT_RETURNTRANSFER] = TRUE;
        $option[CURLOPT_TIMEOUT]        = $timeout;

        //设置证书信息
        if(!empty($cert_info) && !empty($cert_info['cert_file'])) {
            $option[CURLOPT_SSLCERT]       = $cert_info['cert_file'];
            $option[CURLOPT_SSLCERTPASSWD] = $cert_info['cert_pass'];
            $option[CURLOPT_SSLCERTTYPE]   = $cert_info['cert_type'];
        }

        //设置CA
        if(!empty($cert_info['ca_file'])) {
            // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
            $option[CURLOPT_SSL_VERIFYPEER] = 1;
            $option[CURLOPT_CAINFO] = $cert_info['ca_file'];
        } else {
            // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
            $option[CURLOPT_SSL_VERIFYPEER] = 0;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $option);
        $response = curl_exec($ch);
        $curl_no  = curl_errno($ch);
        $curl_err = curl_error($ch);
        curl_close($ch);

        // error_log
        if($curl_no > 0) {
            if($err_msg !== null) {
                $err_msg = '('.$curl_no.')'.$curl_err;
            }
        }
        return $response;
    }

    public function getResponse($response)
    {
        if ($response->getStatusCode() == 200) {
            return json_encode($response->getBody()->getContents(), true);
        }

        return ['status_code' => 500, 'message' => 'request failed '];
    }
}
