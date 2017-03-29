<?php

namespace Appcoachs\Bundle\MaterialBundle\Document;


use Appcoachs\Bundle\ManageBundle\Document\Base;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *      repositoryClass="Appcoachs\Bundle\MaterialBundle\Document\Repository\Toutiaologs",
 *      collection="toutiao_logs"
 * )
 */
class Toutiaologs extends Base
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\Integer
     */
    protected $adId;

    /**
     * @MongoDB\String
     */
    protected $status;

    /**
     * @MongoDB\String
     */
    protected $type;

    /**
     * @MongoDB\String
     */
    protected $title;

    /**
     * @MongoDB\String
     */
    protected $targetUrl;

    /**
     * @MongoDB\String
     */
    protected $clickThroughUrl;

    /**
     * @MongoDB\String
     */
    protected $newTargetUrl;

    /**
     * @MongoDB\String
     */
    protected $height;

    /**
     * @MongoDB\String
     */
    protected $width;

    /**
     * @MongoDB\String
     */
    protected $reason;

    /**
     * @MongoDB\String
     */
    protected $qualification;

    /**
     * @MongoDB\String
     */
    protected $sourceAvatar;

    /**
     * @MongoDB\String
     */
    protected $source;

    /**
     * @MongoDB\String
     */
    protected $imgUrl;



    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adId
     *
     * @param integer $adId
     * @return self
     */
    public function setAdId($adId)
    {
        $this->adId = $adId;
        return $this;
    }

    /**
     * Get adId
     *
     * @return integer $adId
     */
    public function getAdId()
    {
        return $this->adId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set targetUrl
     *
     * @param string $targetUrl
     * @return self
     */
    public function setTargetUrl($targetUrl)
    {
        $this->targetUrl = $targetUrl;
        return $this;
    }

    /**
     * Get targetUrl
     *
     * @return string $targetUrl
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * Set clickThroughUrl
     *
     * @param string $clickThroughUrl
     * @return self
     */
    public function setClickThroughUrl($clickThroughUrl)
    {
        $this->clickThroughUrl = $clickThroughUrl;
        return $this;
    }

    /**
     * Get clickThroughUrl
     *
     * @return string $clickThroughUrl
     */
    public function getClickThroughUrl()
    {
        return $this->clickThroughUrl;
    }

    /**
     * Set newTargetUrl
     *
     * @param string $newTargetUrl
     * @return self
     */
    public function setNewTargetUrl($newTargetUrl)
    {
        $this->newTargetUrl = $newTargetUrl;
        return $this;
    }

    /**
     * Get newTargetUrl
     *
     * @return string $newTargetUrl
     */
    public function getNewTargetUrl()
    {
        return $this->newTargetUrl;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Get height
     *
     * @return string $height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param string $width
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Get width
     *
     * @return string $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return self
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * Get reason
     *
     * @return string $reason
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     * @return self
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;
        return $this;
    }

    /**
     * Get qualification
     *
     * @return string $qualification
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set sourceAvatar
     *
     * @param string $sourceAvatar
     * @return self
     */
    public function setSourceAvatar($sourceAvatar)
    {
        $this->sourceAvatar = $sourceAvatar;
        return $this;
    }

    /**
     * Get sourceAvatar
     *
     * @return string $sourceAvatar
     */
    public function getSourceAvatar()
    {
        return $this->sourceAvatar;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return self
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Get source
     *
     * @return string $source
     */
    public function getSource()
    {
        return $this->source;
    }


    /**
     * Set imgUrl
     *
     * @param string $imgUrl
     * @return self
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
        return $this;
    }

    /**
     * Get imgUrl
     *
     * @return string $imgUrl
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }
}
