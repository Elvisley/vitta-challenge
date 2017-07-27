<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 23/07/17
 * Time: 18:06
 */

namespace Square\Services;

use Square\Models\Log;

class LogService
{
    /**
     * @var Log
     */
    private $log;

    function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function create(array $data){
        $this->log->create($data);
        return true;
    }

    public function listLog($limit = 5){
        return $this->log->orderBy("created_at","desc")->limit($limit)->get();
    }
}