<?php

namespace Rz\OAuthServerBundle\Entity;

use Rz\OAuthServerBundle\Model\RefreshToken;

abstract class BaseRefreshToken extends RefreshToken
{
    /**
     * Pre Persist method
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Pre Update method
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
