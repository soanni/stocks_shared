<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	// ADD AND EDIT COUNTRIES
	
	// ADD
	if (isset($_GET['addcountry'])){
		$pageTitle = 'New Country';
		$action = 'addform';
		$countryname = '';
		$acronym = '';
		$id = '';
		$button = 'Add country';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
		try{
			$sql = 'INSERT INTO countries SET countryname = :name, acronym = :acronym';
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['countryname']);
			$s->bindValue(':acronym', $_POST['acronym']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding submitted country.';
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
	
	//EDIT
	if (isset($_POST['action']) and $_POST['action'] == 'Edit'){
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
		try{
			$sql = 'SELECT countryid, countryname, acronym FROM countries WHERE countryid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error fetching country details.';
			include 'error.html.php';
			exit();
		}
		$row = $s->fetch();
		$pageTitle = 'Edit Country';
		$action = 'editform';
		$countryname = $row['countryname'];
		$acronym = $row['acronym'];
		$id = $row['countryid'];
		$button = 'Update country';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['editform'])){
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
		try{
			$sql = 'UPDATE countries SET countryname = :name,acronym = :acronym WHERE countryid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->bindValue(':name', $_POST['countryname']);
			$s->bindValue(':acronym', $_POST['acronym']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error updating submitted country.';
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
	
	// SELECT THE LIST OF EXCHANGES //////////////////////////////////////////////////////  
	
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	
	try{
		$sql = 'SELECT countryid,countryname,acronym FROM countries';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching countries: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$countries[] = array('countryid' => $row['countryid']
							,'countryname' => $row['countryname']
							,'acronym' => $row['acronym']);
	}
	include 'countries.html.php';