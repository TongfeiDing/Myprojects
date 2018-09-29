<?php

	 function uploadimage($path, $filetag){
		 $file_path = $path.basename($_FILES[$filetag]['name']);
		 if( move_uploaded_file($_FILES[$filetag]['tmp_name'], $file_path))
			 return $file_path;
		 else
			 return null;
	 }

?>
