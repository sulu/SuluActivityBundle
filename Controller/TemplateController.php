<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemplateController extends Controller
{
    /**
     * Returns the activities form for contacts
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactActivitiesAction()
    {
        $values = $this->getActivityDropdownValues();

        return $this->render('SuluActivityBundle:Template:contact.activities.html.twig', $values);
    }

    /**
     * Returns the possible values for the dropdowns of activities
     * @return array
     */
    private function getActivityDropdownValues()
    {
        $values = array();

        $values['activityTypes'] = $this->getDoctrine()
            ->getRepository('SuluActivityBundle:ActivityType')
            ->findAll();

        $values['activityPriorities'] = $this->getDoctrine()
            ->getRepository('SuluActivityBundle:ActivityPriority')
            ->findAll();

        $values['activityStatuses'] = $this->getDoctrine()
            ->getRepository('SuluActivityBundle:ActivityStatus')
            ->findAll();

        return $values;
    }
}
