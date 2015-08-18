<?php

	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	
	// SELECT LIST OF COUNTRIES
	
	try{
		$sql = 'SELECT countryname,countryid FROM countries';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching countries: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$countries[] = array('name' => $row['countryname'],'id' => $row['countryid']);
	}
	
	///////////////////

	// ADD AND EDIT CURRENCIES
	
	// ADD
	if (isset($_GET['addcurrency'])){
		$pageTitle = 'New Currency';
		$action = 'addform';
		$curname = '';
		$acronym = '';
		$id = '';
		$countryid = 0;
		$button = 'Add currency';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
			
		try{
			$sql = 'INSERT INTO currencies SET curname = :name, acronym = :acronym, countryid = :countryid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['curname']);
			$s->bindValue(':acronym', $_POST['acronym']);
			$s->bindValue(':countryid', $_POST['countryname']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding submitted currency.';
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
		
	// SELECT THE LIST OF CURRENCIES //////////////////////////////////////////////////////  
	
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	
	try{
		$sql = 'SELECT cc.countryname as country
					   ,c.acronym
					   ,c.curid
					   ,c.curname
		        FROM currencies c
				INNER JOIN countries cc ON cc.countryid = c.countryid';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching currencies: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$currencies[] = array('country' => $row['country']
							,'acronym' => $row['acronym']
							,'curid' => $row['curid']
							,'curname'=>$row['curname']);
	}
	include 'currencies.html.php';