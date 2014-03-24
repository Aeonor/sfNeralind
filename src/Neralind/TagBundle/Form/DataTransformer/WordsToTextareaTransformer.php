<?php

namespace Neralind\TagBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Neralind\TagBundle\Entity\Word;

class WordsToTextareaTransformer implements DataTransformerInterface {

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
     * Transforms an object (list of word) to a string (textarea).
     *
     * @param  Words|null $words
     * @return string
     */
    public function transform($words) {
        if (null === $words || empty($words)) {
            return "";
        }

        $texts = array();
        if (is_array($words)) {
            foreach ($words AS $word) {
                $texts[] = $word->getName();
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
            return null;
        }

        // EXPLODE
        $textarea = str_replace(';', ',', $textarea);
        $texts = explode(',', $textarea);

        $words = array();
        foreach ($texts AS $text) {
            $text = trim($text);
            if (!empty($text)) {
                $word = $this->om
                        ->getRepository('NeralindTagBundle:Word')
                        ->findOneBy(array('name' => $text));

                if (null === $word) {
                    $word = new Word();
                    $word->setName($text);
                }
                $words[] = $word;
            }
        }

        return new \Doctrine\Common\Collections\ArrayCollection($words);
    }

}