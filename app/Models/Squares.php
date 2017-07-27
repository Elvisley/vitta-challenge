<?php

namespace Square\Models;

use Illuminate\Database\Eloquent\Model;

class Squares extends Model
{
    protected $table = "tb_squares";

    protected $fillable = ["x","y","painted","territory_id"];

    protected $hidden = ["created_at","updated_at","id","territory_id"];

    public function territory(){
         return $this->belongsTo(Territory::class);
    }

}
