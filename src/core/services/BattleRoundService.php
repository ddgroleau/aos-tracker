<?php declare(strict_types=1);

namespace Core\Services;

use Core\Models\BattleRound;
use Infrastructure\BattleRoundRepository;

require_once(dirname(__DIR__, 1).'/models/BattleRound.php');
require_once(dirname(__DIR__, 2).'/infrastructure/BattleRoundRepository.php');

class BattleRoundService {
    private BattleRoundRepository $repository;

    public function __construct()
    {
        $this->repository = new BattleRoundRepository();
    }

    public function createBattleRound(BattleRound $round):bool {
        return $this->repository->createBattleRound($round);
    }

    public function getLatestRoundByBattleId($battle_id):BattleRound {
        return $this->repository->getLatestRoundByBattleId($battle_id);
    }
}