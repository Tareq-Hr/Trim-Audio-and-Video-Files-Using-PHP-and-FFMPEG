<?php


function ExtractSecondsFromVideo_QQ ( $input_file, $length, $output_name, $show_file_details = false ) {

  $allowedExts = array("mp4");
  $extension = pathinfo($input_file["name"], PATHINFO_EXTENSION);
  
  if (in_array($extension, $allowedExts)) {

      if ($input_file["error"] > 0)  {

        return "Return Code: " . $input_file["error"] . "<br />";

      } else  {

        $file_opt = [

          "code"      =>    200,
          "status"    =>    'Clip was generated successfully',
          "Upload"    =>    $input_file["name"],
          "Type"    =>    $input_file["type"],
          "Size"    =>    ($input_file["size"] / 1024) . " Kb",
          "Temp file" =>    $input_file["tmp_name"],
          "Stored in"   =>    "upload/" . $output_name,

        ];

          move_uploaded_file($input_file["tmp_name"], "origin/" . $output_name);

      }

    } else {

        return "Invalid file";

    }

  //Extract seconds
  if($length > 0) :

    $path = "origin/".$output_name;
    $results = null;
    $retval = 0;
    exec("ffmpeg -ss 00:00:00 -to 00:00:$length  -i $path -c copy crop/$output_name", $results, $retval);

    return ($show_file_details) ? json_encode($file_opt) : "Clip was generated successfully";

  else:

    return "Please select a valid number";

  endif;

}

  if ( isset($_POST['ok']) ) :

    $ref = 'MAPTV_'.date('d').date('m').date('Y').'_'.date('H').date('i').microtime(true)*10000;
    $value = $ref.'_MAP.mp4';
    $seconds = $_POST['seconds'];
    $video_path = $_FILES["file"];
    //$output_name = "output9.mp4";
    echo ExtractSecondsFromVideo_QQ($video_path, $seconds, $value, true);

  endif;