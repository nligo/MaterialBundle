<?php

namespace Appcoachs\Bundle\MaterialBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Creative Class
 *
 * @MongoDB\Document(
 *      collection = "creative"
 * )
 * @MongoDB\HasLifecycleCallbacks
 */
class Creative extends \Appcoachs\Bundle\ManageBundle\Document\Base
{
    /**
     * Creative Id
     *
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * Creative Name
     *
     * @MongoDB\String
     */
    protected $name;

    /**
     * Creative Type
     *
     * @MongoDB\String
     */
    protected $type;

    /**
     * Creative Media
     *
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\ManageBundle\Document\Media", cascade={"persist"})
     */
    protected $media;

    /**
     * Creative MediaManagement
     *
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\MaterialBundle\Document\MediaManagement", cascade={"persist"})
     */
    protected $mediaManagement;

    /**
     * Creative Owner
     *
     * @MongoDB\ReferenceOne(targetDocument="Application\Sonata\UserBundle\Document\User")
     */
    protected $owner;

    /**
     * Parent Adgroup
     *
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\ManageBundle\Document\Adgroup")
     */
    protected $adgroup;

    /**
     * Creative Campaign
     *
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\ManageBundle\Document\Campaign")
     */
    protected $campaign;

    /**
     * Creative Status
     *
     * @MongoDB\String
     */
    protected $status;

    /**
     * Creative ReviewStatus
     *
     * @MongoDB\String
     */
    protected $reviewStatus;

    /**
     * Creative Adid
     *
     * @MongoDB\String
     */
    protected $adid;

    public function __construct()
    {
        $this->setReviewStatus('Ready');
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reviewStatus
     *
     * @param string $reviewStatus
     * @return self
     */
    public function setReviewStatus($reviewStatus)
    {
        $this->reviewStatus = $reviewStatus;
        return $this;
    }

    /**
     * Get reviewStatus
     *
     * @return string $reviewStatus
     */
    public function getReviewStatus()
    {
        return $this->reviewStatus;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
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
     * Set media
     *
     * @param \Appcoachs\Bundle\ManageBundle\Document\Media $media
     * @return self
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * Get media
     *
     * @param \Appcoachs\Bundle\ManageBundle\Document\Media $media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set mediaManagement
     *
     * @param \Appcoachs\Bundle\MaterialBundle\Document\MediaMangement $mediaManagement
     * @return self
     */
    public function setMediaManagement($mediaManagement)
    {
        $this->mediaManagement = $mediaManagement;
    }

    /**
     * Get MediaManagement
     *
     * @return \Appcoachs\Bundle\MaterialBundle\Document\MediaMangement $mediaManagement
     */
    public function getMediaManagement()
    {
        return $this->mediaManagement;
    }

    /**
     * Set media by upload
     *
     * @param \Appcoachs\Bundle\MaterialBundle\Document\Media $media
     * @return self
     */
    public function setUpload($media)
    {
        if ($media || $media instanceof MediaInterface) {
            $this->media = $media;
        }

        return $this;
    }

    /**
     * Get media by upload
     *
     * @return \Appcoachs\Bundle\MaterialBundle\Document\Media $media
     */
    public function getUpload()
    {
        return $this->media;
    }

    /**
     * Get owner
     *
     * @return Application\Sonata\UserBundle\Document\User $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner
     * @param Application\Sonata\UserBundle\Document\User $owner
     * @return self
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get adgroup
     *
     * @return \Appcoachs\Bundle\ManageBundle\Document\Adgroup $adgroup
     */
    public function getAdgroup()
    {
        return $this->adgroup;
    }

    /**
     * Set owner
     *
     * @param \Appcoachs\Bundle\ManageBundle\Document\Adgroup $adgroup
     * @return self
     */
    public function setAdgroup($adgroup)
    {
        $this->adgroup = $adgroup;
    }

    /**
     * Set resource
     *
     * @param hash $resource
     * @return self
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * Get resource
     *
     * @return hash $resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get campaign
     *
     * @return \Appcoachs\Bundle\ManageBundle\Document\Campaign $campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Set campaign
     * @param \Appcoachs\Bundle\ManageBundle\Document\Campaign $campaign
     * @return self
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Set adid
     *
     * @param int $adid
     * @return self
     */
    public function setAdid($adid)
    {
        $this->adid = $adid;
        return $this;
    }

    /**
     * Get adid
     *
     * @return int $adid
     */
    public function getAdid()
    {
        return $this->adid;
    }
}
