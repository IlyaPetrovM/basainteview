<form action="insert_data.php" method="POST" id=input_area>
  <br/>Имя:
  <input name="first_name" type="text" required />
  <br/>Фамилия:
  <input name="last_name" type="text" required />
  <br/>e-mail:
  <input name="email" type="email" required />
  <input type="hidden" name="table" value="sobiratel" />
	<input type="submit" value="Добавить собирателя" />
</form>