<?php

namespace Square\Repositories\Contracts;


interface SquareRepositoryInterface
{
    public function filter($x , $y);

    public function deleteSquareTerritoryId($territory_id);

    public function create(array $data);
}