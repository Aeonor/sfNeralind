<?php

namespace Neralind\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Neralind\TicketBundle\Entity\TicketRepository")
 */
class Ticket
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
     * @var datetime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="contents", type="text")
     */
    private $contents;


    /**
     * @ORM\ManyToOne(targetEntity="Neralind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", nullable=false)
     */
    private $creator;


    /**
     * @ORM\ManyToOne(targetEntity="Neralind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="worker_id", referencedColumnName="id", nullable=true)
     */
    private $worker;

    /**
     * @ORM\ManyToOne(targetEntity="Lot", inversedBy="tickets")
     * @ORM\JoinColumn(name="lot_id", referencedColumnName="id", nullable=false)
     */
    private $lot;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="tickets")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="tickets")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    private $status;


    /**
     * @ORM\OneToMany(targetEntity="Talk", mappedBy="ticket")
     */
    private $talks;


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
     * @return Ticket
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
     * Set contents
     *
     * @param string $contents
     * @return Ticket
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get contents
     *
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->talks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lot
     *
     * @param \Neralind\TicketBundle\Entity\Lot $lot
     * @return Ticket
     */
    public function setLot(\Neralind\TicketBundle\Entity\Lot $lot = null)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get lot
     *
     * @return \Neralind\TicketBundle\Entity\Lot
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set type
     *
     * @param \Neralind\TicketBundle\Entity\Type $type
     * @return Ticket
     */
    public function setType(\Neralind\TicketBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Neralind\TicketBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param \Neralind\TicketBundle\Entity\Status $status
     * @return Ticket
     */
    public function setStatus(\Neralind\TicketBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Neralind\TicketBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add talks
     *
     * @param \Neralind\TicketBundle\Entity\Talk $talks
     * @return Ticket
     */
    public function addTalk(\Neralind\TicketBundle\Entity\Talk $talks)
    {
        $this->talks[] = $talks;

        return $this;
    }

    /**
     * Remove talks
     *
     * @param \Neralind\TicketBundle\Entity\Talk $talks
     */
    public function removeTalk(\Neralind\TicketBundle\Entity\Talk $talks)
    {
        $this->talks->removeElement($talks);
    }

    /**
     * Get talks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTalks()
    {
        return $this->talks;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Ticket
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set creator
     *
     * @param \Neralind\UserBundle\Entity\User $creator
     * @return Ticket
     */
    public function setCreator(\Neralind\UserBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \Neralind\UserBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set worker
     *
     * @param \Neralind\UserBundle\Entity\User $worker
     * @return Ticket
     */
    public function setWorker(\Neralind\UserBundle\Entity\User $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker
     *
     * @return \Neralind\UserBundle\Entity\User
     */
    public function getWorker()
    {
        return $this->worker;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Ticket
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Ticket
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
