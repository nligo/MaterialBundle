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
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\ManageBundle\Document\Campaign")
     */
    protected $campaign;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\ManageBundle\Document\Creative")
     */
    protected $creative;

    /**
     *
     * @MongoDB\ReferenceOne(targetDocument="Application\Sonata\UserBundle\Document\User")
     */
    protected $owner;

    /**
     * @MongoDB\String
     */
    private $advertiserReviewStatus;

    /**
     * @MongoDB\String
     */
    private $reviewStatus;


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set owner
     *
     * @param \Application\Sonata\UserBundle\Document\User $owner
     * @return self
     */
    public function setOwner(\Application\Sonata\UserBundle\Document\User $owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Application\Sonata\UserBundle\Document\User $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set campaign
     *
     * @param \Appcoachs\Bundle\ManageBundle\Document\Campaign $campaign
     * @return self
     */
    public function setCampaign(\Appcoachs\Bundle\ManageBundle\Document\Campaign $campaign)
    {
        $this->campaign = $campaign;
        return $this;
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
     * Set creative
     *
     * @param \Appcoachs\Bundle\ManageBundle\Document\Creative $creative
     * @return self
     */
    public function setCreative(\Appcoachs\Bundle\ManageBundle\Document\Creative $creative)
    {
        $this->creative = $creative;
        return $this;
    }

    /**
     * Get creative
     *
     * @return \Appcoachs\Bundle\ManageBundle\Document\Creative $creative
     */
    public function getCreative()
    {
        return $this->creative;
    }

    /**
     * Set advertiserReviewStatus
     *
     * @param string $advertiserReviewStatus
     * @return self
     */
    public function setAdvertiserReviewStatus($advertiserReviewStatus)
    {
        $this->advertiserReviewStatus = $advertiserReviewStatus;
        return $this;
    }

    /**
     * Get advertiserReviewStatus
     *
     * @return string $advertiserReviewStatus
     */
    public function getAdvertiserReviewStatus()
    {
        return $this->advertiserReviewStatus;
    }

    /**
     * Set reviewStatus
     *
     * @param string $reviewStatus
     * @return self
     */
    public function setReviewStatus($reviewStatus)
    {
        $this->advertiserReviewStatus = $reviewStatus;
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
}
