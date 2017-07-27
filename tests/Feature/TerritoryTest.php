<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TerritoryTest extends TestCase
{

    use DatabaseTransactions;

    public function testAddTerritory()
    {
        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $response = $this->json('POST','api/v1/territories',$territorio);

        $response->assertStatus(200)->assertJsonStructure([
            'error','data' => array('name','start','end','area','painted_area')
        ]);
    }

    public function testTerritoryOverlay()
    {
        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $this->json('POST','api/v1/territories',$territorio);

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 4,'y' => 4)
        );

        $response = $this->json('POST','api/v1/territories',$territorio);

        $response->assertStatus(404)->assertJson([
            'error' => true,
            'message' => 'territory-overlay'
        ]);
    }

    public function testIncompleteData()
    {

        $territorio = array(
            "name" => "A",
            "end" => array('x' => 50,'y' => 50)
        );

        $response = $this->json('POST','api/v1/territories',$territorio);

        $response->assertStatus(404)->assertJson([
            'error' => true,
            'message' => 'incomplete-data'
        ]);
    }

    public function testReturnAllTerritories(){

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $this->json('POST','api/v1/territories',$territorio);

        $response = $this->json('GET','api/v1/territories');

        $response->assertStatus(200)->assertJsonStructure([
            'count','data' => array(array('name','start','end','area','painted_area'))
        ])->assertJson(array('count' => 1));
    }

    public function testRemoveTerritory(){

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $retorno = $this->json('POST','api/v1/territories',$territorio);

        $territorio = $retorno->decodeResponseJson();

        $response = $this->json('DELETE','api/v1/territories/'.$territorio['data']['id']);

        $response->assertStatus(200)->assertJson(array('error' => false));

    }

    public function testTerritoryNotFound(){

        $response = $this->json('DELETE','api/v1/territories/99999999');

        $response->assertStatus(404)->assertJson([
            'error' => true,
            'message' => 'This territory was not found'
        ]);
    }

    public function testSingleTerritory(){

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $retorno = $this->json('POST','api/v1/territories',$territorio);

        $territorio = $retorno->decodeResponseJson();

        $response = $this->json('GET','api/v1/territories/'.$territorio['data']['id']);

        $response->assertStatus(200)->assertJsonStructure([
            'error','data' => array('name','start','end','area','painted_area')
        ]);
    }

    /*public function testSingleTerritoryNotFound(){

        $response = $this->json('GET','api/v1/territories/999999');

        $response->assertStatus(404)->assertJson([
            'error' => true,
            'message' => 'This territory was not found'
        ]);
    }*/

    public function testGetStatusSquare(){

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $this->json('POST','api/v1/territories',$territorio);

        $response = $this->json('GET','api/v1/square/1/3');

        $response->assertStatus(200)->assertJsonStructure([
            'error','data' => array('x','y','painted')
        ]);

    }

    public function testGetStatusSquareNotFound(){

        $response = $this->json('GET','api/v1/square/1/3');

        $response->assertStatus(404)->assertJson([
            'error' => true,
            'message' => 'This square does not belong to any territory'
        ]);
    }

    public function testThrowPaintIt(){

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 50,'y' => 50)
        );

        $this->json('POST','api/v1/territories',$territorio);

        $response = $this->json('PATCH','api/v1/square/1/3/paint');

        $response->assertStatus(200)->assertJson([
            "error" => false,
            "data" => array("x" => 1 , "y" => 3 , "painted" => true)
        ]);
    }

    public function testThrowPaintItNotFound(){

        $response = $this->json('PATCH','api/v1/square/1/3/paint');

        $response->assertStatus(404)->assertJson([
            "error" => true,
            "message" => "This square does not belong to any territory"
        ]);
    }

    public function testListPaintedSquaresOfTerritory(){

        $territorio = array(
            "name" => "A",
            "start" => array('x' => 0,'y' => 0),
            "end" => array('x' => 5,'y' => 5)
        );

        $retorno = $this->json('POST','api/v1/territories',$territorio);

        $retorno = $retorno->decodeResponseJson();

        $this->json('PATCH','api/v1/square/0/1/paint');
        $this->json('PATCH','api/v1/square/2/3/paint');

        $response = $this->json('GET','api/v1/territories/'.$retorno['data']['id']."?withpainted=true");

        $response->assertStatus(200)->assertJsonStructure([
            'error','data' => array('id','name','start','end','area','painted_area',
                'painted_squares' => array(array('x','y','painted')))
        ])->assertJson(array("data" => array("painted_area" => 2)));

        $response = $this->json('GET','api/v1/territories/'.$retorno['data']['id']."?withpainted=false");

        $response->assertStatus(200)->assertJsonStructure([
            'error','data' => array('id','name','start','end','area','painted_area',
                'painted_squares' => array(array('x','y','painted')))
        ])->assertJson(array("data" => array("painted_area" => 23)));
    }
}
