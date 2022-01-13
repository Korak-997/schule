In einem Hotel gibt es diverse Frühstücksangebote. Diese
werden zusammengestellt aus einer Liste von Zutaten. Listen
Sie alle Frühstücksangebote auf, welche aus mindestens 3
und aus höchstens 5 Zutaten bestehen. Hierbei sollen alle
möglichen Kombinationen aufgelistet werden, ohne dass sich
die angezeigten Zutaten nur in der Reihenfolge ändern:
Wenn ein Frühstücksangebot besteht aus: Edamer, Gouda, Gurke,
soll folgendes Frühstücksangebot nicht mehr aufgelistet
werden: Gouda, Gurke, Edamer.
Sortieren Sie die Frühstücksangebote, so dass zunächst alle
Frühstücksangebote mit 3 Zutaten, dann alle mit 4 Zutaten
und dann alle mit 5 Zutaten aufgelistet werden. Sortieren
Sie dann alle Frühstücksangebote, so dass innerhalb eines
Frühstücksangebots alle Zutaten in alphabetischer Reihenfolge
aufsteigend genannt werden (A - Z). Sortieren Sie außerdem
alle Frühstücksangebote innerhalb einer Gruppe (mit 3, 4, 5
Zutaten), so dass spaltenweise sortiert wird: alle
Frühstücksangebote werden alphabetisch aufsteigend nach der
ersten Zutat, dann alphabetisch aufsteigend nach der zweiten
Zutat, dann alphabetisch aufsteigend nach der dritten Zutat
(usw.) sortiert.
Alle möglichen zu kombinierenden Zutaten enthält das Array
$breakfast.
Die Ausgabe der einzelnen Frühstücksangebote soll in folgender
Form realisiert werden:
Menü 1: Edamer, Gurke, Mortadella
Menü 2: Edamer, Gurke, Rührei
Menü 3: Edamer, Gurke, Salami
(usw.)

Hilfestellung:
1.) Listen Sie alle Kombinationen der Elemente eines Arrays
auf (ohne doppelte Auflistung durch Vertauschen der Elemente).
2.) Listen Sie alle Kombinationen mit $k Elementen der Elemente
eines Arrays auf.

```php
$breakfast = [
	"Edamer",
	"Salami",
	"Rührei",
	"Tomate",
	"Schinken",
	"Gurke",
	"Mortadella"
];
```
