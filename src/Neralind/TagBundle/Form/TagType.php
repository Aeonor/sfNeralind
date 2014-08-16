<?php

namespace Neralind\TagBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType {

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
            ->add('principalWord', 'word_selector')
            ->add('caption')
            ->add('initialWeight')
            ->add('redirectionWords', 'words_selector', array('by_reference' => false, 'required' => false))
            ->add('linkedTags', 'tags_selector', array('by_reference' => false, 'required' => false))
    ;
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'Neralind\TagBundle\Entity\Tag'
    ));
  }

  /**
   * @return string
   */
  public function getName() {
    return 'neralind_tagbundle_tag';
  }

}
