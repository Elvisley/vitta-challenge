<?php

namespace Square\Repositories\Contracts;

interface TerritoryRepositoryInterface
{

    public function create(array $data);

    public function delete($id);

    public function find($id, $columns = array('*'));

}