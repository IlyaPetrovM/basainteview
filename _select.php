<?php

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }
    function current() {
        return "" . parent::current(). "";
    }
    function beginChildren() { 
        echo ""; 
    } 
    function endChildren() { 
        echo "";
    } 
} 


function execute_query($q){
	$servername = "mysql85.1gb.ru";
    $dbname = "gb_x_basaibb2";
    $username = "gb_x_basaibb2";
    $password = "d56e8689z23";
	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $stmt = $conn->prepare($q); 
	    $stmt->execute();

	    // set the resulting array to associative
	    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
	    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
	        echo $v;
	    }
	}
	catch(PDOException $e) {
	    echo "Error: " . $e->getMessage();
	}
	$conn = null;
}

if($_GET['query']!=''){
	execute_query($_GET['query']);
}
if($_POST['query']!=''){
	execute_query($_POST['query']);
}

?>