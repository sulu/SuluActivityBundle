<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ActivityBundle\Admin;

use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationProviderInterface;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationItem;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

/**
 * Extends contact and account form with activities
 */
class SuluContactContentNavigation implements ContentNavigationProviderInterface
{
    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;
    public function __construct(SecurityCheckerInterface $securityChecker)
    {
        $this->securityChecker = $securityChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function getNavigationItems(array $options = [])
    {
        // contact activities tab
        $contactActivities = new ContentNavigationItem('content-navigation.contacts.activities');
        $contactActivities->setAction('activities');
        $contactActivities->setPosition(70);
        $contactActivities->setComponent('activities@suluactivity');
        $contactActivities->setComponentOptions(
            [
                'type' => 'contact',
                'widgetGroup' => 'contact-detail',
                'instanceName' => 'contact-activities'
            ]
        );
        $contactActivities->setDisplay(['edit']);

        return [$contactActivities];
    }
}
