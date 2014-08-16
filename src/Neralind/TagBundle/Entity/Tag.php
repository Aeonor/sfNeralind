<?php

namespace Neralind\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Neralind\TagBundle\Validator\Constraints as NeralindTagAsserts;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Neralind\TagBundle\Entity\TagRepository")
 */
class Tag {

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
   * @ORM\Column(name="weight", type="integer",options={"unsigned"=true, "default"=0})
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
   * @Assert\NotBlank()
   */
  private $initialWeight;

  /**
   * @var text
   *
   * @ORM\Column(name="caption", type="text", length=255)
   * @Assert\NotBlank()
   */
  private $caption;



//  /**
//   * @ORM\ManyToOne(targetEntity="Neralind\ResourceBundle\Entity\ResourceImage")
//   * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
//   */
//  private $picture;

  /**
   * @ORM\OneToOne(targetEntity="Word", mappedBy="principalTag", fetch="EAGER", cascade={"persist"})
   */
  private $principalWord;

  /**
   * @ORM\OneToMany(targetEntity="Word", mappedBy="redirectedTag", cascade={"persist"})
   * @NeralindTagAsserts\NoRelationWord()
   */
  private $redirectionWords;

  /**
   * @ORM\ManyToMany(targetEntity="Tag", mappedBy="tagsLinked")
   * */
  private $linkedTags;

  /**
   * @ORM\ManyToMany(targetEntity="Tag", inversedBy="linkedTags")
   * @ORM\JoinTable(name="tag_linked",
   *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="linkedtag_id", referencedColumnName="id")}
   *      )
   * */
  private $tagsLinked;

  /**
   * Constructor
   */
  public function __construct() {
    $this->redirectionWords = new \Doctrine\Common\Collections\ArrayCollection();
    $this->linkedTags = new \Doctrine\Common\Collections\ArrayCollection();
    $this->tagsLinked = new \Doctrine\Common\Collections\ArrayCollection();
    $this->weight = 0;
  }

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set weight
   *
   * @param integer $weight
   * @return Tag
   */
  public function setWeight($weight) {
    $this->weight = $weight;

    return $this;
  }

  /**
   * Get weight
   *
   * @return integer 
   */
  public function getWeight() {
    return $this->weight;
  }

  /**
   * Set initialWeight
   *
   * @param integer $initialWeight
   * @return Tag
   */
  public function setInitialWeight($initialWeight) {
    $this->initialWeight = $initialWeight;

    return $this;
  }

  /**
   * Get initialWeight
   *
   * @return integer 
   */
  public function getInitialWeight() {
    return $this->initialWeight;
  }

  /**
   * Set caption
   *
   * @param string $caption
   * @return Tag
   */
  public function setCaption($caption) {
    $this->caption = $caption;

    return $this;
  }

  /**
   * Get caption
   *
   * @return string 
   */
  public function getCaption() {
    return $this->caption;
  }

  /**
   * Set principalWord
   *
   * @param \Neralind\TagBundle\Entity\Word $principalWord
   * @return Tag
   */
  public function setPrincipalWord(\Neralind\TagBundle\Entity\Word $principalWord = null) {
    $principalWord->setPrincipalTag($this);
    $this->principalWord = $principalWord;
    return $this;
  }

  /**
   * Get principalWord
   *
   * @return \Neralind\TagBundle\Entity\Word 
   */
  public function getPrincipalWord() {
    return $this->principalWord;
  }

  /**
   * Add redirectionWords
   *
   * @param \Neralind\TagBundle\Entity\Word $redirectionWords
   * @return Tag
   */
  public function addRedirectionWord(\Neralind\TagBundle\Entity\Word $redirectionWords) {
    $redirectionWords->setRedirectedTag($this); // Owning side
    $this->redirectionWords[] = $redirectionWords;

    return $this;
  }

  /**
   * Remove redirectionWords
   *
   * @param \Neralind\TagBundle\Entity\Word $redirectionWords
   */
  public function removeRedirectionWord(\Neralind\TagBundle\Entity\Word $redirectionWords) {
    $this->redirectionWords->removeElement($redirectionWords);
  }

  /**
   * Set redirectionWords
   * @return Tag
   */
  public function setRedirectionWords(\Doctrine\Common\Collections\Collection $redirectionWords) {

    foreach ($redirectionWords as $redirectionWord) {
      $this->setRedirectedTag($this); // Owning side
    }

    $this->redirectionWords = $redirectionWords;
    return $this;
  }

  /**
   * Get redirectionWords
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getRedirectionWords() {
    return $this->redirectionWords;
  }

  /**
   * Add linkedTags
   *
   * @param \Neralind\TagBundle\Entity\Tag $linkedTags
   * @return Tag
   */
  public function addLinkedTag(\Neralind\TagBundle\Entity\Tag $linkedTags) {
    if (!$this->linkedTags->contains($linkedTags) && !$this->tagsLinked->contains($linkedTags)) {
      $this->linkedTags[] = $linkedTags;
    }

    return $this;
  }

  /**
   * Remove linkedTags
   *
   * @param \Neralind\TagBundle\Entity\Tag $linkedTags
   */
  public function removeLinkedTag(\Neralind\TagBundle\Entity\Tag $linkedTags) {
    $this->linkedTags->removeElement($linkedTags);
    $this->tagsLinked->removeElement($linkedTags);
  }

  /**
   * Get linkedTags
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getLinkedTags() {
    $join = array_merge($this->linkedTags->toArray(), $this->tagsLinked->toArray());
    return new \Doctrine\Common\Collections\ArrayCollection($join);
  }

  // Principal Word Shorcuts 
  public function getName() {
    if ( !$this->getPrincipalWord() ) return;
    return $this->getPrincipalWord()->getName();
  }

  public function getSlug() {
    if ( !$this->getPrincipalWord() ) return;
    return $this->getPrincipalWord()->getSlug();
  }

  public function __toString() {
    return $this->getName();
  }

}
