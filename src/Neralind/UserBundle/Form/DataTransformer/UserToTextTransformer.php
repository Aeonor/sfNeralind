<?php
namespace Neralind\UserBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Neralind\TagBundle\Entity\Word;

class UserToTextTransformer implements DataTransformerInterface
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
     * Transforms an object (user) to a string (username).
     *
     * @param  User|null $issue
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return "";
        }

        return $user->getUsername();
    }

    /**
     * Transforms a string to an object (user).
     *
     * @param  string $username
     * @return User|null
     * @throws TransformationFailedException if object (user) is not found.
     */
    public function reverseTransform($username)
    {
        if (!$username) {
            return null;
        }

        $user = $this->om
            ->getRepository('NeralindUserBundle:User')
            ->findOneBy(array('username' => $username))
        ;

        if (null === $user) {
             throw new TransformationFailedException(sprintf(
                'Le user "%s" ne peut pas être trouvé',
                $username
            ));    
        }

        return $user;
    }
}