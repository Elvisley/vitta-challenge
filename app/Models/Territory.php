<?php

namespace Square\Models;

use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    protected $table = "tb_territories";

    protected $fillable = ["name","start","end","area"];

    protected $hidden = ["created_at", "updated_at"];

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = json_encode($value);
    }
    public function getStartAttribute($value)
    {
       return json_decode($value);
    }

    public function setEndAttribute($value)
    {
        $this->attributes['end'] = json_encode($value);
    }
    public function getEndAttribute($value)
    {
        return json_decode($value);
    }

    public function squares()
    {
        return $this->hasMany(Squares::class , 'territory_id' , 'id');
    }


}
