<?php

//エラー内容を区別する為にExceptionを継承したクラスを作成。メソッドは不要（らしい）
class HttpNotFoundException extends Exception
{
};
