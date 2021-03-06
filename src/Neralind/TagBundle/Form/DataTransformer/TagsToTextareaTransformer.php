<?php

namespace Neralind\TagBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Neralind\TagBundle\Entity\Word;

class TagsToTextareaTransformer implements DataTransformerInterface {

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    /**
     * Transforms an object (list of tags) to a string (textarea).
     *
     * @param  Tags|null $tags
     * @return string
     */
    public function transform($tags) {
        if (null === $tags || empty($tags)) {
            return "";
        }

        $texts = array();
        if (is_array($tags)) {
            foreach ($tags AS $tag) {
                $texts[] = $tag->getName();
            }
        }

        return implode(', ', $texts);
    }

    /**
     * Transforms a string (textarea) to a list of objects (words).
     *
     * @param  string $textarea
     * @return Words|null
     * @throws TransformationFailedException if object (words) is not found.
     */
    public function reverseTransform($textarea) { 
        if (!$textarea) {
            return new \Doctrine\Common\Collections\ArrayCollection();
        }

        // EXPLODE
        $textarea = str_replace(';', ',', $textarea);
        $texts = explode(',', $textarea);

        $tags = array();
        foreach ($texts AS $text) {
            $text = trim($text);
            if (!empty($text)) {
                $word = $this->om
                        ->getRepository('NeralindTagBundle:Word')
                        ->findOneBy(array('name' => $text));

                if (null === $word || null === $word->getPrincipalTag()) {
                    throw new TransformationFailedException(sprintf(
                            'Le tag %s ne peut pas être trouvé', $text
                    ));
                }
                $tags[] = $word->getTag();
            }
        }

        return new \Doctrine\Common\Collections\ArrayCollection($tags);
    }

}