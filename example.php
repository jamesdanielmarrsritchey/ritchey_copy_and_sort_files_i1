<?php
# App.php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_copy_and_sort_files_i1_v1.php';
$return = ritchey_copy_and_sort_files_i1_v1("{$location}/temporary/Original", "{$location}/temporary/Copy", TRUE, TRUE, TRUE, NULL);
if (@is_array($return) === TRUE){
	print_r($return);
} else {
	echo "FALSE" . PHP_EOL;
}
?>