<?php

namespace  Square\Services\Contracts;

use Square\Repositories\Contracts\TerritoryRepositoryInterface;

interface TerritoryServiceInterface extends TerritoryRepositoryInterface
{

    public function deleteSquareTerritoryId($id);

    public function allTerritoriesSquares();

    public function FindByTerritoriesIdSquares($id, $withpainted = null);

    public function orderPainted();

    public function orderProportionalPainted();

    public function paintedTotalArea();
}