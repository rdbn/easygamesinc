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

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WikiRepository")
 * @ORM\Table(name="wiki")
 */
class Wiki
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", options={"DEFAULT": 0})
     */
    private $parent = 0;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $weight = 0;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="wiki")
     */
    private $comments;

    /**
     * Wiki constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return Wiki
     */
    public function setParent($parent): Wiki
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Wiki
     */
    public function setTitle($title): Wiki
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Wiki
     */
    public function setText($text): Wiki
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Wiki
     */
    public function setCreatedAt(\DateTime $createdAt): Wiki
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Comment[]|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comments
     * @return Wiki
     */
    public function addComments(Comment $comments): Wiki
    {
        if (!$this->comments->contains($comments)) {
            $this->comments->add($comments);
        }

        return $this;
    }

    /**
     * @param Comment $comments
     * @return Wiki
     */
    public function removeComments($comments): Wiki
    {
        if ($this->comments->contains($comments)) {
            $this->comments->remove($comments);
        }

        return $this;
    }
}