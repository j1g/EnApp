<?php
session_start();
$file_name = "attendance.csv";
$_SESSION['file_name'] = $file_name;

echo "<html><body><table border = \"1\">\n\n";

if (($file_handle = fopen($file_name, "r")) != FALSE);
{

	while (($line = fgetcsv($file_handle)) !== false) {
			echo "<tr>";
			
			foreach ($line as $cell) {
					echo "<td align =\"center\">" . htmlspecialchars($cell) .  "</td>";
			}
			echo "</tr>\n";
			
	}
	echo "\n</table></body></html>";
	fclose($file_handle);
	echo"<form action='this_page.php' method='post'>";
	echo "<input type='submit' value='Create new column' name='submit_button' />";
	echo "</form>";
}

?>
