<?php

require_once "main.php";

function ExtractSecondsFromAudio_QQ ( $input_file, $length, $output_name, $show_file_details = false ) {

	$allowedExts = array("mp3", "wma");
	$extension = pathinfo($input_file["name"], PATHINFO_EXTENSION);
	
	if (in_array($extension, $allowedExts)) {

		  if ($input_file["error"] > 0)  {

		  	return "Return Code: " . $input_file["error"] . "<br />";

	    } else  {

	    	$file_opt = [

	    		"code"			=>		200,
	    		"status"		=>		'Clip was generated successfully',
	    		"Upload"		=>		$input_file["name"],
			    "Type"		=>		$input_file["type"],
			    "Size"		=>		($input_file["size"] / 1024) . " Kb",
			    "Temp file"	=>		$input_file["tmp_name"],
			    "Stored in"		=>		"upload/" . $output_name,

	    	];

	      	move_uploaded_file($input_file["tmp_name"], "upload/" . $output_name);

	    }

	  } else {

	  		return "Invalid file";

	  }

	//Extract seconds
	if($length > 0) :

		$mp3 = new PHPMP3("upload/" . $input_file["name"]);
		$mp3_1 = $mp3->extract(0,$length);
		$mp3_1->save("upload/$output_name");

		return ($show_file_details) ? json_encode($file_opt) : "Clip was generated successfully";

	else:

		return "Please select a valid number";

	endif;

}


if ( isset($_POST['ok']) ) :

		$seconds = $_POST['seconds'];
		$audio_path = $_FILES["file"];
		$output_name = "output.mp3";
		echo ExtractSecondsFromAudio_QQ($audio_path, $seconds, $output_name);

endif;

?>