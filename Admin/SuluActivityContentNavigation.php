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

use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationInterface;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationItem;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

/**
 * Extends contact and account form with activities
 */
class SuluActivityContentNavigation implements ContentNavigationInterface
{
    private $navigation = array();

    public function __construct()
    {
        // contact activities tab
        $contactActivities = new ContentNavigationItem('content-navigation.contacts.activities');
        $contactActivities->setAction('activities');
        $contactActivities->setComponent('activities@suluactivity');
        $contactActivities->setComponentOptions(
            array('type' => 'contact', 'widgetGroup' => 'contact-detail', 'instanceName' => 'contact-activities')
        );
        $contactActivities->setDisplay(array('edit'));
        $contactActivities->setGroups(array('contact'));
        $contactActivities->setPosition(2);

        // account activities tab
        $accountActivities = new ContentNavigationItem('content-navigation.contacts.activities');
        $accountActivities->setAction('activities');
        $accountActivities->setGroups(array('account'));
        $accountActivities->setComponent('activities@suluactivity');
        $accountActivities->setComponentOptions(
            array('type' => 'account', 'widgetGroup' => 'account-detail', 'instanceName' => 'account-activities')
        );
        $accountActivities->setDisplay(array('edit'));
        $accountActivities->setPosition(2);

        $this->navigation[] = $contactActivities;
        $this->navigation[] = $accountActivities;

    }

    public function getNavigationItems()
    {
        return $this->navigation;
    }
}
