<?php declare(strict_types=1);

use Models\Round;
use PHPUnit\Framework\TestCase;
require(dirname(__DIR__, 1).'/src/models/Round.php');

final class RoundTest extends TestCase {
    public function testCreateInstanceReturnsNewInstanceFromAssociativeArray() {
        $this->assertInstanceOf(Round::class, Round::createInstance([]));
    }

    public function testAreUniqueNamesReturnsFalseIfPlayerNamesAreNotUnique() {
        $test_round = Round::createInstance(["p1_name" => "test", "p2_name" => "test"]);
        $this->assertFalse($test_round->areUniqueNames());
    }

    public function testSanitizeIntReturnsFalseIfInputIsNotANumber() {
        $test_round = Round::createInstance([]);
        $this->assertTrue($test_round->sanitizeInt("not an int"));
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
            "p1_vp_total" => 0,
            "p2_vp_total" => 0,
            "p1_cp" => 0,
            "p2_cp" => 0,
            "p1_vp" => 1,
            "p2_vp" => 2,
        ]);

        $test_round->advanceRound();
        $this->assertEquals(2,$test_round->round_number);
        $this->assertEquals(1,$test_round->p1_vp_total);
        $this->assertEquals(2,$test_round->p2_vp_total);
    }

    public function testGetCurrentWinnerReturnsWinnerName() {
        $test_round = Round::createInstance([
            "p1_name"=>"test1",
            "p2_name"=>"test2",
            "round_number" => 1,
            "p1_vp_total" => 2,
            "p2_vp_total" => 1,
            "p1_cp" => 0,
            "p2_cp" => 0,
            "p1_vp" => 0,
            "p2_vp" => 0,
        ]);
        $this->assertEquals("test1", $test_round->getCurrentWinner());
    }
}