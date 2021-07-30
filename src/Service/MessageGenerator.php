<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $logger;

    // Les message doit-il être random ?
    private $isRandom;

    // Injection de service Symfo dans notre service
    public function __construct(LoggerInterface $logger, bool $isRandom)
    {
        // on va pouvoir logger des choses \o/ trop cool x)
        $this->logger = $logger;

        // Message aléatoire ou pas ?
        $this->isRandom = $isRandom;
    }

    private $messages = [
        'You did it! You updated the system! Amazing!',
        'That was one of the coolest updates I\'ve seen all day!',
        'Great work! Keep going!',
    ];

    public function getRandomMessage()
    {
        if ($this->isRandom) {
            $message = $this->messages[array_rand($this->messages)];
        } else {
            $message = 'Action effectuée avec succès \o/';
        }

        // ça sert à rien mais c'est pour l'exemple =)
        $this->logger->info('Random message', [
            'message' => $message,
        ]);

        return $message;
    }
}