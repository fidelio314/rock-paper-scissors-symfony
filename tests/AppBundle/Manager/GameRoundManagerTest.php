<?php

namespace Tests\AppBundle\Manager;

use AppBundle\Manager\GameRoundManager;
use AppBundle\Model\Sign;
use AppBundle\Model\RoundResult;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Data\TestData;

class GameRoundManagerTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * @var TestData
     */
    private $testData;
    /**
     * @var GameRoundManager
     */
    private $gameRoundManager;
    /**
     * @var GameManager
     */
    private $gameManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->gameRoundManager = static::$kernel->getContainer()->get('game_round.manager');
        //init GAME
        $this->gameManager = static::$kernel->getContainer()->get('game.manager');
        $this->testData = new TestData($this->em);
        $this->testData->truncatePlayerHistory();
        $this->testData->createPlayerHistory();

    }

    /**
     * test the case when a game havent started yet
     */
    public function testPlayRoundNoGame()
    {
        $roundResult = $this->gameRoundManager->playRound('obi', new Sign(Sign::ROCK));
        $this->assertFalse($roundResult);
    }
    public function testPlayRoundExpertTiedResult()
    {
        $roundResult = $this->gameRoundManager->playRound('obi', new Sign(Sign::ROCK));
        $this->assertInstanceOf(RoundResult::class, $roundResult);
        $this->assertNull($roundResult->getWinner());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->testData->truncatePlayerHistory();
        $this->em->close();
    }
}
 