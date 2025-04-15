<?php

class ShuffleController extends Controller
{
    public function index()
    {

        // DBに接続
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');

        // 接続エラーのバリデーション
            // connect_error 接続エラーの内容（文字列）を返すプロパティ
        if ($mysqli->connect_error) {
            // PHP組み込み例外クラス:「実行時に予期せぬ問題が発生」を表示
            throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
        }

        return $this->render([
                'groups' => [],
        ]);
        //ビューと分離する以前は下記でビューを表示していた
        // include __DIR__ . '/../views/index.php';
    }


    public function create()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }
        
        $groups = [];

        // DBに接続
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');

        // 接続エラーのバリデーション
            // connect_error 接続エラーの内容（文字列）を返すプロパティ
        if ($mysqli->connect_error) {
            // PHP組み込み例外クラス:「実行時に予期せぬ問題が発生」を表示
            throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
        }

        $result = $mysqli->query('SELECT name FROM employees;');
        $employees = $result->fetch_all(MYSQLI_ASSOC);
        shuffle($employees);

        // 2名のグループで余る人の有無を確認
        $cnt = count($employees);

        if ($cnt % 2 === 0 ) {
            $groups =  array_chunk($employees, 2);
        } else {
            // var_dump($groups);
            $extra = array_pop($employees);
            $groups = array_chunk($employees, 2);
            array_push($groups[0], $extra);
        }


        return $this->render([
            'groups' => $groups,
        ], 'index' //このindexがtemplate。これがないとactiono()メソッドのcreateがtemplateとして渡されるが、該当するview fileは作成していない。index.phpと同じため、それを流用する。
    );
        // include __DIR__ . '/../views/index.php';
    }
}
