<?php

namespace App\Repository;


//use App\Models\Cart;
use App\RepositoryInterface\CartRepositoryInterface;

class DBCartRepository implements CartRepositoryInterface
{


    public function all()
    {
//        return BrokerLibrary::latest()->get();
    }

    public function create($attributes)
    {
//        return BrokerLibrary::create($attributes);
    }

    public function show($id)
    {
//        $library = BrokerLibrary::findOrFail($id);
//        return $library;
    }

    public function update($id, $attributes)
    {
//        return BrokerLibrary::findOrFail($id)->update($attributes);
    }


//    public function queryWithRelationWithQuery($relation, $arr)
//    {
//        return BrokerLibrary::with($relation)->where($arr)->get();
//    }
//
//    public function queryWithRelation($relation)
//    {
//        return BrokerLibrary::with($relation)->get();
//    }
//

}
