<?php

namespace Neralind\TagBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of NoRelation
 *
 * @author aurelienmagne
 * @Annotation
 */
class NoRelationWord extends Constraint{
    public $message = 'tag.error.norelationword';
    
    public function validatedBy()
    {
        return 'NoRelationWordValidator';
    }

}
