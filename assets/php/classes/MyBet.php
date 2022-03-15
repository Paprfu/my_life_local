<?php


namespace assets\php\classes;


class MyBet extends Bet
{
    public $value;
    public $type;
    public $rate;
    private $database;

    public function __construct(array $row, \Database $database)
    {
        parent::__construct($row, $database);
        $this->database = $database;
        $this->value= $row['value'];
        $this->type = $row['type'];
        $this->rate = $this->getRate();
    }


    public function isWin() {
       if($this->match->score_home > $this->match->score_guest && $this->type == -2)
            return true;
        else if($this->match->score_home >= $this->match->score_guest && $this->type == -1)
            return true;
        else if($this->match->score_home == $this->match->score_guest && $this->type == 0)
            return true;
        else if($this->match->score_home <= $this->match->score_guest && $this->type == 1)
            return true;
        else if($this->match->score_home < $this->match->score_guest && $this->type == 2)
            return true;
        else
           return false;
    }

    public function getRate() {
        switch($this->type) {
            case -2:
                return $this->home_win_rate;

            case -1:
                return $this->home_win_draw_rate;

            case 0:
                return $this->draw_rate;

            case 1:
                return $this->guest_win_draw_rate;

            case 2:
                return $this->guest_win_rate;
            default:
                error_log('Type for my bet not exists');
        }
    }

}