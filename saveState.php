<?php

	$letters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
	$result = array();
	
	$con = mysql_connect('localhost', 'root', 'whadup');
	mysql_select_db('webserv');
	
	mysql_query("BEGIN");
	
	if (!$con)
	{
		echo ("{ \"success\": \"false\", \"query\": \"Couldn't connect to DB\"}");	
		die ('Could not connect: ' . mysql_error());
	}
	
	$query = "DELETE FROM battleship_grid WHERE name LIKE '" . $_POST["gamename"] . "'";	
	mysql_query($query);
	
	$query = "INSERT INTO battleship_grid VALUES ('', '" . $_POST["gamename"] . "', ";
		
	foreach ($letters as $letter)
	{
		for ($i = 1; $i < 21; $i++)
		{
			$query = $query . "'" . $_POST[$letter . $i] . "', ";
			$query = $query . "'" . $_POST[$letter . $i . "_c"] . "', ";
		}
	}	
	
	$query = substr($query, 0,  -2) . ")";	
	
	$result[] = mysql_query($query);	
	
	$query = "DELETE FROM battleship_playergrid WHERE name LIKE '" . $_POST["gamename"] . "'";
	mysql_query($query);
	
	$letters = array("A", "B", "C", "D", "S");	
	
	for ($i = 0; $i < intval($_POST["playercount"], 10); $i++)
	{
		$grid_query = "INSERT INTO battleship_playergrid VALUES ('', '" . $_POST["gamename"] . "', '" . $_POST["P" . $i . "NAME"] . "', '" . $i . "', ";
		//$grid_query = "INSERT INTO battleship_playergrid VALUES ('', 'nathan', , '" . $i . "', ";	
				
		foreach($letters as $letter)
		{
			for ($j = 0; $j < 5; $j++)
			{
				if (array_key_exists("P" . $i . $letter . $j, $_POST))				
				{
					$grid_query = $grid_query . "'" . $_POST["P" . $i . $letter . $j] . "', ";
					$grid_query = $grid_query . "'" . $_POST["P" . $i . $letter . $j . "_c"] . "', ";
				}
			}
		}
		
		$grid_query = substr($grid_query, 0,  -2) . ")";
		
		$result[] = mysql_query($grid_query);
	}
	
	
	$noErrors = true;
	
	foreach ($result as $r)
	{
		if (! $r)
		{
			$noErrors = false;
		}
	}
	
	if ($noErrors)
	{
		mysql_query("COMMIT");	
		echo ("{ \"success\": \"true\"}");
		
	}
	else 
	{
		mysql_query("ROLLBACK");
		echo ("{ \"success\": \"false\", \"query\": \"" . print_r($_POST, true) . "\"}");
	}
	
	
?>