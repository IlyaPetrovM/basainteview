
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>База интервью
    </title>
    <meta content="">
  <link type="text/css" href="style.css" rel="stylesheet" />
  
  </head>
  <body>
  <nav><?php include 'menu.php'; ?> </nav>
  <h1>
  <?php 
    $titles = array(
    'sobiratel' => 'Собиратели',
    'informant'=>'Информанты',
    'view_interview'=>'Интервью',
    'add_sobiratel' => 'Добавить собирателя',
    'add_informant'=>'Добавить информанта',
    'meetings' => 'Встречи',
    'add_interview'=>'Добавить интервью',
    "insert_data" => "Редактировать"
    );

    $lst=$_GET["l"];
    $page=$_GET["p"];
    echo ($titles[$lst].$titles[$page]); 
  ?>
  </h1> 

    <?php 

    if($page!="") include (htmlspecialchars($page).'.php'); 
    if($lst!=""){
      $col = $_GET['col'];
      $val = $_GET['val'];
      $order_by = "";
      if($_GET['ob']!=""){
        $order_by = " ORDER BY `".$_GET['ob']."`".' '.$_GET['sort'];
      }

      $where = "";
      if($col != "" && $val != ""){
          $where = " WHERE ".$col." LIKE '".$val."'";
      }
      include "select_table.php";
      $q="SELECT * FROM ".$lst.$where.' '.$order_by;

      exec_quer($q,"describe ".$lst);
    }
    ?>
    <script type="text/javascript" src="ajax.js" ></script>
    <script type="text/javascript">
    if (selectReq) {
      selectReq.onreadystatechange = function() {
      if (selectReq.readyState == 4 && selectReq.status == 200)  
      { 
        var sel = selectReq.responseText;
        table = parseTable(sel);      
      }
      };
    } else alert("Браузер не поддерживает AJAX / AJAX is not supported");
    exec_select("select * from interview", "localhost", "derevnia", "user", "Licey1553");
    </script>
  </body>
</html>