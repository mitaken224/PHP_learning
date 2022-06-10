<?php
require('utils.php');

$input_data = "test";

if(alphanum_check($input_data)){
    echo "OK";
} else {
    echo "ERROR";
}
?>