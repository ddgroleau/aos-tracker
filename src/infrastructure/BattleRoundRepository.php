<?php declare(strict_types=1);

namespace Infrastructure;

use Exception;
use Infrastructure\Database;
use Core\Models\BattleRound;
use PDO;

require_once(__DIR__.'/Database.php');
require_once(dirname(__DIR__, 1).'/core/models/BattleRound.php');

class BattleRoundRepository {
    private Database $db;
    public function __construct()
    {
        $this->db = new Database();
        $this->createBattleRoundTable();
    }

    public function getLatestRoundByBattleId(string $battle_id):BattleRound {
        try {
            $round_query = ($this->db->connect())->prepare("SELECT * FROM battle_rounds WHERE battle_id = :battle_id ORDER BY round_number DESC LIMIT 1;");
            $round_query->execute(["battle_id" => $battle_id]);
            $round = $round_query->fetch(PDO::FETCH_ASSOC);
            return BattleRound::createInstance($round);
        } catch(Exception $e) {
            return BattleRound::createInstance([]);
        }
    }

    public function createBattleRound(BattleRound $round):bool {
        try {
            $columns = "
                battle_id,
                round_number, 
                player1_name,
                player1_command_points,
                player1_victory_points,
                player1_victory_points_total,
                player2_name,
                player2_command_points,
                player2_victory_points,
                player2_victory_points_total
            ";
            $values = "
                :battle_id,
                :round_number, 
                :player1_name,
                :player1_command_points,
                :player1_victory_points,
                :player1_victory_points_total,
                :player2_name,
                :player2_command_points,
                :player2_victory_points,
                :player2_victory_points_total
            ";

            $statement = $this->db->connect()->prepare("INSERT INTO public.battle_rounds ($columns) VALUES ($values);");
            $was_created = $statement->execute([
                "battle_id" => $round->battle_id,
                "round_number" => $round->round_number,
                "player1_name" => $round->player1_name,
                "player1_command_points" => $round->player1_command_points,
                "player1_victory_points" => $round->player1_victory_points,
                "player1_victory_points_total" => $round->player1_victory_points_total,
                "player2_name" => $round->player2_name,
                "player2_command_points" => $round->player2_command_points,
                "player2_victory_points" => $round->player2_victory_points,
                "player2_victory_points_total" => $round->player2_victory_points_total
            ]);
            return boolval($was_created);
        } catch(Exception $e) {
            return false;
        }
    }

    public function createBattleRoundTable():bool {
        try {
            $columns = "
            id INT GENERATED ALWAYS AS IDENTITY, 
            battle_id VARCHAR(90) NOT NULL, 
            round_number INT NOT NULL, 
            player1_name VARCHAR(90) NOT NULL,
            player1_command_points INT NOT NULL,
            player1_victory_points INT NOT NULL,
            player1_victory_points_total INT NOT NULL,
            player2_name VARCHAR(90) NOT NULL,
            player2_command_points INT NOT NULL,
            player2_victory_points INT NOT NULL,
            player2_victory_points_total INT NOT NULL
        ";

            $table_created = $this->db->connect()->exec("CREATE TABLE IF NOT EXISTS public.battle_rounds ($columns);");
            return boolval($table_created); 
        } catch (Exception $e) {
            return false;
        }
    }
}