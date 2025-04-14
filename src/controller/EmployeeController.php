<?php


class EmployeeController extends Controller
{
    public function index()
    {
        $errors = [];

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



        $mysqli->close();

        // データ追加後、即座に一覧に反映。また、POSTの重複によるデータの二重登録を防止
        // 登録ボタン推してもリロードはされない。
        include __DIR__ . '/../views/employee.php';

    }



    public function create()
    {

        $errors = [];

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


        // $_POSTは配列なのでキー名指定が必用　指定が無いと常にfalseになる
        if ($_POST['name'] === '') {
            $errors['name'] = '社員名を入力してください';
            // $_POSTは配列なのでキー名指定が必用
        } elseif (mb_strlen($_POST['name']) > 100) {
            $errors['name'] = '100文字以内で入力してください';
        }

        // $errorsが無ければデータを登録
        if (!count($errors)) {
            $name = $_POST['name'];
            $addData = 'INSERT INTO employees (name) VALUES (?)';

            $stmt = $mysqli->prepare($addData);
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->close();
            header('Location: /employee');

            $mysqli->close();

            // データ追加後、即座に一覧に反映。また、POSTの重複によるデータの二重登録を防止
            // 登録ボタン推してもリロードはされない。
            include __DIR__ . '/../views/employee.php';
        }
    }
}
