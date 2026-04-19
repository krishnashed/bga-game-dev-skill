<?php

declare(strict_types=1);

namespace Bga\Games\MemoryCards\States;

use Bga\GameFramework\StateType;
use Bga\Games\MemoryCards\Game;

class CheckMatch extends \Bga\GameFramework\States\GameState
{
    function __construct(
        protected Game $game,
    ) {
        parent::__construct($game,
            id: 30,
            type: StateType::GAME,
        );
    }

    public function onEnteringState(int $activePlayerId)
    {
        // Get all flipped cards (should be exactly 2).
        $flippedCards = $this->game->getCollectionFromDB("SELECT `card_id` AS `id`, `card_color` AS `color` FROM `card` WHERE `card_state` = 1");

        $cardIds = array_keys($flippedCards);
        $cardValues = array_values($flippedCards);

        if (count($flippedCards) != 2) {
            // Something went wrong, reset cards and go back.
            Game::DbQuery("UPDATE `card` SET `card_state` = 0 WHERE `card_state` = 1");
            return FirstSelection::class;
        }

        if ($cardValues[0]['color'] == $cardValues[1]['color']) {
            // MATCH!
            Game::DbQuery("UPDATE `card` SET `card_state` = 2 WHERE `card_id` IN (" . implode(',', $cardIds) . ")");

            // Score points.
            $this->bga->playerScore->inc($activePlayerId, 1);

            $this->bga->notify->all("matchFound", clienttranslate('${player_name} found a match!'), [
                "player_id" => $activePlayerId,
                "player_name" => $this->game->getPlayerNameById($activePlayerId),
                "card_ids" => $cardIds,
            ]);

            // Check if game is over.
            $remaining = Game::getUniqueValueFromDB("SELECT count(*) FROM `card` WHERE `card_state` = 0");
            if ($remaining == 0) {
                return EndScore::class;
            }

            // In memory cards, usually you continue if you found a match.
            return FirstSelection::class;
        } else {
            // MISMATCH!
            // Cards will be flipped back on the client side after a delay.
            // On the server side, we update them back to state 0.
            Game::DbQuery("UPDATE `card` SET `card_state` = 0 WHERE `card_id` IN (" . implode(',', $cardIds) . ")");

            $this->bga->notify->all("mismatch", clienttranslate('${player_name} did not find a match.'), [
                "player_id" => $activePlayerId,
                "player_name" => $this->game->getPlayerNameById($activePlayerId),
                "card_ids" => $cardIds,
            ]);

            return NextPlayer::class;
        }
    }
}
