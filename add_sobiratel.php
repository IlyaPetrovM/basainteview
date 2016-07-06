<form action="?p=insert_data" method="POST" id=input_area>
<table>
<tr>
<td>
  <label for="first_name">Имя:</label></td>
  <td>
  <input name="first_name" type="text" required />
 </tr>
 <tr>
 <td>
 <label for="last_name"> Фамилия:</label>
 <td>
  <input name="last_name" type="text" required />
  </tr>
 <tr>
 <td>
 <label for="email">
  e-mail:
  </label>
  <td>
  <input name="email" type="email" required />
  </tr>
  </tr>
 <tr>
 <td>
 <td>
  <input type="hidden" name="table" value="sobiratel" />
  <input type="submit" value="Добавить собирателя" />
  </td></tr>
</table>
</form>