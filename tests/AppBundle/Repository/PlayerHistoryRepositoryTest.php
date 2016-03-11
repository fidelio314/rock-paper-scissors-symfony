<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Entity\PlayerHistory;
use AppBundle\Model\Sign;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Data\TestData;



class PlayerHistoryRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $testData = new TestData($this->em);
        $testData->truncatePlayerHistory();
        $testData->createPlayerHistory();
    }

    public function testFindPlayerHistoryByUsername()
    {
        $history = $this->em->getRepository('AppBundle:PlayerHistory')->findPlayerHistoryList('obi');
        $this->assertCount(8, $history);
        $this->assertEquals($history[0], Sign::ROCK);
    }


    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $testData = new TestData($this->em);
        $testData->truncatePlayerHistory();
        $this->em->close();
    }

}
 