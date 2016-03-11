<?php

namespace AppBundle\Repository;

/**
 * PlayerHistoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerHistoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function findPlayerHistoryList($username)
    {
        $result =  $this->getEntityManager()
            ->createQuery(
                'SELECT ph.sign FROM AppBundle:PlayerHistory ph WHERE ph.username = :username'
            )
            ->setParameter('username', $username)
            ->getScalarResult();

        return array_column($result, 'sign');
    }
}