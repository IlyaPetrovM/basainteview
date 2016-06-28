
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
  Населённый пункт:
  <select name="place_id" id="place" onchange="update_place();" required autofocus>
    <?php execute_query("SELECT CONCAT('<option value=',id,'>',address,'</option>') FROM place ORDER BY id DESC"); ?>
  </select>
  Номер интервью:
  <input name="id" id="interview_id" type="text" maxlength="4" required  value="" />
  Дата интервью:
  <button type="button" class=helper onclick="setToday()" >Сегодня</button>
  <button type="button" class=helper onclick="setYesterday()" >Вчера </button>
  <input name="start_date" type="date" required />
  Время: 
  <button class=helper onclick="setTimeAgo(1,0)" >Час назад</button>
  <button class=helper onclick="setTime('11:00');" >Утром</button>
  <button class=helper onclick="setTime('14:00');" >Днём</button>
  <button class=helper onclick="setTime('18:00');" >Вечером</button>
  <input name="record_start_time" type="time" required value="" />
  Собиратели:
  <select name="sobiratel[]" required multiple size=3>
    <?php execute_query("SELECT CONCAT('<option value=',id,'>',first_name,' ',last_name,'</option>') FROM sobiratel"); ?>
  </select>
  Информанты:
  <select name="informant[]" required multiple size=3>
    <?php execute_query("SELECT CONCAT('<option value=',id,'>',first_name,' ',middle_name,' ',last_name,' ','</option>') FROM informant"); ?> 
  </select>
  Контекст: 
  <button class=helper onclick="setTime('18:00');" >В доме у информанта</button>
  <input name="context" type="textarea" maxlength="499" />
  <input type="hidden" name="table" value="interview" />
	<input type="submit" id="submit" value="Добавить интервью" onclick="onSubmit()" />
</form>
<script type="text/javascript">
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