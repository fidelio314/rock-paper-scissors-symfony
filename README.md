Welcome to the demo rapresentation of the game Rock-Paper-Scissors build on top of symfony3 framework.
===================

Installation
====

 1. Clone the project
 2. Install composer : https://getcomposer.org/download/
 3. run `composer install` into the terminal
 4. Composer will then propose you to create automatically the parameters.yml file. For default settings leave the default values
 5. run `php app/console server:run` into the terminal
 6. Access to the url indicated by the previous terminal command. For exemple: http://127.0.0.1:8000

----------


How does it works?
-------------

A user can play an Hour Game of Rock Paper Scissors versus an A.I. Player.

The user must set his username, select if wants the auto mode enabled (an algorithm will select a SIGN for him-for this alpha version a simple random function is used).

The user can also select a game mode. EASY or EXPERT
> **Note:**

> - The EASY mode uses a simple random function to select a SIGN for the A.I player
> - The EXPERT mode uses an simple algorithm analyzing the previous sequences of signs played by the user on the game on each round. The history  of the rounds are saved on a simple sqlite database. 


Tests
-------------

This project uses PhpUnit.
Intall phpunit:  https://phpunit.de/
execute: `phpunit` into the terminal
