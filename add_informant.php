<form action="insert_data.php" method="POST" id=input_area>
<table>
<tr><td>
  Имя*:<td>
  <input name="first_name" type="text" required maxlength="45" autofocus required />
  </tr><tr><td>
  Отчество:<td>
  <input name="middle_name" type="text" maxlength="45" required />
  </tr><tr><td>
  Фамилия*:<td>
  <input name="last_name" type="text" required maxlength="45" required />
  </tr><tr><td>
  Девичья фамилия:<td>
  <input name="mother_last_name" type="text" maxlength="45" />
  </tr><tr><td>
  Год рождения:<td>
  <input name="year_of_birth" type="number" value=""  max="9999" />
  </tr><tr><td>
  Место рождения:<td>
  <input name="place_of_birth" type="textarea" size=3 maxlength="200"/>
  </tr><tr><td>
  Место частого пребывания:<td>
  <input name="place_of_living" type="textarea" size="3" maxlength="200" />
  </tr><tr>
<td>
  <td>
  <input type="hidden" name="table" value="informant" />
	<input type="submit" value="Записать информанта" />
  </tr>
  </table>
</form>