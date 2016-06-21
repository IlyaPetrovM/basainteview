<?php include 'select.php'; ?> 
<form action="insert_data.php" method="POST" id=input_area>
  Название устройства:
  <input name="title" type="text" required />
  Техническое название устройства:
  <input name="tech_name" type="text" required />
  Тип устройства:
  <select name="type" required>
    <option>Диктофон</option>
    <option>Фотоаппарат</option>
    <option>Камера</option>
    <option>Мобильный телефон</option>
    <option>Сканер</option>
  </select>
  
  E-mail временного владельца:
    <select name="sobiratel_email">
    <option value=""></option>
    <?php execute_query("SELECT CONCAT('<option value=',email,'>',first_name,' ',last_name,' ',email,'</option>') FROM sobiratel"); ?>
  </select>
  
  <input type="hidden" name="table" value="device" />
	<input type="submit" id="submit" value="Добавить устройство" />
</form>