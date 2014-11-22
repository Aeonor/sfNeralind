<?php

namespace Neralind\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Talk
 *
 * @ORM\Table(name="ticket_talk")
 * @ORM\Entity(repositoryClass="Neralind\TicketBundle\Entity\TalkRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Talk
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
     * @ORM\Column(name="contents", type="text")
     */
    private $contents;


    /**
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="talks")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $ticket;

    
    /**
     * @ORM\ManyToOne(targetEntity="Neralind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", nullable=false)
     */
    private $creator;



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
     * Set contents
     *
     * @param string $contents
     * @return Talk
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
     * Set tickets
     *
     * @param \Neralind\TicketBundle\Entity\Ticket $tickets
     * @return Talk
     */
    public function setTicket(\Neralind\TicketBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get tickets
     *
     * @return \Neralind\TicketBundle\Entity\Ticket 
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set creator
     *
     * @param \Neralind\UserBundle\Entity\User $creator
     * @return Talk
     */
    public function setCreator(\Neralind\UserBundle\Entity\User $creator)
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
     * @ORM\PrePersist 
     */
    public function updateTicketUpdatedAtOnPrePersist()
    {
        $this->getTicket()->setUpdatedAt(new \DateTime());
    }
}
