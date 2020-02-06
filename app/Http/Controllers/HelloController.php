<?php

namespace App\Http\Controllers;

use App\PointLog;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index ()
    {
        PointLog::all();
        echo $hello = 'Hello,World!';
    }
}
