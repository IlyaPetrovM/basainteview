<?php

class TableRows extends RecursiveIteratorIterator { 
	
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
    		$ret = "##".parent::current()."";
        return $ret;
    }
    function beginChildren() { 
        echo "["; 
    } 
    function endChildren() { 
        echo "";
    } 
} 


function execute_query($q, $servername, $dbname, $username, $password){
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

echo $_POST['q'];
if($_POST['q']!=''){

	execute_query($_POST['q'], $_POST["host"], $_POST["dbname"],$_POST["user"],$_POST["pass"]);
}

?>