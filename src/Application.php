<?php

// ルート設定をRouterで行う
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/contoroller/ShuffleController.php';
require_once __DIR__ . '/contoroller/EmployeeController.php';

// 初期設定を行う？
class Application
{
    public $router;

    public function __construct()
    {
        //urlとcontroller,actionの対応表を渡し、Routerがそれを管理する
            // 引数:url => [controller,action]
        $this->router = new Router($this->registerRoutes());
    }

    public function run()
    {
        // 名前解決　resolveの引数であるパスと、constで設定したコントローラー（アクション？）を紐づけ
            // 引数：パス
            // 返り値 $params = [controller => 〇〇, action => 〇〇];
        $params = $this->router->resolve($this->getPathInfo());
        $controller = $params['controller'];
        $action = $params['action'];
        $this->runAction($controller, $action);
    }

    // controllerの動的生成と実行
    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        $controller = new $controllerClass();
        $controller->run($action);
    }

    // 配列で
    private function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/shuffle' => ['controller' => 'shuffle', 'action' => 'create'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
            '/employee/create' => ['controller' => 'employee', 'action' => 'create']
        ];
    }

    // ブラウザがリクエストするパスの情報を取得
    private function getPathInfo()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
