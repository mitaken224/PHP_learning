<?php
function alphanum_check($data){
    //入力値チェック
    //半角英数字(a-z, A-Z, 0-9)の場合、TRUEを返す
    if (preg_match('/^[a-zA-Z0-9]+$/', $data)){
        return TRUE;
    } else {
        return FALSE;
    }
}
?>