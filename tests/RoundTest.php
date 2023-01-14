<?php declare(strict_types=1);

use Models\Round;
use PHPUnit\Framework\TestCase;
require(dirname(__DIR__, 1).'/src/models/Round.php');

final class RoundTest extends TestCase {
    public function testCreateInstanceReturnsNewInstanceFromAssociativeArray() {
        $this->assertInstanceOf(Round::class, Round::createInstance([]));
    }

    public function testAreUniqueNamesReturnsFalseIfPlayerNamesAreNotUnique() {
        $test_round = Round::createInstance(["player1_name" => "test", "player2_name" => "test"]);
        $this->assertFalse($test_round->areUniqueNames());
    }

    public function testSanitizeIntReturnsFalseIfInputIsNotANumber() {
        $test_round = Round::createInstance([]);
        $this->assertFalse($test_round->sanitizeInt("not an int"));
    }

    public function testSanitizeIntReturnFalseIfInputIsFloat() {
        $test_round = Round::createInstance([]);
        $this->assertFalse($test_round->sanitizeInt(1.11));
    }

    public function testSanitizeIntReturnIntIfInputIsInt() {
        $test_round = Round::createInstance([]);
        $this->assertEquals(9,$test_round->sanitizeInt(9));
    }

    public function testAdvanceRoundUpdatesPropertyValues()
    {
        $test_round = Round::createInstance([
            "round_number" => 1,
            "player1_victory_points_total" => 0,
            "player2_victory_points_total" => 0,
            "player1_command_points" => 0,
            "player2_command_points" => 0,
            "player1_victory_points" => 1,
            "player2_victory_points" => 2,
        ]);

        $test_round->advanceRound();
        $this->assertEquals(2,$test_round->round_number);
        $this->assertEquals(1,$test_round->player1_victory_points_total);
        $this->assertEquals(2,$test_round->player2_victory_points_total);
    }

    public function testGetCurrentWinnerReturnsWinnerName() {
        $test_round = Round::createInstance([
            "player1_name"=>"test1",
            "player2_name"=>"test2",
            "round_number" => 1,
            "player1_victory_points_total" => 2,
            "player2_victory_points_total" => 1,
            "player1_command_points" => 0,
            "player2_command_points" => 0,
            "player1_victory_points" => 0,
            "player2_victory_points" => 0,
        ]);
        $this->assertEquals("test1", $test_round->getCurrentWinner());
    }
}