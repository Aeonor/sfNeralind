<?php

namespace Neralind\TicketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TicketType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Titre du ticket'))
            ->add('url', 'url', array('label' => 'URL de la page incriminée', 'required' => false))
            ->add('contents', 'textarea', array('label' => 'Objet du ticket'))
            ->add('lot', 'entity', array('class' => 'NeralindTicketBundle:Lot', 'expanded' => true))
            ->add('type', 'entity', array('class' => 'NeralindTicketBundle:Type', 'expanded' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Neralind\TicketBundle\Entity\Ticket'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'neralind_ticketbundle_ticket';
    }
}
