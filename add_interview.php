
<?php include 'select.php'; ?> 
<form enctype="multipart/form-data" action="insert_data.php" method="POST" >
  Номер интервью:
  <input name="id" id="interview_id" type="number" required  value=<?php execute_query("SELECT max(id) FROM interview;");?> />
  Дата интервью:
  <input name="start_date" type="date" required/>
  Время:
  <input name="record_start_time" type="time" required value="11:00" />
  Собиратели:
  <select name="sobiratel[]" required multiple size=3>
    <?php execute_query("SELECT CONCAT('<option value=',email,'>',first_name,' ',last_name,' ',email,'</option>') FROM sobiratel"); ?>
  </select>
  Информанты:
  <select name="informant[]" required multiple size=3>
    <?php execute_query("SELECT CONCAT('<option value=',id,'>',first_name,' ',middle_name,' ',last_name,' ','</option>') FROM informant"); ?> 
  </select>
  Контекст:
  <input name="context" type="textarea" maxlength="499" />
  <input type="hidden" name="table" value="interview" />
	<input type="submit" id="submit" value="Добавить интервью" />
</form>
<script type="text/javascript">
  document.getElementById("interview_id").value++;
</script>