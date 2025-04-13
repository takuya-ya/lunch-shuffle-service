<?php

class Controller
{
    // $actionに'index'
    public function run($action)
    {
        // $thisクラスにおける$actionメソッドの有無を確認
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException();
        }

        $this->$action();
    }
}
