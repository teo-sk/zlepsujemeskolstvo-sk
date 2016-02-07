<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Vote
 *
 * @ORM\Table(name="vote", uniqueConstraints={@ORM\UniqueConstraint(name="vote_idx", columns={"fingerprint", "suggestion_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 * @UniqueEntity(
 *     fields={"fingerprint", "suggestion"},
 *     message="Za tento podnet ste už hlasovali."
 * )
 */
class Vote
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
     * @ORM\ManyToOne(targetEntity="Suggestion", inversedBy="votes")
     * @ORM\JoinColumn(name="suggestion_id", referencedColumnName="id")
     */
    private $suggestion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="cookie", type="string", length=255)
     */
    private $cookie;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="fingerprint", type="string", length=255)
     */
    private $fingerprint;

    public function __construct()
    {
        $this->created = new \DateTime();
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Vote
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
     * Set ip
     *
     * @param string $ip
     *
     * @return Vote
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set fingerprint
     *
     * @param string $fingerprint
     *
     * @return Vote
     */
    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    /**
     * Get fingerprint
     *
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * Set suggestion
     *
     * @param \AppBundle\Entity\Suggestion $suggestion
     *
     * @return Vote
     */
    public function setSuggestion(\AppBundle\Entity\Suggestion $suggestion = null)
    {
        $this->suggestion = $suggestion;

        return $this;
    }

    /**
     * Get suggestion
     *
     * @return \AppBundle\Entity\Suggestion
     */
    public function getSuggestion()
    {
        return $this->suggestion;
    }

    /**
     * Set cookie
     *
     * @param string $cookie
     *
     * @return Vote
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    /**
     * Get cookie
     *
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }
}
