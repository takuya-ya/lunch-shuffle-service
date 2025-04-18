<?php

// ルート設定をRouterで行う

// 初期設定を行う？
class Application
{
    // このクラスで使用するのと、他のクラスにも汎用的に渡す事が出来る為、初期化をお粉う
    public $request;

    protected $router;
    protected $response;

    public function __construct()
    {
        //urlとcontroller,actionの対応表を渡し、Routerがそれを管理する
            // 引数:url => [controller,action]
        $this->request = new Request();
        $this->router = new Router($this->registerRoutes());
        $this->response = new Response();
    }

    public function run()
    {
        // 名前解決　resolveの引数であるパスと、constで設定したコントローラー（アクション？）を紐づけ
            // 引数：パス
            // 返り値 $params = [controller => 〇〇, action => 〇〇];
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundException();
            };
            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) {
            $this->render404Page();
        }

        $this->response->send();
    }

    // controllerの動的生成と実行a
    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundException();
        }
        // Applicationクラスを渡す。Resposeや他の情報を渡したいとなる可能性があるので、それらを所持するこのクラスを渡している。
        $controller = new $controllerClass($this);
        $content = $controller->run($action);
        $this->response->setContent($content);
    }

    // 配列で
    private function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/shuffle' => ['controller' => 'shuffle', 'action' => 'index'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
            '/employee/create' => ['controller' => 'employee', 'action' => 'create']
        ];
    }

    private function render404Page()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->setContent(
            <<<EOF
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
EOF
        );
    }
}
