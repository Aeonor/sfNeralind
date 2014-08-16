<?php

namespace Neralind\TagBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Neralind\TagBundle\Validator\Constraints as NeralindTagAsserts;

/**
 * Word
 *
 * @ORM\Table(name="tag_word",indexes={@ORM\index(name="word_idx", columns={"slug"})})
 * @ORM\Entity
 */
class Word {

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=50, unique=true)
   * @Assert\Length(
   *      min = "3",
   *      max = "50",
   *      maxMessage = "word.error.length.max",
   *      minMessage = "word.error.length.max"
   * )
   * @Assert\Regex("/^([a-zA-Z0-9_-]+)/")
   * @Assert\NotBlank()
   */
  private $name;

  /**
   * @var string
   *
   * @Gedmo\Slug(fields={"name"})
   * @ORM\Column(name="slug", length=128, unique=true)
   */
  private $slug;

  /**
   * @ORM\OneToOne(targetEntity="Tag", inversedBy="principalWord", fetch="EAGER", cascade={"persist", "remove"})
   * @ORM\JoinColumn(name="tag_principal_id", referencedColumnName="id", nullable=true)
   * @NeralindTagAsserts\NoRelationWord()
   */
  private $principalTag;

  /**
   * @ORM\ManyToOne(targetEntity="Tag", inversedBy="redirectionWords", fetch="EAGER")
   * @ORM\JoinColumn(name="tag_redirected_id", referencedColumnName="id", nullable=true)
   */
  private $redirectedTag;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   * @return Word
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string 
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set slug
   *
   * @param string $slug
   * @return Word
   */
  public function setSlug($slug) {
    $this->slug = $slug;

    return $this;
  }

  /**
   * Get slug
   *
   * @return string 
   */
  public function getSlug() {
    return $this->slug;
  }

  /**
   * Set principalTag
   *
   * @param \Neralind\TagBundle\Entity\Tag $principalTag
   * @return Word
   * @NeralindTagAsserts\NoRelationWord(message = "word.error.norelation")
   */
  public function setPrincipalTag(\Neralind\TagBundle\Entity\Tag $principalTag = null) { 
    $this->principalTag = $principalTag;
    return $this;
  }

  /**
   * Get principalTag
   *
   * @return \Neralind\TagBundle\Entity\Tag 
   */
  public function getPrincipalTag() {
    return $this->principalTag;
  }

  /**
   * Set redirectedTag
   *
   * @param \Neralind\TagBundle\Entity\Tag $redirectedTag
   * @return Word
   * @NeralindTagAsserts\NoRelationWord(message = "word.error.norelation")
   */
  public function setRedirectedTag(\Neralind\TagBundle\Entity\Tag $redirectedTag = null) {
    $this->redirectedTag = $redirectedTag;

    return $this;
  }

  /**
   * Get redirectedTag
   *
   * @return \Neralind\TagBundle\Entity\Tag  
  */
  public function getRedirectedTag() {
    return $this->redirectedTag;
  }
  
  /**
   * Get principalTag or redirectedTag
   */
  public function getTag() {
      if ( $this->principalTag != null ) return $this->getPrincipalTag();
      else return $this->getRedirectedTag();
  }
  
 
  public function __toString() {
      return $this->name;
  }

}
