<?php
require "auth.php";
?>
<a href="admin.php?do=logout">Exit</a>

<!doctype html>
<html lang="ru">
<head>
  <title>Админ-панель</title>
</head>
<body>

<?php
  $host = 'localhost';  // Хост, у нас все локально
  $user = 'improver-nikita-smagin-us';    // Имя созданного вами пользователя
  $pass = '7L7g1Q5c8D'; // Установленный вами пароль пользователю
  $db_name = 'improver-nikita-smagin-db';   // Имя базы данных
  $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

  // Ругаемся, если соединение установить не удалось
  if (!$link) {
    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
  }
  echo "</br>";
?>
<div style="display: flex; float:left;">
<form action="" method="get">
      Добавить:<input type="text" name="Name" required>
      <input type="submit" value="Add">
</form>
<form action="" method="post" >
      <input type="submit" name="submit" value="Delete All">
</form>
</div>
</br>
</br>
</br>
<?php
  //Если переменная Name передана
  if (isset($_GET["Name"])) {
    //Вставляем данные, подставляя их в запрос
    $sql = mysqli_query($link, "INSERT INTO `my_db` (`name`) VALUES ('{$_GET['Name']}')");
    //Если вставка прошла успешно
    if ($sql) {
      header( 'Location: /' ); 
      exit();
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
  //Получаем данные
  $sql = mysqli_query($link, 'SELECT `ID`, `name` FROM `my_db`');
  while ($result = mysqli_fetch_array($sql)) {
      echo "<input type=\"checkbox\" name=\"formWheelchair\" value=\"Yes\" /> {$result['name']} - <a href='?del={$result['ID']}'>[X]</a><br>";
  }

  if (isset($_GET['del'])) {
    $sql = mysqli_query($link, "DELETE FROM `my_db` WHERE `ID` = {$_GET['del']}");
    if ($sql) {
      header( 'Location: /' ); 
      exit();
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }

  if (isset($_POST['submit']))  // Form submitted
  {
      if ($_POST['submit'] == 'Delete All') // Delete button clicked
      {
        $sql = mysqli_query($link, "DELETE FROM `my_db` WHERE 1;");
        if ($sql) {
          header( 'Location: /' ); 
          exit();
        } else {
          echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
        }
      }
    }
?>


</body>
</html>