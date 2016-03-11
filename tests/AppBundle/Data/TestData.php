<?php

namespace Tests\AppBundle\Data;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\PlayerHistory;
use AppBundle\Model\Sign;

/**
 * Class TestData
 */
class TestData
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getTestSignSequence()
    {
        return [
                Sign::ROCK,
                Sign::SCISSORS,
                Sign::SCISSORS,
                Sign::ROCK,
                Sign::PAPER,
                Sign::ROCK,
                Sign::SCISSORS,
                Sign::SCISSORS,
            ];
    }

    /**
     * createPlayerHistory
     */
    public function createPlayerHistory($username = 'obi')
    {
        $signSequence = $this->getTestSignSequence();
        foreach ( $signSequence as $sign) {
            //create History of player
            $playerHistory = new PlayerHistory();
            $playerHistory
                ->setUsername($username)
                ->setSign($sign);
            $this->em->persist($playerHistory);
        }
        $this->em->flush();
    }

    /**
     * truncate player History
     */
    public function truncatePlayerHistory()
    {
        $this->em->createQuery('DELETE FROM AppBundle:PlayerHistory')->execute();
    }
}
