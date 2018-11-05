<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 04.09.2018
 * Time: 21:40
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(fields={"name"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", options={"DEFAULT": 0})
     */
    private $groupId = 0;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var ArrayCollection|Wiki[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Wiki", mappedBy="category")
     */
    private $wiki;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->wiki = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name): Category
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param string $groupId
     * @return Category
     */
    public function setGroupId($groupId): Category
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return Category
     */
    public function setCreatedAt($createdAt): Category
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Wiki[]|ArrayCollection
     */
    public function getWiki()
    {
        return $this->wiki;
    }

    /**
     * @param Wiki $wiki
     * @return Category
     */
    public function addWiki(Wiki $wiki): Category
    {
        if (!$this->wiki->contains($wiki)) {
            $this->wiki->add($wiki);
        }

        return $this;
    }

    /**
     * @param Wiki $wiki
     * @return Category
     */
    public function removeWiki(Wiki $wiki): Category
    {
        if ($this->wiki->contains($wiki)) {
            $this->wiki->remove($wiki);
        }

        return $this;
    }
}