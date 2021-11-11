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
        <title>Otsing</title>
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
                    <i class='bx bx-search-alt'></i>Otsing :</h1>
                <hr>
                <table>
                    <tr>
                        <th>Toodenimi</th>
                        <th>Hind</th>
                        <th>Varv</th>
                        <th>Lisade nimi</th>
                        <th>Lisade suurus</th>
                    </tr>
                    <?php
            foreach ($andmed->toode as $toode)  {
                echo "<tr>";
                echo "<td>" . ($toode->nimi) . "</td>";
                echo "<td>" . ($toode->hind) . "</td>";
                echo "<td>" . ($toode->varv) . "</td>";
                echo "<td>" . ($toode->lisad->nimi) . "</td>";
                echo "<td>" . ($toode->lisad->suurus) . "</td>";
                echo "</tr>";
            }
            ?>
                </table>
                <form action="" method="post" class="otsingform">
                    <label for="otsing">Otsing:</label>
                    <input type="text" id="otsing" name="otsing" placeholder="Toode nimi">
                    <input type="submit" value="Otsi" id="otsinupp">
                </form>
                <ul>
                    <?php
        if (!empty($_POST["otsing"])){
            $result = searchByName($_POST["otsing"]);
            echo "<p class='p'>Result:</p>";
            foreach ($result as $toode) {
                echo "<li>";
                echo $toode->nimi. ", " . $toode->hind . " $";
                echo "</li>";
            }
        }
        ?>
                </ul>
            </div>
        </main>
        <footer class="otsing-footer">
            <p>© 2021 - XML Andmed. All Rights Reserved</p>
        </footer>
    </body>
</html>