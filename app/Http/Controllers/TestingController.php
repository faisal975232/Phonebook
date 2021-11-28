<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{


    public function test()
    {

        if (auth()->user()->role == 1) {


            $a = "teted";
            echo $a;
        } else {

            return response([
                'message' => ['NO ACCESS']
            ], 401);
        }
    }
}
