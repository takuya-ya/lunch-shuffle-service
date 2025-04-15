<?php

class Request
{
    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }

        return false;
    }

    // ブラウザがリクエストするパスの情報を取得
      // Applicationで定義していたが、リクエストに関する処理の為、Requestクラスで管理
    public function getPathInfo()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
