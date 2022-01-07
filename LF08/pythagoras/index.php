<?php
// Wenn von Das Form die MAX_WERT Submited wird , dann wird die Tabelle gebaut
if (isset($_POST["submit"])) {
  $triples_table = isset($_POST["sort"]) ? sortTable(getTable($_POST["limit"]))  :  getTable($_POST["limit"]);
}

function sortTable($table)
{
  $sorted_table = $table;
  usort(
    $sorted_table,
    function($a, $b){return $a[$_POST["sort"]] <=> $b[$_POST["sort"]];}
  );
  echo "<h3 style='color: #549fa7; margin: 0.5em auto;'>Sortiert nach _".strtoupper($_POST["sort"] ). "_ </h3>";
  return $sorted_table;
}


// Such nach Primitivien Nummern
// Primitiven Nummern sind gleich 1 immer !
function greatestCommonDivisor($a, $b)
{
  if ($a == 0) return $b;
  if ($b == 0 || $a == $b) return $a;
  if ($a > $b) return greatestCommonDivisor($a - $b, $b);
  return greatestCommonDivisor($a, $b - $a);
}


//Generiert die Array für die Tabelle
// Jeder Triple als ein Associated Array
// array = [
  //triple1,
  //triple2,
  //....
//]

function getTable($limit)
{
  $counter = 0;
  $triples = [];
  for ($a = 1; $a <= $limit; $a++) {
    $a_quadrat = $a ** 2;
    for ($b = $a; $b < $limit; $b++) {
      $b_quadrat = $b ** 2;
      for ($c = $b; $c <= $limit; $c++) {
        $c_quadrat = $c ** 2;
        if ($a_quadrat + $b_quadrat == $c_quadrat) {
          array_push($triples, [
            "a" => $a,
            "b" => $b,
            "c" => $c,
            // Such nach Primitiven Nummern und schreib True oder False für die Werte
            // Da die ergibnisse von Primitiven Nummern 1 sein muss , deswegen ist gleich ist genutzt
            "primitive" => greatestCommonDivisor($a, $b) == 1
          ]);
        }
        $counter++;
      }
    }
  }
  echo $counter;
  return $triples;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pythagoreische Triple</title>
  <link rel="stylesheet" href="./style.css">
</head>

<body>
  <form action="index.php" method="POST">
    <div>
      <label for="limit"> Grenzen mit: </label>
      <input type="number" name="limit" required>
    </div>
    <div>
      <label for="sort"> Sort: </label>
      <select name="sort" id="sort" required>
        <option value="a">A</option>
        <option value="b">B</option>
        <option value="c">C</option>
      </select>
    </div>
    <input type="submit" name="submit" value="Generieren">
  </form>
  <?php
  if (isset($triples_table)) : ?>
    <table>
      <thead>
        <tr>
          <td>A</td>
          <td>B</td>
          <td>C</td>
        </tr>
      </thead>
      <tbody>
        <?php
          // hier wird von die Array die Werte in der Tabelle geschrieben  
          foreach ($triples_table as $triple) : 
            //Man kann ohne echo werte ausgeben wen man schreibt
            // <?= WERT ZUM AUSGEBEN ?>
        ?>
          <tr class=<?= $triple["primitive"] ? "primitive" : ""; ?>>
            <td><?= $triple["a"] ?></td>
            <td><?= $triple["b"] ?></td>
            <td><?= $triple["c"] ?></td>
            <tr />
          <?php endforeach ?>
      </tbody>
    </table>
  <?php
    echo "Es wurden " . count($triples_table) . " Triples bis c = " . $_POST["limit"] . " gefunden";
  endif ?>
</body>

</html>
