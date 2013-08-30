<?php
	
	$con = mysql_connect('localhost', 'root', 'whadup');
	mysql_select_db('webserv');
	
	if (!$con)
	{
		die ('Could not connect: ' . mysql_error());
	}
	
	$result = mysql_query("SELECT name FROM battleship_grid");
	
	$allNames = array();
	while($row = mysql_fetch_assoc($result))
	{
		$allNames[] = $row['name'];
	}
	
	echo json_encode($allNames);

?>