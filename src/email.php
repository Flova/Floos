<?php
// mehrere Empf�nger
$empfaenger = 'flori.radio@gmx.de' . ', '; // beachten Sie das Komma
$empfaenger .= 'flori.vahl@web.de';

// Betreff
$betreff = 'Geburtstags-Erinnerungen f�r August';

// Nachricht
$nachricht = '
<html>
<head>
  <title>Geburtstags-Erinnerungen f�r August</title>
</head>
<body>
  <p>Hier sind die Geburtstage im August:</p>
  <table>
    <tr>
      <th>Person</th><th>Tag</th><th>Monat</th><th>Jahr</th>
    </tr>
    <tr>
      <td>Julia</td><td>3.</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Tom</td><td>17.</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// f�r HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
$header = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// zus�tzliche Header
$header .= 'cfzvghj <vtzubnj@vrifzr.com>' . "\r\n";

// verschicke die E-Mail
mail($empfaenger, $betreff, $nachricht, $header);
?>
