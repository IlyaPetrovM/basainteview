<form enctype="multipart/form-data" action="?p=insert_data" method="POST" >
<table>
<tr><td>
  Имя*:<td>
  <input name="first_name" type="text" required maxlength="45" autofocus required />
  </tr><tr><td>
  Отчество:<td>
  <input name="middle_name" type="text" maxlength="45" />
  </tr><tr><td>
  Фамилия*:<td>
  <input name="last_name" type="text" required maxlength="45" required />
  </tr><tr><td>
  Девичья фамилия:<td>
  <input name="mother_last_name" type="text" maxlength="45" />
  </tr><tr><td>
  Год рождения:<td>
  <input name="year_of_birth" type="number" value=""  max="9999" />
  </tr><tr><td>
  Место рождения:<td>
  <input name="place_of_birth" type="textarea" size=3 maxlength="200"/>
  </tr><tr><td>
  Место частого пребывания:<td>
  <input name="place_of_living" type="textarea" size="3" maxlength="200" />
  </tr><tr>
<td>
  <td>
  <input type="hidden" name="table" value="informant" />
  <input name="update_id" type="hidden" id="update_id_field"/>
	<input type="submit" id="button_submit" value="Записать информанта" />
  </tr>
  </table>
</form>
<script type="text/javascript">

var req;
if (window.XMLHttpRequest) {
  req = new XMLHttpRequest(); 
}
else if (window.ActiveXObject) {
  try { req = new ActiveXObject('Msxml2.XMLHTTP'); } catch (e){alert("exeption!");}
  try { req = new ActiveXObject('Microsoft.XMLHTTP');} catch (e){alert("exeption!");
}
}

if (req) {
    req.onreadystatechange = function() {
      if (req.readyState == 4 && req.status == 200)  
      { 
        var response = req.responseText;
        var arr = req.responseText.split(",");
        console.log(arr, response);
        restoreValues(arr);
      }        
    };  
} else alert("Браузер не поддерживает AJAX");

var update_id = <?php echo $_GET['update_id'] ?>;
if(update_id!="") {
  button_submit.value="Изменить информацию"; 
  update_id_field.value=update_id;
}
var query="SELECT concat_ws(\",\",first_name,middle_name,last_name,IFNULL(mother_last_name,''),IFNULL(year_of_birth,''),IFNULL(place_of_birth,''), IFNULL(place_of_living,'')) FROM informant WHERE id="+update_id;
console.log(query);

    var method= "POST"; 
    var script="select.php";
    req.open(method, script, true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
    req.send("query="+query);

  function restoreValues(a){
    inputs = document.getElementsByTagName("input");
    for(var i=0;i<a.length;++i){
      inputs[i].value = a[i];
    }
  }
</script>