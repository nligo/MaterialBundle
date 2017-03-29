# MaterialBundle
Use [MaterialBundle](https://github.com/nligo/MaterialBundle) instead
-------------------------------------------------------------------

# MaterialBundle, an material for Appcoachs

## Requirements

* Symfony (_2.1 (master branch) or later_)

## Installation

composer require the project:

        composer require nligo/material-bundle "dev-master"

Register the bundles in your `AppKernel`:

    $bundles = array(
            new Appcoachs\Bundle\MaterialBundle\AppcoachsMaterialBundle(),
            ...
    );


Using the `MaterialBundle` i only need a little configuration in your `app/config/sonata.yml`. Join the following configuration can be:

    sonata_admin:
        dashboard:
            groups:
            sonata.admin.group.,material:
                label: Video Private Auction
                item_adds:
                    - appcoachs.admin.material.creative
                roles: [ ROLE_ADMIN, ROLE_ADVERTISER, ROLE_OPERATOR ]

            sonata.admin.group.,admin:
                label: Admin Setting
                item_adds:
                    - appcoachs.admin.material.mediamanagement
                roles: [ ROLE_ADMIN]


In `app/config/routing.yml` introduced in the routing file:

    appcoachs_material:
        resource: "@AppcoachsMaterialBundle/Resources/config/routing.yml"
        prefix:   /

In `Appcoachs/Bundle/ManageBundle/Document/Creative.php` New fields and generates get set method:

    /**
     * Creative Campaign
     *
     * @MongoDB\ReferenceOne(targetDocument="Appcoachs\Bundle\ManageBundle\Document\Campaign")
     */
    protected $campaign;
    
    /**
     * Get campaign
     *
     * @return Appcoachs\Bundle\ManageBundle\Document\Campaign $campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }
    
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
    
    
    /**
     * Set campaign
     * @param Appcoachs\Bundle\ManageBundle\Document\Campaign $campaign
     * @return self
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }
    
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
    
    

Using the `MaterialBundle` i only need a little configuration in your `Appcoachs/Bundle/ManageBundle/Admin/AdgroupAdmin.php`. Replace the following method:  
  
  
    public function preUpdate($object)
        {
            if ($object->getReview() == 'approved') {
                $object->setWeight(1);
            }
            if ($object->getReview() == 'rejected') {
                $object->setWeight(2);
            }
            $owner = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $object->setOwner($owner);
            if ($object->getCreatives()) {
                foreach ($object->getCreatives() as $creative) {
                    if ($creative->getName() && $creative->getMedia()) {
                        $creative->setOwner($owner);
                        $creative->setCampaign($object->getCampaign());
                        $creative->setAdgroup($object);
                    } else {
                        $object->removeCreative($creative);
                    }
                }
            }
    
            if ($object->getVideos()) {
                foreach ($object->getVideos() as $videoad) {
                    if ($videoad->getStart() && $videoad->getComplete() && $videoad->getVideo()) {
                        $videoad->setAdgroup($object);
                    } else {
                        $object->removeVideo($videoad);
                    }
                }
            }
    
            parent::preUpdate($object);
        }