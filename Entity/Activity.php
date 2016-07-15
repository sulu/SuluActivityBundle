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
     * Set subject
     *
     * @param string $subject
     * @return Activity
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Activity
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Activity
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Activity
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Activity
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set changed
     *
     * @param \DateTime $changed
     * @return Activity
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set activityStatus
     *
     * @param ActivityStatus $activityStatus
     * @return Activity
     */
    public function setActivityStatus(ActivityStatus $activityStatus = null)
    {
        $this->activityStatus = $activityStatus;

        return $this;
    }

    /**
     * Get activityStatus
     *
     * @return ActivityStatus
     */
    public function getActivityStatus()
    {
        return $this->activityStatus;
    }

    /**
     * Set activityPriority
     *
     * @param ActivityPriority $activityPriority
     * @return Activity
     */
    public function setActivityPriority(ActivityPriority $activityPriority = null)
    {
        $this->activityPriority = $activityPriority;

        return $this;
    }

    /**
     * Get activityPriority
     *
     * @return ActivityPriority
     */
    public function getActivityPriority()
    {
        return $this->activityPriority;
    }

    /**
     * Set activityType
     *
     * @param ActivityType $activityType
     * @return Activity
     */
    public function setActivityType(ActivityType $activityType = null)
    {
        $this->activityType = $activityType;

        return $this;
    }

    /**
     * Get activityType
     *
     * @return ActivityType
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * Set contact
     *
     * @param ContactInterface $contact
     * @return Activity
     */
    public function setContact(ContactInterface $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return ContactInterface
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set account
     *
     * @param AccountInterface $account
     * @return Activity
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
     * Set changer
     *
     * @param UserInterface $changer
     * @return Activity
     */
    public function setChanger(UserInterface $changer = null)
    {
        $this->changer = $changer;

        return $this;
    }

    /**
     * Get changer
     *
     * @return UserInterface
     */
    public function getChanger()
    {
        return $this->changer;
    }

    /**
     * Set creator
     *
     * @param UserInterface $creator
     * @return Activity
     */
    public function setCreator(UserInterface $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return UserInterface
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set assignedContact
     *
     * @param ContactInterface $assignedContact
     * @return Activity
     */
    public function setAssignedContact(ContactInterface $assignedContact)
    {
        $this->assignedContact = $assignedContact;

        return $this;
    }

    /**
     * Get assignedContact
     *
     * @return ContactInterface
     */
    public function getAssignedContact()
    {
        return $this->assignedContact;
    }
}
