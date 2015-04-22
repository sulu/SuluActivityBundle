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
class SuluAccountContentNavigation implements ContentNavigationProviderInterface
{
    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;

    public function __construct(SecurityCheckerInterface $securityChecker)
    {
        $this->securityChecker = $securityChecker;
    }


    public function getNavigationItems(array $options = array())
    {
        // account activities tab
        $accountActivities = new ContentNavigationItem('content-navigation.contacts.activities');
        $accountActivities->setAction('activities');
        $accountActivities->setComponent('activities@suluactivity');
        $accountActivities->setComponentOptions(
            array('type' => 'account', 'widgetGroup' => 'account-detail', 'instanceName' => 'account-activities')
        );
        $accountActivities->setDisplay(array('edit'));
        $accountActivities->setPosition(2);

        return array($accountActivities);
    }
}
