<?php

namespace Web\EntityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EntityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
