<?php

// ルート設定をRouterで行う
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/HttpNotFoundException.php';
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
        try {
            $params = $this->router->resolve($this->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundException();
            };
            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) {
            $this->render404Page();
        }

    }

    // controllerの動的生成と実行
    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundException();
        }
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

    private function render404Page()
    {
        //HTTPレスポンスのステータスコードを「404 Not Found」に設定するためのPHPコードです。
        header('HTTP/1.1 404 Page Not Found');
        $content = <<<EOF

        <!DOCTYPE html>
        <html lang="ja">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404</title>
        </head>

        <body>
            <h1>
                404 Page Not Found.
            </h1>
        </body>
        </html>
EOF;
        echo $content;
    }
}
