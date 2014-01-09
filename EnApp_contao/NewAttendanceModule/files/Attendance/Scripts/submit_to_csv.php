<?php
  session_start();
  $file_name = $_SESSION['file_name'];
  $att_array = $_POST['attendance'];
  $data = array();
  array_push($data,date('m-d-y'));
  foreach($att_array as $val){
	if ($val == "1"){
		array_push($data, "1");
	} 
	else{
		array_push($data, "0");
	}
  }
  
  $counter = 0;
  $newCsvData = array();
  if (($handle = fopen($file_name, "r")) !== FALSE) {
    while (($line = fgetcsv($handle)) !== false){
		if ($counter == 0){
			$line[] = date('m-d-y');
		}
		else{
			$line[]=$data[$counter];
		}
		$newCsvData[] = $line;
		$counter++;	
	}
  }
  
  fclose($handle);
  
  $handle = fopen($file_name, 'w');
	foreach ($newCsvData as $line) {
		fputcsv($handle, $line);
	}

fclose($handle);

  
?>