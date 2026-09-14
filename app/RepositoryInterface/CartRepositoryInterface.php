<?php


namespace App\RepositoryInterface;

interface CartRepositoryInterface
{
    public function all();

    public function create($attributes);

    public function show($id);

    public function update($id, $attributes);

//    public function queryWithRelationWithQuery($relation, $arr);
//
//    public function queryWithRelation($relation);
}
