<?php

namespace Neralind\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag
 *
 * @ORM\Table()
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
     * @var string
     *
     * @ORM\Column(name="caption", type="text", length=255)
     */
    private $caption;

    /**
    * @OneToOne(targetEntity="Word", inversedBy="principalTag")
    * @JoinColumn(name="word_id", referencedColumnName="id")
    */
    private $principalWord;
    
    /**
    * @OneToMany(targetEntity="Word", 
    *           mappedBy="tag", 
    *           cascade={"persist", "remove", "merge"}, 
    *           orphanRemoval=true, 
    *           nullable=true)
    */
    public $words;
    
    /**
    * @ManyToOne(targetEntity="Cart", cascade={"all"}, fetch="EAGER")
    */
    private $cart;
    
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
}
