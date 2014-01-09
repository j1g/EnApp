<?php
session_start();
$file_name = $_SESSION['file_name'];

if (($f = fopen($file_name, "r")) != FALSE);
{
    echo"<form action='submit_to_csv.php' method='post'>";
    echo "<html><body><table border = \"1\">\n\n";
    echo "<tr><td><b>Name</b></td><td><b>". date('m-d-y'). "</b></td></tr>";
	$number = 0;
	$numberLines=0;
	while (($line = fgetcsv($f)) !== false) {
			$count=0;
			if ($numberLines==0){
				$numberLines++;
				continue;
			}
			echo "<tr>";
			foreach ($line as $cell ) 
			{
			    
				if($count<1)
				{    
					echo "<td align =\"center\">" . htmlspecialchars($cell) . "</td><td align =\"center\"><input type='hidden' name='attendance[$number]' value='0' /><input type='checkbox' name = 'attendance[$number]' value='1' /></td>";				
					$count++; 
					$number++; 
				}
				
			}
			echo "<tr>\n";
	}
	fclose($f);
	echo "\n</table></body></html>";
	
	echo "<input type='submit' value='Submit' name='submit_button' />";
	echo "</form>";
}
?>