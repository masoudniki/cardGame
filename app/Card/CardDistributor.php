<?php

namespace App\Card;

class CardDistributor
{
    public array $cards=[];
    public function __construct(){
        $this->cards=$this->loadCards();
    }
    public function  distribute($playersCount=4,$eachPlayerCardCount=13): array
    {
        $playersCards=[];
        for($i=0;$i<$playersCount;++$i){
            $randomCards=array_rand($this->cards,$eachPlayerCardCount);
            $playersCards[$i]=$this->getValues($randomCards,$this->cards);
            $this->removeUsedElementsFromArray($randomCards);
        }
        return $playersCards;
    }
    public function removeTitleNameFromArray($cards){
        $cardsWithoutTitleName=[];
        foreach ($cards as $key =>$card){
            $cardsWithoutTitleName+=$card;
        }
        return $cardsWithoutTitleName;
    }
    public function arrayKeys($cards): array
    {
        return array_keys($cards);
    }
    public function removeUsedElementsFromArray($usedElement){
        $this->cards=array_diff_key($this->cards,array_flip($usedElement));
    }
    public function shuffle($howMany=1){
        for($i=0;$i<$howMany;++$i){
            shuffle($this->cards);
        }
        return $this;
    }

    public function getValues($randomCards,$cards): array
    {
        $values=[];
        foreach ($randomCards as $randomCard){
            $values[]=$cards[$randomCard];
        }
        return $values;
    }
    public function loadCards():array{
        return $this->arrayKeys($this->removeTitleNameFromArray(config("card_game.cards")));
    }
    public function refreshCards(){
        $this->cards=$this->loadCards();
    }


}
