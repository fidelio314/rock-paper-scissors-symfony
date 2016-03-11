<?php
/**
 * Created by PhpStorm.
 * User: gergos
 * Date: 11/03/16
 * Time: 11:06
 */

namespace Tests\AppBundle\Manager;


use AppBundle\Manager\SignManager;
use AppBundle\Model\Game;
use AppBundle\Model\Player;
use AppBundle\Model\RoundPlay;
use AppBundle\Model\Sign;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\PlayerHistory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Data\TestData;

class SignManagerTest extends KernelTestCase
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
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->testData = new TestData($this->em);
        $this->testData->truncatePlayerHistory();
        $this->testData->createPlayerHistory();
    }

    public function testGetSignKiller()
    {
        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $signManager = new SignManager($entityManager);
        $victimSign = Sign::PAPER;
        $result = $signManager->getSignKiller($victimSign);
        $this->assertInstanceOf(Sign::class, $result);
        $this->assertEquals($result->getCode(), Sign::SCISSORS);
    }

    public function testGetPlayerHistory()
    {
        $signManager = new SignManager($this->em);
        $this->assertCount(8, $signManager->getPlayerHistory('obi'));
    }

    public function testSavePlayerRound()
    {
        $signManager = new SignManager($this->em);
        $sign = new Sign(Sign::ROCK);
        $player = new Player('yoda');
        $roundPlay = new RoundPlay($player, $sign);
        $signManager->savePlayerRound($roundPlay);
        $roundHistory = $this->em->getRepository('AppBundle:PlayerHistory')->findPlayerHistoryList('yoda');
        $this->assertCount(1, $roundHistory);
        $this->assertEquals(Sign::ROCK, $roundHistory[0]);
    }

    public function testFindCandidate()
    {
        $playerDataHistory = $this->testData->getTestSignSequence();
        $signManager = new SignManager($this->em);

        /**
         * will get the last 3 sign sequences: ROCK, SCISSORS, SCISSORS
         * will search the sequences into the player data
         * will get the sign right after
         */
        $candidateVictim = $signManager->findVictimCandidate($playerDataHistory);
        $this->assertEquals(Sign::ROCK, $candidateVictim);
    }

    public function testGetRandomSignExpertMode()
    {
        $signManager = new SignManager($this->em);

        /**
         * will get the last 3 sign sequences: ROCK, SCISSORS, SCISSORS
         * will search the sequences into the player data
         * will get the sign right after
         * will get the sign that wins it!
         */
        $candidateVictim = $signManager->getRandomSign(Game::MODE_EXPERT, 'obi');
        $this->assertEquals(Sign::PAPER, $candidateVictim->getCode());
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
 