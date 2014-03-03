<?php

namespace Neralind\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResourceVideo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Neralind\ResourceBundle\Entity\ResourceVideoRepository")
 */
class ResourceVideo
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
     * @ORM\Column(name="quality", type="string", length=50)
     */
    private $quality;


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
     * Set quality
     *
     * @param string $quality
     * @return ResourceVideo
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return string 
     */
    public function getQuality()
    {
        return $this->quality;
    }
}
