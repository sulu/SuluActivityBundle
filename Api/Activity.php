<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ActivityBundle\Api;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Sulu\Bundle\ActivityBundle\Entity\Activity as ActivityEntity;
use Sulu\Bundle\ActivityBundle\Entity\ActivityPriority as ActivityPriorityEntity;
use Sulu\Bundle\ActivityBundle\Entity\ActivityStatus as ActivityStatusEntity;
use Sulu\Bundle\ActivityBundle\Entity\ActivityType as ActivityTypeEntity;
use Sulu\Bundle\ContactBundle\Api\Account;
use Sulu\Bundle\ContactBundle\Api\Contact;
use Sulu\Bundle\ContactBundle\Entity\AccountInterface;
use Sulu\Component\Contact\Model\ContactInterface;
use Sulu\Component\Rest\ApiWrapper;

/**
 * The Activity class which will be exported to the API
 *
 * @ExclusionPolicy("all")
 */
class Activity extends ApiWrapper
{
    /**
     * @param ActivityEntity $activity
     * @param string $locale The locale of this product
     */
    public function __construct(ActivityEntity $activity, $locale)
    {
        $this->entity = $activity;
        $this->locale = $locale;
    }

    /**
     * Returns the id of the product
     *
     * @return int
     * @VirtualProperty
     * @SerializedName("id")
     * @Groups({"fullActivity"})
     */
    public function getId()
    {
        return $this->entity->getId();
    }

    /**
     * @param string $subject
     *
     * @return Activity
     */
    public function setSubject($subject)
    {
        $this->entity->setSubject($subject);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("subject")
     * @Groups({"fullActivity"})
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->entity->getSubject();
    }

    /**
     * @param string $note
     *
     * @return Activity
     */
    public function setNote($note)
    {
        $this->entity->setNote($note);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("note")
     * @Groups({"fullActivity"})
     *
     * @return string
     */
    public function getNote()
    {
        return $this->entity->getNote();
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return Activity
     */
    public function setDueDate($dueDate)
    {
        $this->entity->setDueDate($dueDate);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("dueDate")
     * @Groups({"fullActivity"})
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->entity->getDueDate();
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Activity
     */
    public function setStartDate($startDate)
    {
        $this->entity->setStartDate($startDate);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("startDate")
     * @Groups({"fullActivity"})
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->entity->getStartDate();
    }

    /**
     * @param \DateTime $created
     *
     * @return Activity
     */
    public function setCreated($created)
    {
        $this->entity->setCreated($created);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("created")
     * @Groups({"fullActivity"})
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->entity->getCreated();
    }

    /**
     * @param \DateTime $changed
     *
     * @return Activity
     */
    public function setChanged($changed)
    {
        $this->entity->setChanged($changed);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("changed")
     * @Groups({"fullActivity"})
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->entity->getChanged();
    }

    /**
     * @param ActivityStatusEntity $activityStatus
     *
     * @return Activity
     */
    public function setActivityStatus(ActivityStatusEntity $activityStatus = null)
    {
        $this->entity->setActivityStatus($activityStatus);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("activityStatus")
     * @Groups({"fullActivity"})
     *
     * @return ActivityStatusEntity
     */
    public function getActivityStatus()
    {
        return $this->entity->getActivityStatus();
    }

    /**
     * @param ActivityPriorityEntity $activityPriority
     *
     * @return Activity
     */
    public function setActivityPriority(ActivityPriorityEntity $activityPriority = null)
    {
        $this->entity->setActivityPriority($activityPriority);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("activityPriority")
     * @Groups({"fullActivity"})
     *
     * @return ActivityPriorityEntity
     */
    public function getActivityPriority()
    {
        return $this->entity->getActivityPriority();
    }

    /**
     * @param ActivityTypeEntity $activityType
     *
     * @return Activity
     */
    public function setActivityType(ActivityTypeEntity $activityType = null)
    {
        $this->entity->setActivityType($activityType);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("activityType")
     * @Groups({"fullActivity"})
     *
     * @return ActivityTypeEntity
     */
    public function getActivityType()
    {
        return $this->entity->getActivityType();
    }

    /**
     * @param ContactInterface $contact
     *
     * @return Activity
     */
    public function setContact(ContactInterface $contact = null)
    {
        $this->entity->setContact($contact);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("contact")
     * @Groups({"fullActivity"})
     *
     * @return ContactInterface
     */
    public function getContact()
    {

        $contact = $this->entity->getContact();
        if ($contact) {
            return new Contact($contact, $this->locale);
        }

        return null;
    }

    /**
     * @param AccountInterface $account
     *
     * @return Activity
     */
    public function setAccount(AccountInterface $account = null)
    {
        $this->entity->setAccount($account);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("account")
     * @Groups({"fullActivity"})
     *
     * @return AccountInterface
     */
    public function getAccount()
    {
        $account = $this->entity->getAccount();
        if ($account) {
            return new Account($account, $this->locale);
        }

        return null;
    }

    /**
     * @param ContactInterface $assignedContact
     *
     * @return Activity
     */
    public function setAssignedContact(ContactInterface $assignedContact)
    {
        $this->entity->setAssignedContact($assignedContact);

        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("assignedContact")
     * @Groups({"fullActivity"})
     *
     * @return ContactInterface
     */
    public function getAssignedContact()
    {
        $contact = $this->entity->getAssignedContact();
        if ($contact) {
            return new Contact($contact, $this->locale);
        }

        return null;
    }
}
