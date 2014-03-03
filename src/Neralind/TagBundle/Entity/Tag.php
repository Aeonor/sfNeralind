<?php

namespace Neralind\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Neralind\TagBundle\Entity\TagRepository")
 */
class Tag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer",options={"unsigned"=true})
     */
    private $weight;

    /**
     * @var integer
     *
     * @ORM\Column(name="initial_weight", type="smallint",options={"unsigned"=true})
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "tag.error.weight.min",
     *      maxMessage = "tag.error.weight.max"
     * )
     */
    private $initialWeight;

    /**
     * @var text
     *
     * @ORM\Column(name="caption", type="text", length=255)
     */
    private $caption;

    /**
    * @ORM\OneToOne(targetEntity="Word", inversedBy="principalTag", fetch="EAGER")
    * @ORM\JoinColumn(name="word_id", referencedColumnName="id", nullable=true)
    */
    private $principalWord;
    
    /**
    * @ORM\OneToMany(targetEntity="Word", mappedBy="redirectedTag")
    */
    private $redirectionWords;
 
    
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
     * Set weight
     *
     * @param integer $weight
     * @return Tag
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set initialWeight
     *
     * @param integer $initialWeight
     * @return Tag
     */
    public function setInitialWeight($initialWeight)
    {
        $this->initialWeight = $initialWeight;

        return $this;
    }

    /**
     * Get initialWeight
     *
     * @return integer 
     */
    public function getInitialWeight()
    {
        return $this->initialWeight;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return Tag
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->redirectionWords = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set principalWord
     *
     * @param \Neralind\TagBundle\Entity\Word $principalWord
     * @return Tag
     */
    public function setPrincipalWord(\Neralind\TagBundle\Entity\Word $principalWord = null)
    {
        $this->principalWord = $principalWord;

        return $this;
    }

    /**
     * Get principalWord
     *
     * @return \Neralind\TagBundle\Entity\Word 
     */
    public function getPrincipalWord()
    {
        return $this->principalWord;
    }

    /**
     * Add redirectionWords
     *
     * @param \Neralind\TagBundle\Entity\Word $redirectionWords
     * @return Tag
     */
    public function addRedirectionWord(\Neralind\TagBundle\Entity\Word $redirectionWords)
    {
        $this->redirectionWords[] = $redirectionWords;

        return $this;
    }

    /**
     * Remove redirectionWords
     *
     * @param \Neralind\TagBundle\Entity\Word $redirectionWords
     */
    public function removeRedirectionWord(\Neralind\TagBundle\Entity\Word $redirectionWords)
    {
        $this->redirectionWords->removeElement($redirectionWords);
    }

    /**
     * Get redirectionWords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRedirectionWords()
    {
        return $this->redirectionWords;
    }
}
