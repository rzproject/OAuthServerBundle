<?php

namespace Rz\OAuthServerBundle\Entity;

use Rz\OAuthServerBundle\Model\AccessToken;

abstract class BaseAccessToken extends AccessToken
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

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getClient() ?  '['.$this->getClient().'] '.$this->getToken(): '-';
    }
}
