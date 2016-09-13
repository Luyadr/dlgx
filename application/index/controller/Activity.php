<?php
namespace app\index\controller;

use think\Controller;

class Activity extends Controller
{
    public function index()
    {
        return $this->fetch('/index');
    }
}
