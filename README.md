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

## Configuration

Using the `MaterialBundle` i only need a little configuration in your `app/config/sonata.yml`. Join the following configuration can be:

    sonata_admin:
        dashboard:
            groups:
                sonata.admin.group.,material:
                    label: Video Private Auction
                    item_adds:
                        - appcoachs.admin.material.qualification
                        - appcoachs.admin.material.creative
                    roles: [ ROLE_ADMIN, ROLE_ADVERTISER, ROLE_OPERATOR ]


In `app/config/routing.yml` introduced in the routing file:

    appcoachs_material:
        resource: "@AppcoachsMaterialBundle/Resources/config/routing.yml"
        prefix:   /

