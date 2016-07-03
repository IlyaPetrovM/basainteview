<?php include "select.php" ?>
<script type="text/javascript">
    var updateIdRequest;

  if (window.XMLHttpRequest) updateIdRequest = new XMLHttpRequest(); 
  else if (window.ActiveXObject) {
    try {
      updateIdRequest = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (e){
    alert("exeption!");
    }
    try {
    updateIdRequest = new ActiveXObject('Microsoft.XMLHTTP');
    } catch (e){
    alert("exeption!");
    }
  }
</script>
<form enctype="multipart/form-data" action="?p=insert_data" method="POST" >
<table>
<tr>
<td>
  <label for='place_id'>Населённый пункт</label>
  <td>
  <input type="text" name="place_id" id="place" onchange="update_place();" required disabled value='
   <?php execute_query("SELECT address FROM place as p
                          WHERE p.id=
                          (
                            select place_id 
                            from interview as i
                            WHERE (i.id like \"$_GET[update_id]\")
                          );
                      ");
   ?>
  ' />
  <td></td>
</tr>
<tr>
<td>
  <label for='update_id'>Номер интервью</label>
  <td>
  <input name="update_id" id="interview_id" type="text" maxlength="4" required  value="<?php echo $_GET[update_id] ?>" readonly />
  <td>
</tr>
<tr>
<td>
  <label for='start_date'> Дата интервью</label>
  <td>
  <input name="start_date" type="date" value='<?php execute_query("select start_date from interview WHERE id = \"$_GET[update_id]\""); ?>' required />
  <td>
  <a class=helper onclick="setYesterday()" >Вчера </a>
  <a class=helper onclick="setToday()" >Сегодня</a>
  </td>
</tr>
<tr>
<td>
  <label for='record_start_time'>Время</label>
  <td>
  <input name="record_start_time" id="time" type="time" required value='<?php execute_query("select TIME_FORMAT(record_start_time,\"%H:%i\") from interview WHERE id = \"$_GET[update_id]\""); ?>' />
<td>
  <a class=helper onclick="time.value=('11:00');" >Утром</a>
  <a class=helper onclick="time.value=('14:00');" >Днём</a>
  <a class=helper onclick="time.value=('18:00');" >Вечером</a>
<!--   <a class=helper onclick="setTimeAgo(1,0)" >Час назад</a> -->
  </td>
</tr>
<tr>
<td>
  <label for='sobiratel[]'>Собиратели</label>
    <td>
    <select name="sobiratel[]" id="sobiratel_set" required multiple onclick="delFromList(this,sobiratel_get)" size="5" class="two-sides right">
      <?php execute_query("SELECT 
          IF(id in (select sobiratel_id from take WHERE interview_id=\"$_GET[update_id]\"),
          CONCAT('<option value=',id,' selected>',first_name,' ',last_name,'</option>'),
          CONCAT('<option value=',id,' hidden>',first_name,' ',last_name,'</option>')) FROM sobiratel"); ?>
    </select>
  <td>
    <select id="sobiratel_get" onchange="addToList(this,sobiratel_set)" size="5" class="two-sides left">
      <?php execute_query("SELECT 
          IF(id in (select sobiratel_id from take WHERE interview_id=\"$_GET[update_id]\"),
          CONCAT('<option value=',id,' hidden>',first_name,' ',last_name,'</option>'),
          CONCAT('<option value=',id,'>',first_name,' ',last_name,'</option>')) FROM sobiratel"); ?>
    </select>
  
</tr>
<tr>
<td>
  <label for='informant[]'>Информанты</label>
<td>
  <select id="informant_set" name="informant[]" onclick="delFromList(this,informant_get)" required multiple size=3 class="two-sides right">
    <?php execute_query("SELECT IF(id in (select informant_id from give WHERE interview_id=\"$_GET[update_id]\"),
        CONCAT('<option value=',id,' selected>',first_name,' ',middle_name,' ',last_name,' ','</option>'),
        CONCAT('<option value=',id,' hidden>',first_name,' ',middle_name,' ',last_name,' ','</option>')) FROM informant"); ?> 
  </select>
  <td>
  <select id="informant_get" onchange="addToList(this,informant_set)" size=3 class="two-sides left">
    <?php execute_query("SELECT IF(id in (select informant_id from give WHERE interview_id=\"$_GET[update_id]\"),
        CONCAT('<option value=',id,' hidden>',first_name,' ',middle_name,' ',last_name,' ','</option>'),
        CONCAT('<option value=',id,' >',first_name,' ',middle_name,' ',last_name,' ','</option>')) FROM informant"); ?> 
  </select>
  </td>
</tr>
<tr>
  <td>
  <label for='context'>Контекст</label>
  </td>
  <td>
  <input name="context" id='icontext' type="textarea" maxlength="499" height="50" value='<?php execute_query("select context from interview WHERE id = \"$_GET[update_id]\""); ?>' />
  </td>
  <td></td>
</tr>
<tr>
<td></td>

<td>
  <input type="hidden" name="table" value="interview" />
  <input type="submit" id="submit" value="Подтвердить изменения" onclick="onSubmit()" />
  </td>
<td>
</tr>
  </table>
</form>
<script type="text/javascript">
  initSelect(sobiratel_get,sobiratel_set);
  initSelect(informant_get,informant_set);
function initSelect(s1,s2){
  for(var i=0; i<s1.options.length;++i){
    var op = new Option(s1.options[i].text,s1.options[i].value);
    op.hidden = true;
    s2.appendChild(op);
}
function copyText(fr){
  alert(fr.title);
}
}
function addToList(f,t){
  f.options[f.selectedIndex].hidden = true;
  t.options[f.selectedIndex].hidden = false;
  t.options[f.selectedIndex].selected = true;
  f.value="";
}
function delFromList(f,t){
  f.options[f.selectedIndex].hidden = true;
  t.options[f.selectedIndex].hidden = false;
  for(var i=0; i<f.length;++i){ f.options[i].selected = true;}
}

function setTime(t){
  document.getElementsByName("record_start_time")[0].setAttribute('value', t);
}
function setYesterday(){
  var day = new Date();
  day.setDate(day.getDate() - 1);
  document.getElementsByName("start_date")[0].setAttribute('value', day.toISOString().split('T')[0]);
}
function setToday(){
  var today = new Date().toISOString().split('T')[0];
  document.getElementsByName("start_date")[0].setAttribute('value', today);
}

function setTimeAgo(hour,minutes){
  var d = new Date();
  d.setHours(d.getHours()-hour);
  d.setMinutes(d.getMinutes()-minutes);
  time.value = d.toISOString().split('T')[1].split(".")[0];
}
  // update_place();

  function update_place(){
    var place_id = document.getElementById("place").value;
    updateIdRequest.open("POST", 'getLastId.php', true);
    updateIdRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    updateIdRequest.send('getLastId='+place_id+'&ajax=1');

  }
  
  function fullZero(st,maxl){
    while(st.length<maxl){
      st="0"+st;
    }
    return st;
  }

  if (updateIdRequest) {
    updateIdRequest.onreadystatechange = function() {
      if (updateIdRequest.readyState == 4 && updateIdRequest.status == 200)  
      { 
        var place_id = document.getElementById("place").value;
        var cnt = updateIdRequest.responseText;
        if(cnt > 0) cnt++;
        else cnt = 1;
        id=fullZero(String(cnt),document.getElementById("interview_id").getAttribute("maxlength")-1);
        document.getElementById("interview_id").value = place_id+id;
      }        
    };  
  } 
  else alert("Браузер не поддерживает AJAX");
</script>