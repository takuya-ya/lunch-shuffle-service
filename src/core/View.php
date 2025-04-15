<?php

class View
{
    protected $baseDir;
    public function __construct($baseDir)
    {
       $this->baseDir = $baseDir;
    }

    public function render($path, $variables, $layout = false)
    {
        // extract() 関数は、配列のキーを変数名にして展開するPHPの関数です.
          // 例：['groups'=> []]などが引数に入る。つまり変数の宣言
        extract($variables);

        // 出力バッファリングを開始する関数。
          // バッファしないと、require後に即出力されてレイアウトが崩れる。任意のタイミングで出力できるように一度保存する。
        ob_start();
        // 下記の例　view/$path=(huffle/index.php)とか
        require $this->baseDir . '/' . $path . '.php';
        // バッファの内容を取得して、同時にバッファリングを終了する。
        $content = ob_get_clean();

        ob_start();
        require $this->baseDir . '/' . $layout . '.php';
        $layout = ob_get_clean();

        return $layout;
      }
}
