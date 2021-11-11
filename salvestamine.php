<?php
$andmed = simplexml_load_file("andmeteBaas.xml");
function searchByName($query) {
    global $andmed;
    $result = array();
    foreach ($andmed->toode as $toode ){
        if (substr(strtolower($toode->nimi), 0,
                strlen($query)) == strtolower($query))
            array_push($result, $toode);
    }
    return $result;
}
?>
<?php
$andmed = simplexml_load_file("andmeteBaas.xml");
$uus_fail = (isset($_POST["uus_fail"])) && $_POST["uus_fail"];
// XML andmete salvestamine uusBaas.xml
if (isset($_POST['submit']) && $uus_fail && !empty($_POST['nimi'])) {
    $toodenimi = $_POST['nimi'];
    $toodehind = $_POST['hind'];
    $toodevarv = $_POST['varv'];
    $lisadenimi = $_POST['lisadenimi'];
    $lisadesuurus = $_POST['lisadesuurus'];

    $xmlDoc = new DOMDocument("1.0","UTF-8");
    $xmlDoc->formatOutput = true;
    $xmlDoc->preserveWhiteSpace = false; // Remove white spaces.
    // Файл $xmlDoc, сначала нужно добавить переменные в $xmlDoc
    $xml_toode = $xmlDoc->createElement("toode"); // Создание элемента "toode" под переменной $xml_toode
    $xmlDoc->appendChild($xml_toode); // Add element

    $xml_lisad = $xmlDoc->createElement("lisad"); // Создание элемента "lisad" под переменной $xml_lisad
    $xmlDoc->appendChild($xml_lisad); // Add element


    $xml_toode->appendChild($xmlDoc->createElement('nimi23',$toodenimi));
    // Создание эемента, 'nimi', как он будет называться в XML faile, $toodenimi, что добавяем,
    // ..мы считываем с формы введенное значение чеовеком.
    $xml_toode->appendChild($xmlDoc->createElement('hind',$toodehind));
    $xml_toode->appendChild($xmlDoc->createElement('varv',$toodevarv));

    $xml_toode->appendChild($xml_lisad); // Добавение тега lisad

    $xml_lisad->appendChild($xmlDoc->createElement('nimi', $lisadenimi ));
    // Создание тегов в теге "lisad", введение с формы.
    $xml_lisad->appendChild($xmlDoc->createElement('suurus',$lisadesuurus));

    $xmlDoc->save('toode' . date("YmdHis").'.xml');
}
// XML andmete täiendamine

if (isset($_POST['submit']) && !$uus_fail  && !empty($_POST['nimi'])) {
    $toodenimi = $_POST['nimi'];
    $toodehind = $_POST['hind'];
    $toodevarv = $_POST['varv'];
    $lisadenimi = $_POST['lisadenimi'];
    $lisadesuurus = $_POST['lisadesuurus'];

    // $xml_root = $xmlDoc->documentElement;
    $xml_tooded=$andmed->addChild('toode');
    $xml_tooded->addChild('nimi', $toodenimi);
    $xml_tooded->addChild('hind', $toodehind);
    $xml_tooded->addChild('varv', $toodevarv);

    $lisad = $xml_tooded->addChild("lisad");
    $lisad ->addChild('nimi',$lisadenimi);
    $lisad ->addChild('suurus',$lisadesuurus);

    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->loadXML($andmed->asXML(), LIBXML_NOBLANKS);
    $xmlDoc->formatOutput=true;
    $xmlDoc->save('andmeteBaas.xml');
  
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link
            href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'
            rel='stylesheet'>
        <title>Salvestamine</title>
    </head>
    <body>
        <header>
            <img src="logooo.png" alt="logo" width="100px">
            <nav>
                <ul class="nav__links">
                    <li>
                        <a href="otsing.php">Otsing</a>
                    </li>
                    <li>
                        <a href="salvestamine.php">Salvestamine</a>
                    </li>
                </ul>
            </nav>

            <button>
                <a href="https://kolossova20.thkit.ee/PHPLeht/index.php">PHPLehestik</a>
            </button>
        </header>
        <main>
            <div class="container">

                <h1>
                    <i class='bx bx-save'></i>Salvestamine:</h1>
                <hr>
                <?php
        // lisamisvorm html failist
        include('lisamisvorm.html');
        ?>
            </div>
            <div class="information">
                <?php
        echo "<div class='container'>";
        if (isset($_POST['submit']) && !$uus_fail && !empty($_POST['nimi'])) {
          echo "<p class='lisamine-failis'>Teie toode on lisatud 'admeteBaas' failis. </p>";
        }
        if (isset($_POST['submit']) && $uus_fail && !empty($_POST['nimi'])) {
        echo "<p class='lisamine-failis'>Teie toode on lisatud uues failis - toode".  date("YmdHis") ." </p>";
        }
        echo "</div";
        ?>
            </div>
        </main>
        <footer>
            <p>© 2021 - XML Andmed. All Rights Reserved</p>
        </footer>
    </body>
</html>