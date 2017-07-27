<?php

namespace Square\Repositories;

use Square\Models\Territory;
use Square\Repositories\Contracts\TerritoryRepositoryInterface;
use DB;

class TerritoryRepository implements TerritoryRepositoryInterface
{

    /**
     * @var Territory
     */
    protected  $territory;

    function __construct(Territory $territory)
    {
        $this->territory = $territory;
    }

    public function allTerritoriesSquares(){

        $territories = DB::table("tb_territories as tt")
            ->leftJoin("tb_squares as ts",function($join){
                $join->on("tt.id","=","ts.territory_id")->where("ts.painted" ,"=", 1);
            })
            ->select("tt.id","tt.name","tt.start","tt.end","tt.area", DB::raw("count(ts.id) as painted_area"))
            ->groupBy('tt.id')->get();

       return $territories;

    }

    public function FindByTerritoriesIdSquares($id){

        $territories = DB::table("tb_territories as tt")
            ->leftJoin("tb_squares as ts" , function($join){
                $join->on("tt.id","=","ts.territory_id")->where("ts.painted" ,"=", 1);
            })
            ->where("tt.id","=",$id)
            ->select("tt.id","tt.name","tt.start","tt.end","tt.area",
                DB::raw("count(ts.id) as painted_area"))->first();

        return $territories;

    }

    public function FindByTerritoriesIdSquaresWithPainted($id, $withpainted){

        $withpainted = ($withpainted == "true" ? 1 : 0);

        $territories = $this->territory->with(['squares' =>function($query) use ($withpainted){
            $query->where('painted', $withpainted);
        }])->where("id","=",$id)->first();

        return $territories;

    }

    public function create(array $data)
    {
        return $this->territory->create($data);
    }

    public function delete($id)
    {
        $territory = $this->find($id);
        $territory->delete();
        return true;
    }

    public function find($id, $columns = array('*'))
    {
       return $this->territory->find($id, $columns);
    }

    public function allTerritoriesOrderPaintedSquares()
    {

        $territories = DB::table("tb_territories as tt")
            ->leftJoin("tb_squares as ts" , function($join){
                $join->on("tt.id","=","ts.territory_id")->where("ts.painted" ,"=", 1);
            })
            ->select("tt.id","tt.name","tt.start","tt.end","tt.area",DB::raw("count(ts.id) as painted_area"))
            ->groupBy('tt.id')
            ->orderBy('painted_area','DESC')->get();

        return $territories;
    }

    public function orderProportionalPainted()
    {
        $territories = DB::table("tb_territories as tt")
            ->leftJoin("tb_squares as ts" , function($join){
                $join->on("tt.id","=","ts.territory_id");
                $join->on("ts.painted","=",1);
            })
            ->select("tt.id","tt.name","tt.start","tt.end","tt.area",DB::raw("count(ts.id) as painted_area"))
            ->groupBy('tt.id')
            ->orderBy(DB::raw("((count(ts.id) * 100 ) / tt.area)"),'DESC')->get();

        return $territories;
    }

    public function paintedTotalArea()
    {
        $territories = DB::table("tb_territories as tt")
            ->leftJoin("tb_squares as ts" , function($join){
                $join->on("tt.id","=","ts.territory_id");
                $join->on("ts.painted","=",1);
            })
            ->select("tt.id","tt.name","tt.start","tt.end","tt.area",DB::raw("count(ts.id) as painted_area"))
            ->groupBy('tt.id')
            ->orderBy('painted_area','DESC')->get();

        return $territories;
    }

}