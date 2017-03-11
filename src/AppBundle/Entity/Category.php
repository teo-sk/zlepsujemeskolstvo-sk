<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Criteria;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Suggestion", mappedBy="category")
     */
    private $suggestions;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    public function __construct()
    {
        $this->suggestions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add suggestion
     *
     * @param \AppBundle\Entity\Suggestion $suggestion
     *
     * @return Category
     */
    public function addSuggestion(\AppBundle\Entity\Suggestion $suggestion)
    {
        $this->suggestions[] = $suggestion;

        return $this;
    }

    /**
     * Remove suggestion
     *
     * @param \AppBundle\Entity\Suggestion $suggestion
     */
    public function removeSuggestion(\AppBundle\Entity\Suggestion $suggestion)
    {
        $this->suggestions->removeElement($suggestion);
    }

    /**
     * Get suggestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }

    public function getAllSuggestions()
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('approved', true))
                 ->orderBy(array("created" => Criteria::DESC));

        return $this->suggestions->matching($criteria);
    }

    public function getNewestSuggestions()
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('approved', true))
                 ->orderBy(array("created" => Criteria::DESC))
                 ->setMaxResults(4);

        return $this->suggestions->matching($criteria);
    }

    public function getPopularSuggestions()
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('approved', true));

        $suggestions = $this->suggestions->matching($criteria)->toArray();

        usort($suggestions, function($a, $b) {
            return count($b->getVotes()) - count($a->getVotes());
        });

        return $suggestions;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }
    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
