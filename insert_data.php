<?php
echo "<meta charset='utf-8'><br/>";

$servername = "localhost";
$username = "admin";
$password = "Licey1553";
$dbname = "derevnia";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // begin the transaction
    $conn->beginTransaction();
    // our SQL statements
    $table = $_POST['table'];
    if($table=='interview'){
        $rows = '';
        $interview_id = $_POST['id'];
        foreach ($_POST as $row => $value) {
            if($row!='table' && $value!=''){
                if($row=="informant"){
                    foreach ($_POST['informant'] as $k => $v) {
                        $q_informant .= "; INSERT INTO give (interview_id, informant_id) VALUES ('".$interview_id."','".$v."')";
                    }
                }elseif ($row=="sobiratel") {
                    foreach ($_POST['sobiratel'] as $k => $v) {
                        $q_sobiratel .= "; INSERT INTO take (interview_id, sobiratel_id) VALUES ('".$interview_id."','".$v."')";
                    }
                }else{
                    $rows .= ",".$row;
                    $values .= ",'".$value."'";
                }
            }
        }
        echo "<div><span>Скопируйте название папки с интервью:</span>"; 
        echo  "<br><a href='index.php?l=interview_file_title&col=id&val=$interview_id'><button autofocus>Название папки в базе</button></a>";
        echo $interview_id.' '.$_POST["start_date"].' '.$_POST["informant"][0].', '.$_POST["sobiratel"][0];
        echo "</div>";
        $rows=substr($rows, 1);
        $values=substr($values, 1);
        $q_interview = "INSERT INTO $table ($rows) VALUES ($values)";
        $q_sobiratel = substr($q_sobiratel, 1);
        $query_vis = "<h1>$table</h1><code>$q_interview</code><h2>informant</h2>$q_informant<h2>sobiratel</h2>$q_sobiratel";
        $query = "$q_interview $q_informant; $q_sobiratel ";
    }elseif ($table=='record') {
        $query='';
        $upload_dir = '/var/www/uploads/';
        $interview_id = $_POST['interview_id'];
        echo "<h1>record query</h1><ol id='download_list'>";
        foreach ($_FILES["files"]["error"] as $k => $error) {
            if($error == UPLOAD_ERR_OK){
                $tmp_name = $_FILES["files"]["tmp_name"][$k];
                $basename = basename($_FILES['files']['name'][$k]);
                $ext = pathinfo($basename,PATHINFO_EXTENSION);
                $uploadfile = $upload_dir . $interview_id."_$k.".$ext;
                if(move_uploaded_file($tmp_name, $uploadfile)){
                    echo "<li>Загружено - ".$basename." как ".$uploadfile."</li>";
                    $rows = '';
                    $values = '';
                    
                    foreach ($_POST as $key => $value) {
                        if($key!='files' && $key!='table' && $value!='')
                        {
                            $rows .= ",".$key;
                            $values .= ",'".$value."'";
                        }
                    }
                    $rows=substr($rows, 1);
                    $values=substr($values, 1);
                    $query .= "; INSERT INTO $table ($rows, path) VALUES ($values, '$uploadfile')";
                }else{  
                    echo "<li>Ошибка - ".$basename." как ".$uploadfile."</li>";
                    echo 'Debug info:<pre>';
                    print_r($_FILES);
                    echo '</pre>';
                    break;
                }
            }
        }
        echo "</ol>";
        $query=substr($query, 1);
    }else{
        $rows = '';
        foreach ($_POST as $key => $value) {
            if($key!='table' && $value!='')
            {
                $rows .= ",".$key;
                $values .= ",'".$value."'";
            }
        }
        $rows=substr($rows, 1);
        $values=substr($values, 1);
        $query = "INSERT INTO $table ($rows) VALUES ($values)";
    }
    echo "<p style='color:gray;'>Запрос целиком:</p><code>".$query.'</code>';
    $conn->exec($query);
    $conn->commit();
    echo "<p style='color:green;'>Новая запись успешно создана</p>";
    }
catch(PDOException $e)
    {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "<b style='color:red;'>Ошибка: </b>" . $e->getMessage();
    }

$conn = null;
echo  "<br><a href='index.php'><button>Главная страница</button></a>";
?>