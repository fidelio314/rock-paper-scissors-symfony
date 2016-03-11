<?php
/**
 * Created by PhpStorm.
 * User: fidelio
 * Date: 07/03/16
 * Time: 20:05
 */

namespace AppBundle\Model;


class Sign
{
    const SCISSORS = 'SCISSORS';
    const PAPER = 'PAPER';
    const ROCK = 'ROCK';
    protected $code;
    protected $victim;
    protected $killer;

    /**
     * construct
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
        $this->victim = $this->defineVictimCode();
        $this->killer = $this->defineKillerCode();
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function setVictim($victim)
    {
        $this->victim = $victim;
    }

    public function getVictim()
    {
        return $this->victim;
    }

    public function getKiller()
    {
        return $this->killer;
    }

    public function defineVictimCode()
    {
        switch ($this->getCode()) {
            case self::SCISSORS:
                return self::PAPER;
            case self::PAPER:
                return self::ROCK;
            case self::ROCK:
                return self::SCISSORS;
        }
    }

    public function defineKillerCode()
    {
        switch ($this->getCode()) {
            case self::SCISSORS:
                return self::ROCK;
            case self::PAPER:
                return self::SCISSORS;
            case self::ROCK:
                return self::PAPER;
        }
    }

}