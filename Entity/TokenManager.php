<?php

namespace Rz\OAuthServerBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;
use FOS\OAuthServerBundle\Model\TokenInterface;

class TokenManager extends BaseEntityManager
{
    /**
     * {@inheritdoc}
     */
    public function findTokenBy(array $criteria)
    {
        return  $this->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function updateToken(TokenInterface $token)
    {
        $this->em->persist($token);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteToken(TokenInterface $token)
    {
        $this->em->remove($token);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteExpired()
    {
        $qb =  $this->getRepository()->createQueryBuilder('t');
        $qb
            ->delete()
            ->where('t.expiresAt < ?1')
            ->setParameters(array(1 => time()));

        return $qb->getQuery()->execute();
    }
}
