<?php

namespace Tests\AppBundle\Manager;

use AppBundle\Manager\GameRoundManager;
use AppBundle\Model\Sign;
use AppBundle\Model\RoundResult;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Data\TestData;
use AppBundle\Model\Game;
use AppBundle\Model\RoundPlay;
use AppBundle\Model\Player;

class GameRoundManagerTest extends KernelTestCase {

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
    protected function setUp() {
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
    public function testPlayRoundNoGame() {
        $roundResult = $this->gameRoundManager->playRound('game_testNOGAME', new Sign(Sign::ROCK));
        $this->assertFalse($roundResult);
    }

    public function testPlayRoundEasy() {
        //start a game
        $gameIdentifier = $this->gameManager->startHumanGame('obi-easy');
        //add some game round history
        $this->testData->createPlayerHistory('obi-easy');
        $roundResult = $this->gameRoundManager->playRound($gameIdentifier, new Sign(Sign::ROCK));
        $this->assertInstanceOf(RoundResult::class, $roundResult);
        $this->assertTrue(is_array($roundResult->getRoundData()));
        $this->assertEquals(Sign::ROCK, $roundResult->getSignByUsername('obi-easy'));
    }

    public function testPlayRoundExpert() {
        //start a game
        $gameIdentifier = $this->gameManager->startHumanGame('obi-expert', Game::MODE_EXPERT);
        //add some game round history
        $this->testData->createPlayerHistory('obi-expert');
        $roundResult = $this->gameRoundManager->playRound($gameIdentifier, new Sign(Sign::ROCK));
        $this->assertInstanceOf(RoundResult::class, $roundResult);
        $this->assertTrue(is_array($roundResult->getRoundData()));
        $this->assertEquals(Sign::ROCK, $roundResult->getSignByUsername('obi-expert'));
        $this->assertFalse($roundResult->isWinner('obi-expert'));
    }

    public function testGetWinner() {
        $playerHuman = new Player('obi');
        $signHuman = new Sign(Sign::PAPER);
        $playerAi = new Player('ai');
        $signAi = new Sign(Sign::ROCK);
        //set rounds play
        $humanRound = new RoundPlay($playerHuman, $signHuman);
        $aiRound = new RoundPlay($playerAi, $signAi);
        $result = $this->gameRoundManager->getWinner($humanRound, $aiRound);
        $this->assertEquals($result->getUsername(), 'obi');
        /**
         * AI WIns
         */
        $playerHuman = new Player('obi');
        $signHuman = new Sign(Sign::SCISSORS);
        $playerAi = new Player('ai');
        $signAi = new Sign(Sign::ROCK);
        //set rounds play
        $humanRound = new RoundPlay($playerHuman, $signHuman);
        $aiRound = new RoundPlay($playerAi, $signAi);
        $result = $this->gameRoundManager->getWinner($humanRound, $aiRound);
        
        $this->assertEquals($result->getUsername(), 'ai');
        /**
         * Tied game
         */
        $playerHuman = new Player('obi');
        $signHuman = new Sign(Sign::ROCK);
        $playerAi = new Player('ai');
        $signAi = new Sign(Sign::ROCK);
        //set rounds play
        $humanRound = new RoundPlay($playerHuman, $signHuman);
        $aiRound = new RoundPlay($playerAi, $signAi);
        $result = $this->gameRoundManager->getWinner($humanRound, $aiRound);
        
        $this->assertNull($result);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown() {
        parent::tearDown();
        $this->testData->truncatePlayerHistory();
        $this->em->close();
    }

}
