<?php

namespace Rz\OAuthServerBundle\Entity;

use Rz\OAuthServerBundle\Model\AuthCode;

abstract class BaseAuthCode extends AuthCode
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
