<?php

namespace Neralind\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NeralindUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
