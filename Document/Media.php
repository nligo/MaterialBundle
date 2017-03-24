<?php

namespace Appcoachs\Bundle\MaterialBundle\Document;

use Sonata\MediaBundle\Document\BaseMedia;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *      repositoryClass="Appcoachs\Bundle\MaterialBundle\Document\Repository\Media",
 *      collection="media"
 * )
 */
class Media extends \Appcoachs\Bundle\ManageBundle\Document\Media
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $status;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Application\Sonata\UserBundle\Document\User")
     */
    protected $owner;

    /**
     * @MongoDB\Int
     */
    protected $width = 1;

    /**
     * @MongoDB\Int
     */
    protected $height = 1;

    /**
     * @MongoDB\String
     */
    protected $thumbnail;

    /**
     * @MongoDB\String
     */
    protected $path;

    /**
     * @MongoDB\String
     */
    protected $localPath;
    
    /**
     * @MongoDB\String
     */
    protected $cdnPath;

    /**
     * @MongoDB\String
     */
    protected $duration;

    /**
     * @MongoDB\Int
     */
    protected $bitrate;

    /**
     * @MongoDB\String
     */
    protected $reviewStatus;

    public function __construct()
    {
        $this->setReviewStatus('Ready');
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
     * @MongoDB\String
     */
    protected $codec;

    public function getId()
    {
        return $this->id;
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
     * Set path
     *
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set localPath
     *
     * @param string $localPath
     * @return self
     */
    public function setLocalPath($localPath)
    {
        $this->localPath = $localPath;
        return $this;
    }

    /**
     * Get localPath
     *
     * @return string $localPath
     */
    public function getLocalPath()
    {
        return $this->localPath;
    }

    /**
     * Set cdnPath
     *
     * @param string $cdnPath
     * @return self
     */
    public function setCdnPath($cdnPath)
    {
        $this->cdnPath = $cdnPath;
        return $this;
    }

    /**
     * Get cdnPath
     *
     * @return string $cdnPath
     */
    public function getCdnPath()
    {
        return $this->cdnPath;
    }

    /**
     * Set duration
     *
     * @param string $duration
     * @return self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * Get duration
     *
     * @return string $duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set bitrate
     *
     * @param int $bitrate
     * @return self
     */
    public function setBitrate($bitrate)
    {
        $this->bitrate = $bitrate;
        return $this;
    }

    /**
     * Get bitrate
     *
     * @return int $bitrate
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * Set codec
     *
     * @param string $codec
     * @return self
     */
    public function setCodec($codec)
    {
        $this->codec = $codec;
        return $this;
    }

    /**
     * Get codec
     *
     * @return string $codec
     */
    public function getCodec()
    {
        return $this->codec;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return self
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string $thumbnail
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
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

    public function __clone()
    {
        $this->owner = null;
    }
}
