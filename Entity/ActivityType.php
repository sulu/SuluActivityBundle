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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation\Exclude;
use Sulu\Bundle\CoreBundle\Entity\ApiEntity;
use JMS\Serializer\Annotation\Groups;

/**
 * ActivityType
 */
class ActivityType extends ApiEntity implements \JsonSerializable
{
    /**
     * @var string
     * @Groups({"fullActivity"})
     */
    private $name;

    /**
     * @var integer
     * @Groups({"fullActivity"})
     */
    private $id;

    /**
     * @var Collection
     * @Exclude
     */
    private $activities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ActivityType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Add activities
     *
     * @param Activity $activities
     * @return ActivityType
     */
    public function addActivitie(Activity $activities)
    {
        $this->activities[] = $activities;

        return $this;
    }

    /**
     * Remove activities
     *
     * @param Activity $activities
     */
    public function removeActivitie(Activity $activities)
    {
        $this->activities->removeElement($activities);
    }

    /**
     * Get activities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName()
        );
    }

    /**
     * Add activities
     *
     * @param Activity $activities
     * @return ActivityType
     */
    public function addActivity(Activity $activities)
    {
        $this->activities[] = $activities;

        return $this;
    }

    /**
     * Remove activities
     *
     * @param Activity $activities
     */
    public function removeActivity(Activity $activities)
    {
        $this->activities->removeElement($activities);
    }
}
