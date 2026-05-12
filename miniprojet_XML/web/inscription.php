<?php
$xmlFile = 'C:/Users/pc/Desktop/miniprojet_XML/club.xml';
$xml = simplexml_load_file($xmlFile);
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $membreRef = $_POST['membreRef'];
    $concoursId = $_POST['concoursId'];
    $complexite = $_POST['complexite'];
    $tempsExecution = $_POST['tempsExecution'];

    $concoursFound = null;
    foreach($xml->concours->concours as $c) {
        if((string)$c['id'] === $concoursId) {
            $concoursFound = $c;
            break;
        }
    }

    $membreFound = null;
    foreach($xml->membres->membre as $m) {
        if((string)$m['id'] === $membreRef) {
            $membreFound = $m;
            break;
        }
    }

    $dejaInscrit = false;
    foreach($concoursFound->participants->participant as $p) {
        if((string)$p['membreRef'] === $membreRef) {
            $dejaInscrit = true;
            break;
        }
    }

    if($dejaInscrit) {
        $message = "Ce membre est déjà inscrit à ce concours!";
        $messageType = 'error';
    } elseif((string)$membreFound['categorieRef'] !== (string)$concoursFound['categorieRef']) {
        $message = "Ce membre n'appartient pas à la catégorie de ce concours!";
        $messageType = 'error';
    } else {
        $newParticipant = $concoursFound->participants->addChild('participant');
        $newParticipant->addAttribute('membreRef', $membreRef);
        $newParticipant->addChild('complexite', $complexite);
        $newParticipant->addChild('tempsExecution', $tempsExecution);
        $xml->asXML($xmlFile);
        $message = "Inscription réussie!";
        $messageType = 'success';
    }
}

$membres = [];
foreach($xml->membres->membre as $m) {
    $membres[] = [
        'id' => (string)$m['id'],
        'nom' => (string)$m->prenom . ' ' . (string)$m->nom
    ];
}

$concoursList = [];
foreach($xml->concours->concours as $c) {
    $concoursList[] = [
        'id' => (string)$c['id'],
        'titre' => (string)$c->titre
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Club Info_Tech</title>
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
    <h2>Inscription à un Concours</h2>

    <?php if($message): ?>
        <div class="<?php echo $messageType; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Membre:</label>
        <select name="membreRef">
            <?php foreach($membres as $m): ?>
                <option value="<?php echo $m['id']; ?>">
                    <?php echo $m['nom']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Concours:</label>
        <select name="concoursId">
            <?php foreach($concoursList as $c): ?>
                <option value="<?php echo $c['id']; ?>">
                    <?php echo $c['titre']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Complexité (0-100):</label>
        <input type="number" name="complexite" min="0" max="100" required>

        <label>Temps d'exécution (ms):</label>
        <input type="number" name="tempsExecution" min="1" required>

        <button type="submit">S'inscrire</button>
    </form>
</div>

<footer>
    <p>Club Info_Tech — Université de Skikda</p>
</footer>

</body>
</html>