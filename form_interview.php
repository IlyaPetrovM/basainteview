<form action="" method="POST" id=input_area>
  <br/>Дата интервью:
  <input name="start_date" type="date" required />
  <br/>Собиратели:

  <select name="soberatel" required multiple size=3>
          <?php 
          include 'select_device.php'; 
          ?> 
      <!-- <option value="1">Илья Петров</option> -->
      <!-- <option value="2">Аня Федосеева</option> -->
  </select>
  <br/>Записи:
  <input name="record" list="record" required multiple />
  <br/>Информанты:
  <input name="informant" list="informant" required multiple/>
  <br/>Контекст:
  <input name="context" type="textarea" maxlength="499" />
  <br/>
	<input type="submit" id="submit" value="Добавить интервью" />
</form>