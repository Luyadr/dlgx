<?php
namespace app\index\controller;

use think\Controller;

class Club extends Controller
{
    public function index()
    {
        return $this->fetch('/club');
    }
}
