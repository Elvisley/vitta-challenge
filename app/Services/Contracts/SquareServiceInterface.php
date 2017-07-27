<?php

namespace Square\Services\Contracts;

use Square\Repositories\Contracts\SquareRepositoryInterface;

interface SquareServiceInterface extends SquareRepositoryInterface
{
    public function filter($x, $y);

    public function paint($x, $y);

    public function lastPainted();

}