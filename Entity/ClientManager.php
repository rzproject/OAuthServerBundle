<?php

namespace Rz\OAuthServerBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;
use FOS\OAuthServerBundle\Model\ClientInterface;

class ClientManager extends BaseEntityManager
{
    /**
     * {@inheritdoc}
     */
    public function findClientBy(array $criteria)
    {
        return $this->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function updateClient(ClientInterface $client)
    {
        $this->em->persist($client);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteClient(ClientInterface $client)
    {
        $this->delete($client)
    }

    /**
     * {@inheritdoc}
     */
    public function findClientByPublicId($publicId)
    {
        if (false === $pos = strpos($publicId, '_')) {
            return;
        }

        $id = substr($publicId, 0, $pos);
        $randomId = substr($publicId, $pos + 1);

        return $this->findClientBy(array(
            'id'       => $id,
            'randomId' => $randomId,
        ));
    }
}
