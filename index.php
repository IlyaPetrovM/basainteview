
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>База интервью
    </title>
    <meta content="">
  <link type="text/css" href="style.css" rel="stylesheet" />
  <!-- <link type="text/javascript" href="ajax.js" rel="script" /> -->
  </head>
  <body>
  <nav><?php include 'menu.php'; ?> </nav>
  <h1>
  <?php 
    $titles = array(
    'sobiratel' => 'Собиратели',
    'view_informant'=>'Информанты',
    'view_interview'=>'Интервью',
    'add_sobiratel' => 'Добавить собирателя',
    'add_informant'=>'Добавить информанта',
    'meetings' => 'Встречи',
    'add_interview'=>'Добавить интервью',
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
  </body>
</html>