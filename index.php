
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Добавление интервью</title>
    <meta content="">
  </head>
  <style type="text/css">
  /* http://colorscheme.ru/#0M40Gjriiw0w0 */
    body{
        margin: 1em auto;
        width: 100%;
        text-align: center;
      }
        select, input{
            display: block;
            margin: 1em auto;
            background-color: white;
            border-radius: 1em;
            border-style: none;
            width: 60%;
            text-align: center;
        }
        button {
            display: block;
            margin: 1em auto;
            border-radius: 1em;
            border-style: none;
            text-align: center;
          background-color: black;
          color: #C8AE85;
          min-width: 20%;
          padding: 0 1em;
          height: 2em;
          font-weight: bold;
        }
        button:hover, nav a:hover, input:hover{
            background-color: #6D593C;
        }
      nav, form{
            padding: 0.5em 1em;
            margin: 0 auto;
            max-width: 900px;
            background-color: #C8AE85;
            border-radius: 2em;
            border-style: none;
            display: block;
      }
      table {
        max-width: 100%;
        width: 900px;
        margin: 0 auto;
      }
      nav ul {
        list-style: none;
      }
      nav ul li{
        display: inline-block;
        margin: 0 5px;
      }
      td {
        border-radius: 3px;
      }
      tr:hover{
        background-color: #ccc;
      }
      nav a {
        background-color: white;
        padding: 5px;
        line-height:25pt;
        border-radius: 1em;
        text-decoration: none;
        color: #a00;
      }

  </style>
  <body>
  <nav><?php include 'menu.php'; ?> </nav>
  <h1><?php $page=$_GET["p"]; $lst = $_GET['l']; echo ($page.$lst); ?></h1> 
  <?php include (htmlspecialchars($page).'.php'); 
    if($lst!=""){
      include "select_table.php";
      exec_quer("SELECT * FROM $lst");
    }
    ?>
  </body>
</html>