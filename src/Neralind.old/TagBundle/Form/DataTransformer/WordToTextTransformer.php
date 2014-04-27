<?php
namespace Neralind\TagBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Neralind\TagBundle\Entity\Word;

class WordToTextTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($word)
    {
        if (null === $word) {
            return "";
        }

        return $word->getName();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $text
     * @return Word|null
     * @throws TransformationFailedException if object (word) is not found.
     */
    public function reverseTransform($text)
    {
        if (!$text) {
            return null;
        }

        $word = $this->om
            ->getRepository('NeralindTagBundle:Word')
            ->findOneBy(array('name' => $text))
        ;

        if (null === $word) {
            $word = new Word();
            $word->setName($text);
         /*   throw new TransformationFailedException(sprintf(
                'Le problème avec le terme "%s" ne peut pas être trouvé!',
                $text
            )); */
        }

        return $word;
    }
}