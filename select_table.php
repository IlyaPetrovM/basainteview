<?php
class TableHeader extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        $l = $_GET['l'];
        $s = $_GET['sort'];
        $col = $_GET['col'];
        if($s=="ASC"){
            $s="DESC";
        }else
            $s="ASC";
        return "<td><a href='?l=$l&ob=".parent::current()."&sort=$s' class='thead $s'>" . parent::current(). "</a></td>";
    }

    function beginChildren() { 
        echo '<tr>'; 
    } 

    function endChildren() { 
        echo "</tr>";
    } 
} 
class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo '<tr>'; 
    } 

    function endChildren() { 
        echo "</tr>";
    } 
} 
function exec_quer($query,$h){
    $servername = "localhost";
    $username = "user";
    $password = "Licey1553";
    $dbname = "derevnia";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $head = $conn->prepare($h); 
        $head->execute();
        $stmt = $conn->prepare($query); 
        $stmt->execute();

    echo '<table border="1">';
        $result2 = $head->setFetchMode(PDO::FETCH_ASSOC); 
        // set the resulting array to associative
        foreach(new TableHeader(new RecursiveArrayIterator($head->fetchAll(PDO::FETCH_COLUMN))) as $k=>$v) {
            echo $v;
        }
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
    echo '</table>';
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
?>