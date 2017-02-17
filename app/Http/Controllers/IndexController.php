<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 15:00
 */

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return view('index.index', $this->data);
    }
}