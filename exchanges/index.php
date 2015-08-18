<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
	
	if(isset($_POST['action']) and $_POST['action'] == 'Delete'){

		try{
			$sql = 'SELECT qid FROM quotes WHERE exchid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id',$_POST['id']);
			$s->execute();
		}
		catch(PDOException $e){
			$error = 'Error fetching quotes: ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		$result = $s->fetchAll();
		
		// DELETE rates ///////////////////////////
		try{
			$sql = 'DELETE FROM rates WHERE quoteid = :qid';
			$s = $pdo->prepare($sql);
			foreach($result as $row){
				$s->bindValue(':qid',$row['qid']);
				$s->execute();
			}
        }			
		catch(PDOException $e){
			$error = 'Error deleting rates: ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		
		// DELETE quotes ///////////////////////////
		try{
			$sql = 'DELETE FROM quotes WHERE exchid = :exchid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':exchid',$_POST['id']);
			$s->execute();
        }			
		catch(PDOException $e){
			$error = 'Error deleting quotes: ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		
		// DELETE exchanges //////////////////////////////////////
		
		try{
			$sql = 'DELETE FROM exchanges WHERE exchid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id',$_POST['id']);
			$s->execute();
        }			
		catch(PDOException $e){
			$error = 'Error deleting exchanges: ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		
		header('Location: .');
		exit();
		
	}
	
	// ADD AND EDIT EXCHANGES
	
	// ADD
	if (isset($_GET['addexchange'])){
		$pageTitle = 'New Exchange';
		$action = 'addform';
		$name = '';
		$web = '';
		$id = '';
		$button = 'Add exchange';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['addform'])){
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
		try{
			$sql = 'INSERT INTO exchanges SET exchname = :name, web = :web';
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':web', $_POST['web']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding submitted exchange.';
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
			$sql = 'SELECT exchid, exchname, web FROM exchanges WHERE exchid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error fetching exchange details.';
			include 'error.html.php';
			exit();
		}
		$row = $s->fetch();
		$pageTitle = 'Edit Exchange';
		$action = 'editform';
		$name = $row['exchname'];
		$web = $row['web'];
		$id = $row['exchid'];
		$button = 'Update exchange';
		include 'form.html.php';
		exit();
	}
	
	if (isset($_GET['editform'])){
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
		try{
			$sql = 'UPDATE exchanges SET exchname = :name,web = :web WHERE exchid = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':web', $_POST['web']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error updating submitted exchange.';
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}
	
	// SELECT THE LIST OF EXCHANGES //////////////////////////////////////////////////////  
	
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_new.inc.php';
	
	try{
		$sql = 'SELECT exchid,exchname FROM exchanges';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e){
		$error = 'Error fetching exchanges: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	foreach($result as $row){
		$exchanges[] = array('id' => $row['exchid'],'name' => $row['exchname']);
	}
	include 'exchanges.html.php';