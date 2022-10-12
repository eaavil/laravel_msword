<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \BigShark\SQLToBuilder\BuilderClass;
class TestController extends Controller
{
    //
    public function query_builder($query){
        $builder = new BuilderClass($query);
        echo $builder->convert();
    }
}
