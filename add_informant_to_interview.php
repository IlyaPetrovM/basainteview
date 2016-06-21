
<?php include 'select.php'; ?> 
<form action="insert_data.php" method="POST" id=input_area>
<br/>Интервью:
  <select name="interview_id" required>
  <!-- TODO -->
    <?php execute_query("SELECT CONCAT('<option value=',interview_id,'>',start_date,' ',context,' ','</option>') FROM informant"); ?> 
  </select>
  <br/>Информанты:
  <select name="informant" list="informant" required multiple size=3>
    <?php execute_query("SELECT CONCAT('<option value=',id,'>',first_name,' ',middle_name,' ',last_name,' ','</option>') FROM informant"); ?> 
  </select>
  <br/>Контекст:
  <input name="context" type="textarea" maxlength="499" />
  <br/>
  <input type="hidden" name="table" value="interview" />
	<input type="submit" id="submit" value="Добавить интервью" />
</form>