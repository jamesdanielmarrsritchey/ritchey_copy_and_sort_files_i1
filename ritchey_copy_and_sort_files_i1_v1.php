<?php
# Meta
// Name: Ritchey Copy And Sort Files i1 v1
// Description: Returns an array (with a sub-array) on success. Returns "FALSE" on failure.
// Notes: Optional arguments can be "NULL" to skip them in which case they will use default values.
// Arguments: Source Folder (required) is the folder to copy files from. Destination folder (required) is the folder to copy files to (it doesn't need to exist, but its parents do). Sort Year (optional) specifies whether to create a year folder. Sort Month (optional) specifies whether to create a month folder. Sort Day (optional) specifies whether to create a day folder. Display Errors (optional) specifies if errors should be displayed after the function runs.
// Arguments (For Machines): source_folder: path, required. destination_folder: path, required. sort_year: bool, optional. sort_month: bool, optional. sort_day: bool, optional. display_errors: bool, optional.
# Content
if (function_exists('ritchey_copy_and_sort_files_i1_v1') === FALSE){
function ritchey_copy_and_sort_files_i1_v1($source_folder, $destination_folder, $sort_year = NULL, $sort_month = NULL, $sort_day = NULL, $display_errors = NULL){
	## Prep
	$errors = array();
	$location = realpath(dirname(__FILE__));
	if (@is_dir($source_folder) === FALSE){
		$errors[] = "source_folder";
	}
	if (@is_dir(dirname($destination_folder)) === FALSE){
		$errors[] = "destination_folder";
	}
	if ($sort_year === NULL){
		$sort_year = FALSE;
	} else if ($sort_year === TRUE){
		// Do nothing
	} else if ($sort_year === FALSE){
		// Do nothing
	} else {
		$errors[] = "$sort_year";
	}
	if ($sort_month === NULL){
		$sort_month = FALSE;
	} else if ($sort_month === TRUE){
		// Do nothing
	} else if ($sort_month === FALSE){
		// Do nothing
	} else {
		$errors[] = "$sort_month";
	}
	if ($sort_day === NULL){
		$sort_day = FALSE;
	} else if ($sort_day === TRUE){
		// Do nothing
	} else if ($sort_day === FALSE){
		// Do nothing
	} else {
		$errors[] = "$sort_day";
	}
	if ($display_errors === NULL){
		$display_errors = TRUE;
	} else if ($display_errors === TRUE){
		// Do nothing
	} else if ($display_errors === FALSE){
		// Do nothing
	} else {
		$errors[] = "display_errors";
	}
	## Task
	if (@empty($errors) === TRUE){
		### Create a list of files in source_folder, and copy them to destination_folder, applying the set sorting structure.
		$location = realpath(dirname(__FILE__));
		require_once $location . '/dependencies/ritchey_list_files_with_prefix_postfix_i1_v1/ritchey_list_files_with_prefix_postfix_i1_v1.php';
		$files = ritchey_list_files_with_prefix_postfix_i1_v1($source_folder, NULL, NULL, TRUE);
		foreach($files as &$item){
			$file_name = basename($item);
			$year_modified = date ("Y", filemtime($item));
			$month_modified = date ("F", filemtime($item));
			$day_modified = date ("j", filemtime($item));
			$directory_structure = array();
			if ($sort_year === TRUE){
				$directory_structure[] = $year_modified;
			}
			if ($sort_month === TRUE){
				$directory_structure[] = $month_modified;
			}
			if ($sort_day === TRUE){
				$directory_structure[] = $day_modified;
			}
			if (@empty($directory_structure) === FALSE){
				$destination_file = $destination_folder . '/' . implode('/', $directory_structure) . '/' . $file_name;
				$destination_path = $destination_folder . '/' . implode('/', $directory_structure);
			} else {
				$destination_file = $destination_folder . '/' . $file_name;
				$destination_path = $destination_folder;
			}
			//var_dump($files);
			//var_dump($destination_file);
			//var_dump($destination_path);
			@mkdir($destination_path, 0777, true);
			if (is_dir($destination_path) !== TRUE){
				$errors[] = "Create '{$destination_path}'";
				goto cleanup;
			}
			if (is_file($destination_file) !== FALSE){
				$errors[] = "Already exists '{$destination_file}'";
				goto cleanup;
			}
			if (copy($item, $destination_file) !== TRUE){
				$errors[] = "Create '{$destination_file}'";
				goto cleanup;
			}
			$item = array("source_file" => $item, "destination_file" => $destination_file);
		}
		unset($item);
	}
	//echo "Memory Usage: " . memory_get_usage() . " bytes" . PHP_EOL;
	cleanup:
	## Cleanup
		// Do nothing
	result:
	## Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('ritchey_copy_and_sort_files_i1_v1_format_error') === FALSE){
				function ritchey_copy_and_sort_files_i1_v1_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("ritchey_copy_and_sort_files_i1_v1_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	## Return
	if (@empty($errors) === TRUE){
		return $files;
	} else {
		return FALSE;
	}
}
}
?>