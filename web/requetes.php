<?php
$result = '';
$query = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'];

    $url = 'http://localhost:8984/rest/clubinfotechdb';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/query+xml']);
    $result = curl_exec($ch);
    if(!$result) {
        $result = "Erreur: Vérifiez que BaseX Server est démarré sur le port 8984";
    }
    curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Requêtes - Club Info_Tech</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>🏆 Club Info_Tech</h1>
    <span>Gestion du Club</span>
</header>

<nav>
    <a href="index.php">Accueil</a>
    <a href="concours.php">Concours</a>
    <a href="inscription.php">Inscription</a>
    <a href="resultats.php">Résultats</a>
    <a href="requetes.php">Requêtes</a>
</nav>

<div class="container">
    <h2>Requêtes XQuery Libres</h2>

    <form method="POST">
        <label>Entrez votre requête XQuery:</label>
        <textarea name="query" rows="8" placeholder="declare context item := doc('clubinfotechdb/club.xml');
//membre"><?php echo htmlspecialchars($query); ?></textarea>
        <button type="submit">Exécuter</button>
    </form>

    <?php if($result): ?>
        <h3 style="margin-top:25px; color:#1a73e8;">Résultat:</h3>
        <pre><?php echo htmlspecialchars($result); ?></pre>
    <?php endif; ?>
</div>

<footer>
    <p>Club Info_Tech — Université de Skikda</p>
</footer>

</body>
</html>