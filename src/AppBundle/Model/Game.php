<?php

namespace AppBundle\Model;

use AppBundle\Model\Player;

/**
 * Class Game
 * This class describes a Rock-paper-scissors game set
 * @package AppBundle\Model
 */
class Game
{
    const GAME_TIME = 3600;
    const MODE_EASY = 0;
    const MODE_EXPERT = 1;
    protected $rounds;
    protected $playerHuman;
    protected $playerAi;
    protected $timestamp;
    protected $mode;
    protected $score;
    protected $identifier;
    protected $autoMode;

    /**
     * constructor of the Game
     *
     * @param Player $playerOne player object
     * @param Player $playerTwo player object
     * @param int $mode mode of the game EASY(0) or EXPERT(1)
     * @param string $identifier game identifier
     * @param boolean $autoMode if true The human players signs are chosen by the program
     * @param boolean $start    start the game timer
     */
    public function __construct(
        Player $playerOne,
        Player $playerTwo,
        $mode,
        $identifier = null,
        $autoMode = false,
        $start = true
    )
    {
        $this->playerHuman = $playerOne;
        $this->playerAi = $playerTwo;
        $this->initScore();
        $this->rounds = array();
        if (true === $start) {
            $this->setTimestamp();
        }
        $this->mode = $mode;
        $this->identifier = $identifier;
        $this->autoMode = $autoMode;
    }

    public function initScore()
    {
        $this->score = array(
            $this->playerHuman->getUsername() => 0,
            $this->playerAi->getUsername() => 0,
        );

        return $this;
    }

    /**
     * check if game is on auto mode. The human player signs are chosen by the program
     *
     * @return bool
     */
    public function isAutoMode()
    {
        return $this->autoMode;
    }

    /**
     * set the auto mode
     *
     * @param $autoMode
     *
     * @return $this
     */
    public function setAutoMode($autoMode)
    {
        $this->autoMode = $autoMode;

        return $this;
    }

    /**
     * set game identifier
     *
     * @param $identifier
     *
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * get identifier
     *
     * @return string|null
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getPlayerScoreByUsername($username)
    {
        if (!isset($this->score[$username])) {
            $this->score[$username] = 0;
        }

        return $this->score[$username];
    }
    public function getPlayerScore(Player $player)
    {
        if (!isset($this->score[$player->getUsername()])) {
            $this->score[$player->getUsername()] = 0;
        }

        return $this->score[$player->getUsername()];
    }

    public function addScore(Player $player)
    {
        $this->score[$player->getUsername()] = $this->getPlayerScore($player) + 1;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    public function getPlayerHuman()
    {
        return $this->playerHuman;
    }

    public function getPlayerAi()
    {
        return $this->playerAi;
    }

    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = time();

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * isGameFinished
     * check if the game is finished
     * @return bool
     */
    public function isGameFinished()
    {
        $now = new \DateTime();
        if ($now->getTimestamp() - $this->timestamp >= self::GAME_TIME) {
            return true;
        }

        return false;

    }


} 