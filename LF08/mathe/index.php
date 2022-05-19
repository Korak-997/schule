<?php
  $startTime = "";
  $showSetup = true;
  $showQuiz = false;
  $showResult = false;
  
  // liest JSON Datei (hier werden alle einstellungen und Datein geschpeichert , als kleine Datenbank)
  $json = json_decode(file_get_contents("./data.json"),TRUE);

  
  //anhand die Nivau dass nutzer wählt generiert diese Funktion eine Minimal und Maximale nummer
  function getMinMax($level){
    if($level == "leicht") return [1,10];
    if($level == "mittel") return [21,40];
    if($level == "schwer") return [41,70];
  }

  // die geschickte Einstellungen werden hier bearbeitet
  if(isset($_POST['submit-setup'])) {
    $startTime = microtime(true);
    $showSetup = false;
    $showQuiz = true;
    // Speichert die Nivau und Nummer von Aufgaben
    $setup = [
      "difficulty" => $_POST['level'],
      "variants" => $_POST['variant'],
    ];
    $json["setup"] = $setup;
    
    $minMax= getMinMax($setup["difficulty"]);
    
    // Hier wird so viele Aufgaben erstellt wie Nuzter gewählt hat, dann geschpeichert in JSON Datei
    $questions = [];
    for($i = 0; $i < $setup["variants"]; $i++){
      array_push($questions, create_question($i, $minMax));
    }
    $json["questions"] = $questions;
    file_put_contents("./data.json", json_encode($json));
  }

  // diese Funktion generiert die Aufgaben 
  function create_question($index, $minMax){
    $ops = ["+", "-", "/", "*"];
    
    // damit wird eine zufällige Index Nummer generiert von OPS Array
    $randOp = array_rand($ops, 1);

    if($ops[$randOp] == "+" || $ops[$randOp] == "*"){
      $num1 = rand($minMax[0], $minMax[1]);
      $num2 = rand($minMax[0], $minMax[1]);
      $answer = $ops[$randOp] == "+" ? $num1 + $num2 : $num1 * $num2;
      return [
        "key"=> $index,
        "question" => "$num1 $ops[$randOp] $num2",
        "answer" => $answer
      ];
    }elseif($ops[$randOp] == "-" || $ops[$randOp] == "/"){
      $num2 = rand($minMax[0], $minMax[1]);
      $answer = rand($minMax[0], $minMax[1]);
      $num1 = $ops[$randOp] == "-" ? $answer + $num2 : $answer * $num2;
      return [
        "key" => $index,
        "question"=> "$num1 $ops[$randOp] $num2",
        "answer"=> $answer ];
    }
  }

  // Hier wird die Antworten bzw. ergibnisse bearbeitet
  if(isset($_POST['submit-answers'])){
    $showSetup = false;
    $showQuiz = false;
    $questions = $json["questions"];
    $results = [];
    foreach($questions as $key => $question){
      $answer = preg_match("/[a-zA-Z]/i", $_POST[(int)$key]) ? "gültige Zahl eingeben !" : $_POST[(int)$key];
      array_push($results, [
        "key" => $key,
        "question" => $question["question"],
        "answer" => $answer,
        "correctAnswer" => $question["answer"],
        "isCorrect" => $question["answer"] == $answer
      ]);
    }
    $json["results"] = $results;
    file_put_contents("./data.json", json_encode($json));
    $showResult = true;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MATH</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <h1> Mathe-Aufgaben </h1>
<?php
  if(isset($json["setup"]["difficulty"])){
    echo "<h1>Level : "
      .$json['setup']['difficulty']
      ."</h1>";
  }
  if($showSetup): ?>
  <form action="index.php" method="POST">
    <div>
      <label for="level">Level</label>
      <select name="level" id="level">
        <option value="leicht">Leicht</option>
        <option value="mittel">Mittel</option>
        <option value="schwer">Schwer</option>
      </select>
    </div>
    <div>
      <label for="variant">Anzahl</label>
      <select name="variant" id="variant">
        <option value="4">4</option>
        <option value="6">6</option>
        <option value="8">8</option>
      </select>
    </div>
      <input type="submit" name="submit-setup" value="Zu den Aufgaben">
  </form>
<?php
elseif($showQuiz):
?>
<form action="index.php" method="POST">
  <?php
    foreach($questions as $question){
      $k = $question['key'];
      echo "<div>"
        ."<label for=$i>"
        .$question["question"]
        ." = "
        ."<input type='text' name=$k id=question-$k>"
        ."</label>"
        ."</div>";
    }
  ?>
  <input type='submit' name='submit-answers' value='Auswerten'>
</form>
<?php
// Wenn die Ergibnisse bearbeitet wurden , dann werden angezeigt hier
elseif($showResult):
  $v = $json["setup"]["variants"];
  $results = $json["results"];
  $score = 0;
  foreach($results as $result){
    if($result["isCorrect"]){
      $score++;
      echo "<p class='green-txt'>"
        .$result['question']
        ." = "
        .$result['answer']
        ."</p>";
    }else{
      echo "<p class='red-txt'>"
      .$result['question']
      ." = "
      .$result['answer']
      ."<span class='red-txt'>"
      ."Richtige Antwort = "
      .$result['correctAnswer']
      ."</span>"
      ."</p>";
    }
  }
  $totalSeconds = round(microtime(true) - (int)$startTime, 2);
  echo "<p> Sie haben $score von $v richtig beantwortet </p>";
  echo "<p>Sie haben $totalSeconds Sekunden für die Lösungen benötigt.</p>";
  echo "<a href='index.php?restart'>Neu Aufgaben Lösen</a>";

endif;
?>
</body>
</html>
