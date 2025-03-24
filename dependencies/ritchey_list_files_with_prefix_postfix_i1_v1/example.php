<?php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_list_files_with_prefix_postfix_i1_v1.php';
$return = ritchey_list_files_with_prefix_postfix_i1_v1("{$location}", NULL, '.txt', TRUE);
if ($return == TRUE){
	print_r($return);
} else {
	echo "FALSE\n";
}
?>