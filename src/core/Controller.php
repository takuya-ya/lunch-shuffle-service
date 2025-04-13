<?php

class Controller
{
    // $actionに'index'
    public function run($action)
    {
        $this->$action();
    }
}
