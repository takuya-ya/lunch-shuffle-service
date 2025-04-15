<?php

class Controller
{
    protected $actionName;

    // $actionに'index'
    public function run($action)
    {
        $this->actionName = $action;

        // $thisクラスにおける$actionメソッドの有無を確認
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException();
        }

        $content = $this->$action();
        return $content;
    }

    // templateはaction(メソッド)の事
    protected function render($variables = [], $template = null, $layaout = 'layout')
    {
        $view = new View(__DIR__ . '/../views');
        // 全て小文字化(クラス名の部分だけ取得（クラス名の~Controllerの部分を削除))

        if (is_null($template)) {
            $template = $this->actionName;
        }

        $controllerName = strtolower(substr(get_class($this), 0, -10));
        $path = $controllerName . '/' . $template;
        // HTMLの情報を返す（layaoutがヘッダー、patyがhtml variablesが変数かなこれらがあれば表示出来る）
        return $view->render($path, $variables, $layaout);


    }
}
