<?php
$xml = simplexml_load_file('C:/Users/pc/Desktop/miniprojet_XML/club.xml');

$concoursList = [];
foreach($xml->concours->concours as $c) {
    $concoursList[] = [
        'id' => (string)$c['id'],
        'titre' => (string)$c->titre
    ];
}

$selectedId = isset($_GET['concoursId']) ? $_GET['concoursId'] : $concoursList[0]['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats - Club Info_Tech</title>
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
    <h2>Résultats des Concours</h2>

    <form method="GET" style="margin-bottom:20px;">
        <label>Choisir un concours:</label>
        <select name="concoursId" onchange="this.form.submit()">
            <?php foreach($concoursList as $c): ?>
                <option value="<?php echo $c['id']; ?>"
                    <?php echo $c['id'] === $selectedId ? 'selected' : ''; ?>>
                    <?php echo $c['titre']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php
    $selectedConcours = null;
    foreach($xml->concours->concours as $c) {
        if((string)$c['id'] === $selectedId) {
            $selectedConcours = $c;
            break;
        }
    }

    $coef = (float)$selectedConcours['coefficient'];
    $participants = [];

    foreach($selectedConcours->participants->participant as $p) {
        $ref = (string)$p['membreRef'];
        $membre = null;
        foreach($xml->membres->membre as $m) {
            if((string)$m['id'] === $ref) {
                $membre = $m;
                break;
            }
        }
        $cx = (float)$p->complexite;
        $tx = (float)$p->tempsExecution;
        $score = ($cx + $tx) * $coef;

        $participants[] = [
            'nom' => (string)$membre->prenom . ' ' . (string)$membre->nom,
            'complexite' => $cx,
            'tempsExecution' => $tx,
            'score' => round($score, 2)
        ];
    }

    usort($participants, function($a, $b) {
        return $b['score'] - $a['score'];
    });

    $maxScore = $participants[0]['score'];
    ?>

    <table>
        <thead>
            <tr>
                <th>Rang</th>
                <th>Nom</th>
                <th>Complexité</th>
                <th>Temps (ms)</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($participants as $i => $p): ?>
            <tr <?php echo $p['score'] == $maxScore ? 'class="vainqueur"' : ''; ?>>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $p['nom']; ?> <?php echo $p['score'] == $maxScore ? '🏆' : ''; ?></td>
                <td><?php echo $p['complexite']; ?></td>
                <td><?php echo $p['tempsExecution']; ?></td>
                <td><?php echo $p['score']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>Club Info_Tech — Université de Skikda</p>
</footer>

</body>
</html>