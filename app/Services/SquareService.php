<?php

namespace Square\Services;

use Square\Repositories\SquareRepository;
use Square\Services\Contracts\SquareServiceInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class SquareService extends SquareRepository implements SquareServiceInterface
{

    public function filter($x, $y)
    {
        $dados = parent::filter($x,$y);

        if(count($dados) == 0){
           throw new \Exception("This square does not belong to any territory",404);
        }

        return $dados;
    }

    public function paint($x, $y)
    {
        $square = $this->filter($x,$y);

        if($square === false){
            throw new \Exception("This square does not belong to any territory",404);
        }

        $square->painted = true;
        $square->save();
        return $square;
    }

    public function lastPainted()
    {
        $dados = parent::lastPainted();

        if(count($dados) == 0){
            throw new \Exception("Square does not belong to any territory",404);
        }

        return $dados;
    }
}