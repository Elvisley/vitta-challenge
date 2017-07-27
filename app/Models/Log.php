<?php

namespace Square\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "tb_logs";

    protected $fillable = ["uri","request","ip_client","exception","message","code"];

    protected $hidden = ["updated_at","id"];

    public function setRequestAttribute($value)
    {
        $this->attributes['request'] = json_encode($value);
    }
    public function getRequestAttribute($value)
    {
        return json_decode($value);
    }
}
