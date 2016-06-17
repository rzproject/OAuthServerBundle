<?php

namespace Rz\OAuthServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Rz\OAuthServerBundle\DependencyInjection\RzOAuthServerExtension;

class RzOAuthServerBundle extends Bundle
{

    public function __construct()
    {
        $this->extension = new RzOAuthServerExtension();
    }
}
