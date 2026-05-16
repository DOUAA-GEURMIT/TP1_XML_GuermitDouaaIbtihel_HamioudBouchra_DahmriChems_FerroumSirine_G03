<?php
$xml = simplexml_load_file('C:/Users/pc/Desktop/TP1_XML_GuermitDouaaIbtihel_HamioudBouchra_DahmriChems_FerroumSirine_G03/club.xml');
$concoursList = [];
foreach($xml->concours->concours as $c) {
    $concoursList[] = $c;
}
usort($concoursList, function($a, $b) {
    return strcmp((string)$a['date'], (string)$b['date']);
});
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Concours - Club Info_Tech</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>🏆 Club Info_Tech</h1>
    <span>Université de Skikda</span>
</header>

<nav>
    <a href="index.php">🏠 Accueil</a>
    <a href="concours.php" class="active">🏆 Concours</a>
    <a href="inscription.php">📝 Inscription</a>
    <a href="resultats.php">📊 Résultats</a>
    <a href="requetes.php">🔍 Requêtes</a>
</nav>

<div class="container">
    <h2>Liste des Concours</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Coefficient</th>
                <th>Catégorie</th>
                <th>Participants</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($concoursList as $concours) {
            $id = (string)$concours['id'];
            $titre = (string)$concours->titre;
            $date = (string)$concours['date'];
            $coef = (string)$concours['coefficient'];
            $catRef = (string)$concours['categorieRef'];
            $categorie = '';
            foreach($xml->categories->categorie as $cat) {
                if((string)$cat['id'] === $catRef) {
                    $categorie = (string)$cat['libelle'];
                    break;
                }
            }
            $nbParticipants = count($concours->participants->participant);
            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$titre</td>";
            echo "<td>$date</td>";
            echo "<td>$coef</td>";
            echo "<td>$categorie</td>";
            echo "<td>$nbParticipants</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<footer>
    <p>Club Info_Tech — Université de Skikda</p>
</footer>

</body>
</html>