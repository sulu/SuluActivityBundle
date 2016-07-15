<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ActivityBundle\Entity;

use JMS\Serializer\Annotation\Exclude;
use Sulu\Bundle\ContactBundle\Entity\AccountInterface;
use Sulu\Bundle\CoreBundle\Entity\ApiEntity;
use Sulu\Component\Contact\Model\ContactInterface;
use Sulu\Component\Security\Authentication\UserInterface;

/**
 * Activity
 */
class Activity extends ApiEntity
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $note;

    /**
     * @var \DateTime
     */
    private $dueDate;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var ActivityStatus
     */
    private $activityStatus;

    /**
     * @var ActivityPriority
     */
    private $activityPriority;

    /**
     * @var ActivityType
     */
    private $activityType;

    /**
     * @var ContactInterface
     */
    private $contact;

    /**
     * @var AccountInterface
     */
    private $account;

    /**
     * @var UserInterface
     * @Exclude
     */
    private $changer;

    /**
     * @var UserInterface
     * @Exclude
     */
    private $creator;

    /**
     * @var ContactInterface
     */
    private $assignedContact;

    /**
     * @param string $subject
     *
     * @return self
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $note
     *
     * @return Activity
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return Activity
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return self
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $created
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $changed
     *
     * @return self
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param ActivityStatus $activityStatus
     *
     * @return self
     */
    public function setActivityStatus(ActivityStatus $activityStatus = null)
    {
        $this->activityStatus = $activityStatus;

        return $this;
    }

    /**
     * @return ActivityStatus
     */
    public function getActivityStatus()
    {
        return $this->activityStatus;
    }

    /**
     * @param ActivityPriority $activityPriority
     *
     * @return self
     */
    public function setActivityPriority(ActivityPriority $activityPriority = null)
    {
        $this->activityPriority = $activityPriority;

        return $this;
    }

    /**
     * @return ActivityPriority
     */
    public function getActivityPriority()
    {
        return $this->activityPriority;
    }

    /**
     * @param ActivityType $activityType
     *
     * @return self
     */
    public function setActivityType(ActivityType $activityType = null)
    {
        $this->activityType = $activityType;

        return $this;
    }

    /**
     * @return ActivityType
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * @param ContactInterface $contact
     *
     * @return self
     */
    public function setContact(ContactInterface $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return ContactInterface
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param AccountInterface $account
     *
     * @return self
     */
    public function setAccount(AccountInterface $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param UserInterface $changer
     *
     * @return self
     */
    public function setChanger(UserInterface $changer = null)
    {
        $this->changer = $changer;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getChanger()
    {
        return $this->changer;
    }

    /**
     * @param UserInterface $creator
     *
     * @return self
     */
    public function setCreator(UserInterface $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param ContactInterface $assignedContact
     *
     * @return self
     */
    public function setAssignedContact(ContactInterface $assignedContact)
    {
        $this->assignedContact = $assignedContact;

        return $this;
    }

    /**
     * @return ContactInterface
     */
    public function getAssignedContact()
    {
        return $this->assignedContact;
    }
}
