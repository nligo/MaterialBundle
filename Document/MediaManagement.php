<?php

namespace Appcoachs\Bundle\MaterialBundle\Document;

use Appcoachs\Bundle\ManageBundle\Document\Base;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *      repositoryClass="Appcoachs\Bundle\MaterialBundle\Document\Repository\MediaManagement",
 *      collection="media_management"
 * )
 */
class MediaManagement extends Base
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $mediaName = "";

    /**
     * @MongoDB\String
     */
    protected $status = "Inactive";

    /**
     * @MongoDB\String
     */
    protected $siteId = "";

    /**
     * @MongoDB\String
     */
    protected $allowRdStatus = "Yes";


    /**
     * @MongoDB\String
     */
    protected $dspId = "";

    /**
     * @MongoDB\String
     */
    protected $dspToken = "";

    public function __toString()
    {
        return $this->getMediaName();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set siteId
     *
     * @param string $siteId
     * @return self
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * Get siteId
     *
     * @return string $siteId
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Set allowRdStatus
     *
     * @param string $allowRdStatus
     * @return self
     */
    public function setAllowRdStatus($allowRdStatus)
    {
        $this->allowRdStatus = $allowRdStatus;
        return $this;
    }

    /**
     * Get allowRdStatus
     *
     * @return string $allowRdStatus
     */
    public function getAllowRdStatus()
    {
        return $this->allowRdStatus;
    }

    /**
     * Set dspId
     *
     * @param string $dspId
     * @return self
     */
    public function setDspId($dspId)
    {
        $this->dspId = $dspId;
        return $this;
    }

    /**
     * Get dspId
     *
     * @return string $dspId
     */
    public function getDspId()
    {
        return $this->dspId;
    }

    /**
     * Set dspToken
     *
     * @param string $dspToken
     * @return self
     */
    public function setDspToken($dspToken)
    {
        $this->dspToken = $dspToken;
        return $this;
    }

    /**
     * Get dspToken
     *
     * @return string $dspToken
     */
    public function getDspToken()
    {
        return $this->dspToken;
    }


    /**
     * Set mediaName
     *
     * @param string $mediaName
     * @return self
     */
    public function setMediaName($mediaName)
    {
        $this->mediaName = $mediaName;
        return $this;
    }

    /**
     * Get mediaName
     *
     * @return string $mediaName
     */
    public function getMediaName()
    {
        return $this->mediaName;
    }
}
