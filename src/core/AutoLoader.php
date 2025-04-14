<?php

// 各メソッドを最小単位の機能に分けている
class AutoLoader
{
  private $dirs;

    public function register()
    {
        //引数に関数を渡す。今回は処理が長いので無名関数でなく関数にして渡す。
          // 第1引数 クラス名, 第二引数　関数名
        spl_autoload_register([$this, 'loadClass']);
    }

    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    // クラス名が必用になった時に、$classNameはphpが自動で渡す
    private function loadClass($className)
    {
        foreach ($this->dirs as $dir) {
             $file = $dir . '/' . $className . '.php';
            //  引数のファイルが読み込み可能かどうか判定
              //可能であればファイルを読み込んで処理を終了 　
             if (is_readable($file)) {
                require $file;
                return;
             }
        }

    }
}
