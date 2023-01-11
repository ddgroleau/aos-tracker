<?php
namespace Models;
class Round {
    private function __construct($array)
    {
        $this->round_number = isset($array["round_number"]) ? $this->sanitizeInt($array["round_number"]) : 1;
        $this->p1_name = isset($array["p1_name"]) ? htmlspecialchars($array["p1_name"]) : "";
        $this->p1_cp = isset($array["p1_cp"]) ? $this->sanitizeInt($array["p1_cp"]) : 0;
        $this->p1_vp = isset($array["p1_vp"]) ? $this->sanitizeInt($array["p1_vp"]) : 0;
        $this->p1_vp_total = isset($array["p1_vp_total"]) ? $this->sanitizeInt($array["p1_vp_total"]) : 0;
        $this->p2_name = isset($array["p2_name"]) ? htmlspecialchars($array["p2_name"]) : "";
        $this->p2_cp = isset($array["p2_cp"]) ? $this->sanitizeInt($array["p2_cp"]) : 0;
        $this->p2_vp = isset($array["p2_vp"]) ? $this->sanitizeInt($array["p2_vp"]) : 0;
        $this->p2_vp_total = isset($array["p2_vp_total"]) ? $this->sanitizeInt($array["p2_vp_total"]) : 0;
    }
    public $round_number;
    public $p1_name;
    public $p1_cp;
    public $p1_vp;
    public $p1_vp_total;
    public $p2_name;
    public $p2_cp;
    public $p2_vp;
    public $p2_vp_total;

    public static function createInstance($array) {
        return new Round($array);
    }

    public function areUniqueNames() {
        return $this->p1_name !== $this->p2_name;
    }

    public function sanitizeInt($int) {
        return filter_var(htmlspecialchars($int), FILTER_VALIDATE_INT);
    }

    public function advanceRound() {
        $this->round_number += 1;
        $this->p1_vp_total += $this->p1_vp;
        $this->p2_vp_total += $this->p2_vp;
        $this->p1_cp = 0;
        $this->p2_cp = 0;
        $this->p1_vp = 0;
        $this->p2_vp = 0;
    }

    public function getCurrentWinner() {
        if($this->p1_vp_total === $this->p2_vp_total)
                return "Tie";
        if($this->p1_vp_total < $this->p2_vp_total)
                return $this->p2_name;
        else return $this->p1_name;
    }
}