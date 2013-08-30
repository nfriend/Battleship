<?php
	
	$con = mysql_connect('localhost', 'root', 'whadup');
	mysql_select_db('webserv');
	
	if (!$con)
	{
		echo json_encode(array('success' => "false", 'reason' => "noconnection", 'message' => "Couldn't connect to the database!"));	
		exit();
	}
	
	$grid = mysql_query("SELECT * FROM battleship_grid WHERE name LIKE '" . $_POST["name"] . "'");
	$players = mysql_query("SELECT * FROM battleship_playergrid WHERE name LIKE '" . $_POST["name"] . "'");
	$count = mysql_query("SELECT COUNT(*) 'playercount' FROM battleship_playergrid WHERE name LIKE '" . $_POST["name"]. "'");
	
	if ($grid && $players && $count)
	{
		$playercount = mysql_fetch_assoc($count);
		
		if ($playercount["playercount"] == 0)
		{
			$result = array('success' => "false", 'reason' => 'noresult', 'message' => "No game by the name of '" . $_POST["name"] . "' was found.");
		}
		else
		{
			$rows = array();	
			while ($rows[] = mysql_fetch_assoc($players)) {}	
				
			$result = array('grid' => mysql_fetch_assoc($grid), 
				'playergrid' => $rows, 
				'playercount' => $playercount["playercount"], 
				'success' => "true");	
		}
						
		echo json_encode($result);
	}
	else
	{
		echo json_encode(array('success' => "false", 'reason' => 'mysqlerror', 'message' => 'An error occured while retrieving results'));
	}

?>