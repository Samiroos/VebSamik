<?php



// Задание 1. Проверка контрольной суммы банковских карты по стандарту ISO/IEC 7812
// для начала создаем функцию checkCardNum, которая будет заниматься проверкой


function checkCardNum($cardNum) {
  $cardNum = preg_replace('/[^0-9]/', '', $cardNum); // Удаляем все нецифровые символы
  $sum = 0;

  for ($i = strlen($cardNum) - 1; $i >= 0; $i--) {
    $digit = intval($cardNum[$i]);
    if (($i % 2) == 0) {
      $digit *= 2;
      if ($digit > 9) {
        $digit -= 9;
      }
    }
    $sum += $digit;
  }

  return ($sum % 10) == 0;
}

function getCardType($cardNum) {
  $cardNum = preg_replace('/[^0-9]/', '', $cardNum); // Удаляем все нецифровые символы
  $prefixes = array(
    'VISA' => array('4'),
    'Maestro' => array('50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '91', '92', '93', '94', '95', '96', '97', '98', '99'),
    'MasterCard' => array('50', '51', '52', '53', '54', '55', '2'),
    'ДароньКредит' => array('14', '81', '99')
  );

  foreach ($prefixes as $type => $prefList) {
    foreach ($prefList as $prefix) {
      if (substr($cardNum, 0, strlen($prefix)) == $prefix) {
        return $type;
      }
    }
  }

  return 'Тип карты не определен';
}

function checkCardLength($cardNum) {
  $cardNum = preg_replace('/[^0-9]/', '', $cardNum); // Удаляем все нецифровые символы
  $length = strlen($cardNum);
  $cardType = getCardType($cardNum);

  if ($length == 14 && getCardType($cardNum) == 'ДароньКредит') {
    return 'Это карта Даронь Кредит';
  } elseif ($length == 16 && getCardType($cardNum) == 'Maestro') {
    return 'Это карта Maestro';
  } elseif ($length == 16 || $length == 19 && getCardType($cardNum) == 'MasterCard') {
    return 'Это карта MasterCard';
  } else {
    return 'Неверно введен номер карты';
  }
}

if (isset($_POST['cardNum'])) {
  $cardNum = trim($_POST['cardNum']); // Получаем номер карты от пользователя

  $cardType = getCardType($cardNum);
  echo checkCardLength($cardNum).'<br>';

/*if (checkCardNum($cardNum)) {
  $cardType = getCardType($cardNum);
  if (in_array($cardType, array('VISA', 'MasterCard', 'Maestro', 'ДароньКредит'))) {
    echo'Карта поддерживается'.'<br>';
    $cardType = getCardType($cardNum);
  echo checkCardLength($cardNum).'<br>';
  } else {
    echo 'Карта не поддерживается'.'<br>';
  }
} else {
  echo 'Контрольная сумма не прошла проверку'.'<br>';
}*/
}
?>

<!-- Форма для ввода номера карты -->
<form action="" method="post">
  <label for="cardNum">Введите номер карты:</label>
  <input type="text" id="cardNum" name="cardNum">
  <input type="submit" value="Проверить">
</form>

