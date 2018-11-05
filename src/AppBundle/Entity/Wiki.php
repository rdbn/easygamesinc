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
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="wiki")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $text;

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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Wiki
     */
    public function setCategory(Category $category): Wiki
    {
        $this->category = $category;

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