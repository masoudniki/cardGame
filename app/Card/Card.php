<?php

namespace App\Card;

class Card
{
    public static function getCardValue($cardName){
        [$khal,$value]=explode($cardName);
        return config("card_game.cards".$khal.$cardName);
    }
    public static function getMostCardValue($cards){
        $cardsAndValues=[];
        foreach ($cards as $card){

        }
    }

}
