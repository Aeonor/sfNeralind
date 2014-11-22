<?php

namespace Neralind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Neralind\MediaBundle\Entity\TypeRepository")
 */
class Type
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Extension", mappedBy="type")
     */
    private $extensions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->extensions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Type
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
     * Add extensions
     *
     * @param \Neralind\MediaBundle\Entity\Extension $extensions
     * @return Type
     */
    public function addExtension(\Neralind\MediaBundle\Entity\Extension $extensions)
    {
        $this->extensions[] = $extensions;

        return $this;
    }

    /**
     * Remove extensions
     *
     * @param \Neralind\MediaBundle\Entity\Extension $extensions
     */
    public function removeExtension(\Neralind\MediaBundle\Entity\Extension $extensions)
    {
        $this->extensions->removeElement($extensions);
    }

    /**
     * Get extensions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}
