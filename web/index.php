<?php
$xml = simplexml_load_file('C:/Users/pc/Desktop/TP1_XML_GuermitDouaaIbtihel_HamioudBouchra_DahmriChems_FerroumSirine_G03/club.xml');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Club Info_Tech</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>🏆 Club Info_Tech</h1>
    <span>Université de Skikda</span>
</header>

<nav>
    <a href="index.php" class="active">🏠 Accueil</a>
    <a href="concours.php">🏆 Concours</a>
    <a href="inscription.php">📝 Inscription</a>
    <a href="resultats.php">📊 Résultats</a>
    <a href="requetes.php">🔍 Requêtes</a>
</nav>

<div class="container">
    <h2>Liste des Membres</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Complet</th>
                <th>Email</th>
                <th>Catégorie</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($xml->membres->membre as $membre) {
            $id = (string)$membre['id'];
            $nom = (string)$membre->nom;
            $prenom = (string)$membre->prenom;
            $email = (string)$membre->email;
            $catRef = (string)$membre['categorieRef'];
            $categorie = '';
            foreach($xml->categories->categorie as $cat) {
                if((string)$cat['id'] === $catRef) {
                    $categorie = (string)$cat['libelle'];
                    break;
                }
            }
            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$prenom $nom</td>";
            echo "<td>$email</td>";
            echo "<td>$categorie</td>";
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