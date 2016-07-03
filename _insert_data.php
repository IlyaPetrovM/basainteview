<?php
echo "<meta charset='utf-8'><br/>";
include 'select.php';
function sqlTransact($query, $servername, $dbname, $username, $password){
    try {
        // begin the transaction
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $conn->exec($query);
        $conn->commit();
        echo "<p style='color:green;'>Данные успешно отредактированы</p>";
        }
    catch(PDOException $e)
        {
        // roll back the transaction if something failed
        $conn->rollback();
        echo "<b style='color:red;'>Ошибка: </b>" . $e->getMessage();
        echo "<p style='color:gray;'>Запрос целиком:</p><code>".$query.'</code>';
        }

    $conn = null;
    
}

$table = $_POST['table'];
if($table=='interview'){
    $update_id= $_POST['update_id'];
    $rows = '';
    $interview_id = $_POST['id'];
    if($update_id==""){
        foreach ($_POST as $row => $value) {
            if($row!='table' && $value!='' && $row!='update_id'){
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
        $rows=substr($rows, 1);
        $values=substr($values, 1);
        $q_interview = "INSERT INTO $table ($rows) VALUES ($values)";
        $q_sobiratel = substr($q_sobiratel, 1);
        $query_vis = "<h1>$table</h1><code>$q_interview</code><h2>informant</h2>$q_informant<h2>sobiratel</h2>$q_sobiratel";
        $query = "$q_interview $q_informant; $q_sobiratel ";
    }else{
        $interview_id = $update_id;
        foreach ($_POST as $row => $value) {
            if($row!='table' && $value!='' && $row!='update_id'){
                if($row=="informant"){
                    foreach ($_POST['informant'] as $k => $v) {
                        $q_informant .= "; INSERT INTO give (interview_id, informant_id) VALUES ('".$update_id."','".$v."')";
                    }
                }elseif ($row=="sobiratel") {
                    foreach ($_POST['sobiratel'] as $k => $v) {
                        $q_sobiratel .= "; INSERT INTO take (interview_id, sobiratel_id) VALUES ('".$update_id."','".$v."')";
                    }
                }else{
                    $statements .= ",".$row."='".$value."'";
                }
            }
        }
        $deletions = "DELETE FROM give WHERE interview_id='$update_id'; DELETE FROM take WHERE interview_id='$update_id';";
        $statements=substr($statements, 1);
        $q_interview = "UPDATE $table SET $statements WHERE id='$update_id'";
        $q_sobiratel = substr($q_sobiratel, 1);
        $query = "$deletions $q_interview $q_informant; $q_sobiratel ";
    }
}
    elseif ($table=='record') {
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
    }
    else{
        $rows = '';
        $statements ='';
        $query='';
        foreach ($_POST as $key => $value) {
            if($key!='table' && $value!='' && $key!='update_id')
            {
                $statements .= ",".$key."='".$value."'";
                $rows .= ",".$key;
                $values .= ",'".$value."'";
            }
        }
        $rows=substr($rows, 1);
        $values=substr($values, 1);
        $statements=substr($statements, 1);

        $update_id= $_POST['update_id'];
        if($update_id!=''){
            $query = "UPDATE $table SET $statements WHERE id='$update_id'";
        }else{
            $query = "INSERT INTO $table ($rows) VALUES ($values)";
        }
    }
sqlTransact($query, "mysql85.1gb.ru","gb_x_basaibb2","gb_x_basaibb2","d56e8689z23");
if($table=="interview"){
    echo "<h2>Название для папки в базе:</h5><p id=interview_file_title>";
    execute_query("SELECT `Название папки` from interview_file_title where `Номер` like '$interview_id'");
    echo "</p>";
}
?>