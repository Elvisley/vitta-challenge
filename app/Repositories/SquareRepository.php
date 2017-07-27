<?php
namespace Square\Repositories;

use Square\Models\Squares;
use Square\Repositories\Contracts\SquareRepositoryInterface;

class SquareRepository implements SquareRepositoryInterface
{

    /**
     * @var Squares
     */
    protected $square;

    function __construct(Squares $squares)
    {
        $this->square = $squares;
    }

    public function filter($x , $y){
        return $this->square
            ->where("x","=",$x)
            ->where("y","=",$y)->first();

    }

    public function deleteSquareTerritoryId($territory_id)
    {
        $this->square->where("territory_id","=",$territory_id)->delete();
        return true;
    }

    public function create(array $data)
    {
        return $this->square->create($data);
    }

    public function lastPainted()
    {
        return $this->square->orderBy('updated_at',"desc")->limit(5)->get();
    }
}