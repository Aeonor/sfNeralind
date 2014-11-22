<?php

namespace Neralind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extension
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Neralind\MediaBundle\Entity\ExtensionRepository")
 */
class Extension
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
     * @ORM\Column(name="name", type="string", length=5)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="extensions")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private $type;


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
     * @return Extension
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
     * Set type
     *
     * @param \Neralind\MediaBundle\Entity\Type $type
     * @return Extension
     */
    public function setType(\Neralind\MediaBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Neralind\MediaBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }
}
