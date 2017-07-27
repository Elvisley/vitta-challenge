<?php

namespace Square\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Validator;
use Square\Services\Contracts\TerritoryServiceInterface;

class TerritoryController extends Controller
{

    /**
     * @var TerritoryServiceInterface
     */
    protected $territoryServiceInterface;

    function __construct(TerritoryServiceInterface $service)
    {
        $this->territoryServiceInterface = $service;
    }

    public function index(){

       $lista = $this->territoryServiceInterface->allTerritoriesSquares();

        return Response::json([
            'count' => count($lista),
            'data' => $lista,
        ], 200);

    }

    public function store(Request $request){

        $dados = $request->all();

        $validator = Validator::make($dados, [
            'name' => 'required|max:120',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ResourceNotFoundException("incomplete-data",404);
        }

        $data = $this->territoryServiceInterface->create($dados);

        return Response::json([
            'error'  => false,
            'data' => $data
        ], 200);

    }

    public function show(Request $request, $id){

        $withpainted = $request->input("withpainted");

        $data = $this->territoryServiceInterface->FindByTerritoriesIdSquares($id, $withpainted);

        return Response::json([
            'error'  => false,
            'data' => $data
        ], 200);
    }

    public function orderPainted(){

        $data = $this->territoryServiceInterface->orderPainted();

        return Response::json([
            'error'  => false,
            'data' => $data
        ], 200);

    }

    public function orderProportionalPainted(){

        $data = $this->territoryServiceInterface->orderProportionalPainted();

        return Response::json([
            'error'  => false,
            'data' => $data
        ], 200);
    }

    public function paintedTotalArea(){

        $data = $this->territoryServiceInterface->paintedTotalArea();

        return Response::json([
            'error'  => false,
            'data' => $data
        ], 200);
    }

    public function destroy($id){

        $this->territoryServiceInterface->deleteSquareTerritoryId($id);

        return Response::json([
            'error'  => false
        ], 200);
    }

}
