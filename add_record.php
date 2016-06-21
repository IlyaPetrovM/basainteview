<?php include 'select.php'; ?> 
<form enctype="multipart/form-data" action="insert_data.php" method="POST" id=input_area>
  Название устройства:
  <select name="device_id" required autofocus>
    <option value=""></option>
    <?php execute_query("SELECT * FROM option_device"); ?>
  </select>
  Интервью:
  <select name="interview_id" required >
    <option value=""></option>
    <?php execute_query("SELECT * FROM option_interview"); ?>
  </select>
  Файлы:
  <input type="file" name="files[]"  required multiple />
  <input type="hidden" name="table" value="record" />
	<input  type="submit" id="submit" value="Отправить файлы в архив" >Отправить файлы в архив</input>
</form>