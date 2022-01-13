<?php
  $elements = [
    "Edamer",
    "Salami",
    "Rührei",
    "Tomate",
    "Schinken",
    "Gurke",
    "Mortadella"
  ];
  // erst die elments array Alphabetisch sortieren
  usort($elements,'strnatcasecmp');

  // dann durch die Elemente gehen und davon ein neue Liste genieren
  function get_menu_combination($arr) {
      $results = array(array( ));
      foreach ($arr as $values)
          foreach ($results as $combination)
                  array_push($results, array_merge($combination, array($values)));
      return $results;
  }

  // alle Arrays löschen die weniger als 3 oder mehr als 5 Elemente haben
  $menus = array_map(function($i){
    return count($i) >= 3 && count($i) <= 5 ? $i : null;
  },
  get_menu_combination($elements)
  );

  // leer elemente löschen
  $menus = array_filter($menus);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Frühstück Menu</title>
  <style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body{
      background-color: #d8d8d8;
    }
    ul{
      list-style: none;
    }
    li{
      border-bottom: .2em solid orangered;
      padding: .5em;
    }
  </style>
</head>

<body>
  <ul>
    <?php
      $idx = 0;
      foreach($menus as $menu) {
        $idx++;
        // ein String von allen Elementen zusammenbauen
        $menu_string = implode(",",$menu);
        echo "<li> Menu Nr. $idx : $menu_string</li>";
      }
    ?>
  </ul>

</body>

</html>
