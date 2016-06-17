<?php

namespace Rz\OAuthServerBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;
use FOS\OAuthServerBundle\Model\AuthCodeInterface;

class AuthCodeManager extends BaseEntityManager
{
    /**
     * {@inheritdoc}
     */
    public function findAuthCodeBy(array $criteria)
    {
        return $this->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function updateAuthCode(AuthCodeInterface $authCode)
    {
        $this->em->persist($authCode);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAuthCode(AuthCodeInterface $authCode)
    {
        $this->delete($authCode);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteExpired()
    {
        $qb = $this->em->getRepository()->createQueryBuilder('a');
        $qb
            ->delete()
            ->where('a.expiresAt < ?1')
            ->setParameters(array(1 => time()));

        return $qb->getQuery()->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function createAuthCode()
    {
        $class = $this->create();

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthCodeByToken($token)
    {
        return $this->findAuthCodeBy(array('token' => $token));
    }
}
