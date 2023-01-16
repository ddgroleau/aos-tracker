<?php
declare(strict_types=1);
namespace Core\Models;

use DateTime;

class BattleRound {
    private int $id;
    public string $battle_id = "";
    public int $round_number;
    public string $player1_name;
    public int $player1_command_points;
    public int $player1_victory_points;
    public int $player1_victory_points_total;
    public string $player2_name;
    public int $player2_command_points;
    public int $player2_victory_points;
    public int $player2_victory_points_total;

    private function __construct(array $array)
    {
        $this->battle_id = isset($array["battle_id"]) ? htmlspecialchars($array["battle_id"]) : "";
        $this->round_number = isset($array["round_number"]) ? $this->sanitizeInt($array["round_number"]) : 1;
        $this->player1_name = isset($array["player1_name"]) ? htmlspecialchars($array["player1_name"]) : "";
        $this->player1_command_points = isset($array["player1_command_points"]) ? $this->sanitizeInt($array["player1_command_points"]) : 0;
        $this->player1_victory_points = isset($array["player1_victory_points"]) ? $this->sanitizeInt($array["player1_victory_points"]) : 0;
        $this->player1_victory_points_total = isset($array["player1_victory_points_total"]) ? $this->sanitizeInt($array["player1_victory_points_total"]) : 0;
        $this->player2_name = isset($array["player2_name"]) ? htmlspecialchars($array["player2_name"]) : "";
        $this->player2_command_points = isset($array["player2_command_points"]) ? $this->sanitizeInt($array["player2_command_points"]) : 0;
        $this->player2_victory_points = isset($array["player2_victory_points"]) ? $this->sanitizeInt($array["player2_victory_points"]) : 0;
        $this->player2_victory_points_total = isset($array["player2_victory_points_total"]) ? $this->sanitizeInt($array["player2_victory_points_total"]) : 0;        
    }

    public static function createInstance(array $array):BattleRound {
        return new BattleRound($array);
    }

    public function areUniqueNames():bool {
        return $this->player1_name !== $this->player2_name;
    }

    public function sanitizeInt($int) {
        return filter_var(htmlspecialchars("$int"), FILTER_VALIDATE_INT);
    }

    public function advanceRound():void {
        $this->round_number += 1;
        $this->player1_victory_points_total += $this->player1_victory_points;
        $this->player2_victory_points_total += $this->player2_victory_points;
        $this->player1_command_points = 0;
        $this->player2_command_points = 0;
        $this->player1_victory_points = 0;
        $this->player2_victory_points = 0;
        if($this->battle_id === "") $this->generateBattleId();
    }

    public function getCurrentWinner():string {
        if($this->player1_victory_points_total === $this->player2_victory_points_total)
                return "Tie";
        if($this->player1_victory_points_total < $this->player2_victory_points_total)
                return $this->player2_name;
        else return $this->player1_name;
    }

    public function generateBattleId() : void {
        $this->battle_id = strtoupper( $this->player1_name . $this->player2_name . (new DateTime())->getTimestamp() );
    }
}