<?php

namespace Square\Http\Controllers;


use Response;
use Validator;
use Square\Services\Contracts\SquareServiceInterface;

class SquareController extends Controller
{
    protected $squareService;

    function __construct(SquareServiceInterface $squareService)
    {
        $this->squareService = $squareService;
    }

    public function index($x, $y)
    {

        $dados = $this->squareService->filter($x, $y);

        return Response::json([
            'error' => false,
            'data' => $dados,
        ], 200);
    }

    public function lastPainted(){
        $dados = $this->squareService->lastPainted();

        return Response::json([
            'error' => false,
            'data' => $dados,
        ], 200);
    }

    public function paint($x, $y){

        $dados = $this->squareService->paint($x, $y);

        return Response::json([
            'error' => false,
            'data' => $dados,
        ], 200);
    }
}
