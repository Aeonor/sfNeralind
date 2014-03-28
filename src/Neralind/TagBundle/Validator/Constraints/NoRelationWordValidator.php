<?php

namespace Neralind\TagBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Neralind\TagBundle\Entity\Word;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

class NoRelationWordValidator extends ConstraintValidator {

    protected $em;

    public function __construct($em) {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint) {
        if (isset($value)) {
            $words = ( $value instanceOf ArrayCollection ) ? $value : new ArrayCollection(array($value));
            $inRelationShip = array();

            foreach ($words as $word) {
                if ($word->getPrincipalTag() != null && $word->getRedirectedTag() != null) {
                    $inRelationShip[] = $word->getName();
                } else {
                    $word = $this->em->getRepository('NeralindTagBundle:Word')->findOneByName($word->getName());
                    if (isset($word) &&
                            ( $word->getPrincipalTag() != null ||
                            $word->getRedirectedTag() != null
                            )
                    ) {
                        $inRelationShip[] = $word->getName();
                    }
                }
            }

            if (!empty($inRelationShip))
                $this->context->addViolation($constraint->message, array('%word%' => implode(',', $inRelationShip), '%nb%' => sizeof($inRelationShip)));
        }
    }

}
