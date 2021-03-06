<?php
class TableHeader extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }
    function current() {
        $l = $_GET['l'];
        $s = $_GET['sort'];
        $col = $_GET['col'];
        if($s=="DESC"){
            $s="ASC"; 
        }else{
            $s="DESC";
        }
        return "<th><a href='?l=$l&ob=".parent::current()."&sort=$s' class='thead $s'>" . parent::current(). "</a></th>";
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
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>";
    } 
} 
function exec_quer($query,$h){
    $servername = "mysql85.1gb.ru";
    $dbname = "gb_x_basaibb2";
    $username = "gb_x_basaibb2";
    $password = "d56e8689z23";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $head = $conn->prepare($h); 
        $head->execute();
        $stmt = $conn->prepare($query); 
        $stmt->execute();

    echo '<table>';
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