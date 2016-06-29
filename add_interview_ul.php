
<?php include 'select.php'; ?> 
<script type="text/javascript">
var connected=false;
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
<form enctype="multipart/form-data" action="insert_data.php" method="POST" >
<ul>
<li>
  <label for='place_id'>Населённый пункт</label>
  <select name="place_id" id="place" onchange="update_place();" required autofocus>
  <?php execute_query("SELECT CONCAT('<option value=',id,'>',address,'</option>') FROM place ORDER BY id DESC"); ?>
  </select>
</li>
<li>
  <label for='id'>Номер интервью</label>
  <input name="id" id="interview_id" type="text" maxlength="4" required  value="" />
</li>
<li>
  <label for='start_date'> Дата интервью</label>
  <input name="start_date" type="date" required />
</li>
<li>
  <a class=helper onclick="setToday()" >Сегодня</a>
  <a class=helper onclick="setYesterday()" >Вчера </a>
</li>
<li>
  <label for='record_start_time'>Время</label>
  <input name="record_start_time" type="time" required value="" />
</li>
<li>
  <a class=helper onclick="setTimeAgo(1,0)" >Час назад</a>
  <a class=helper onclick="setTime('11:00');" >Утром</a>
  <a class=helper onclick="setTime('14:00');" >Днём</a>
  <a class=helper onclick="setTime('18:00');" >Вечером</a></li>
<li>
  <label for='sobiratel[]'>Собиратели</label>
  
    <select id="sobiratel_get" onchange="addToList(this,sobiratel_set)" size="5" class="two-sides left">
      <?php execute_query("SELECT CONCAT('<option value=',id,'>',first_name,' ',last_name,'</option>') FROM sobiratel"); ?>
    </select>
    <select name="sobiratel[]" id="sobiratel_set" required multiple onclick="delFromList(this,sobiratel_get)" size="5" class="two-sides right"></select>
  
</li>
<li>
  <label for='informant[]'>Информанты</label>
    <select id="informant_get" onchange="addToList(this,informant_set)" size=3 class="two-sides left">
    <?php execute_query("SELECT CONCAT('<option value=',id,'>',first_name,' ',middle_name,' ',last_name,' ','</option>') FROM informant"); ?> 
  </select>
  <select id="informant_set" name="informant[]" onclick="delFromList(this,informant_get)" required multiple size=3 class="two-sides right"></select>
</li>
<li>
  <label for='context'>Контекст</label>
  <input name="context" id='icontext' type="textarea" maxlength="499" height="50" />
</li>
<li>
  <input type="hidden" name="table" value="interview" />
  <input type="submit" id="submit" value="Добавить интервью" onclick="onSubmit()" />
</li>
  </ul>
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
  var time = new Date();
  time.setHours(time.getHours()-hour);
  time.setMinutes(time.getMinutes()-minutes);
  document.getElementsByName("record_start_time")[0].setAttribute('value', time.getHours()+":"+time.getMinutes());
}
  update_place();

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

</script>