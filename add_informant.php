<form action="insert_data.php" method="POST" id=input_area>
  <input type="hidden" name="table" value="informant" />
  Имя*:
  <input name="first_name" type="text" required maxlength="45" />
  Отчество:
  <input name="middle_name" type="text" maxlength="45"/>
  Фамилия*:
  <input name="last_name" type="text" required maxlength="45"/>
  Девичья фамилия:
  <input name="mother_last_name" type="text" maxlength="45" />
  Год рождения:
  <input name="year_of_birth" type="number" value="1930" required max="2016" />
  Место рождения:
  <input name="place_of_birth" type="textarea" size=3 maxlength="200"/>
  Место частого пребывания:
  <input name="place_of_living" type="textarea" size="3" maxlength="200" />
  
	<input type="submit" value="Записать информанта" />
</form>