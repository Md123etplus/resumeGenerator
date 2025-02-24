<?php
session_start();
// print_r($_SESSION['form_data']);
// print_r($_POST);
// print_r($_FILES);
if (isset($_FILES['remarque_file']) && $_FILES['remarque_file']['error'] === UPLOAD_ERR_OK) {
    $uploadTempDir = 'dossier_temp/';  // Dossier temporaire
    if (!file_exists($uploadTempDir)) {
        mkdir($uploadTempDir);
    }

    $fileTmpPath = $_FILES['remarque_file']['tmp_name'];
    $fileName = basename($_FILES['remarque_file']['name']);
    $tempFilePath = $uploadTempDir.$fileName;

    // Copier le fichier temporaire dans le dossier temporaire
    if (move_uploaded_file($fileTmpPath, $tempFilePath)) {
        $_SESSION['remarque_file'] = [
            'name' => $fileName,
            'path' => $tempFilePath,
            'type' => $_FILES['remarque_file']['type']
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form_data'] = $_POST; // Stocker les données dans la session
}


// Récupérer les données sauvegardées en session
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style_recap.css">
    <title>Récapitulatif des informations</title>
    
</head>
<body class="recap">

    <fieldset>
        <legend>Récapitulatif des informations</legend>
        <table>
            <tr><th>Champ</th><th>Valeur</th></tr>
            <tr><td>Nom</td><td><?= htmlspecialchars(isset($formData['Nom']) ? $formData['Nom'] : 'Non renseigné') ?></td></tr>
            <tr><td>Prénom</td><td><?= htmlspecialchars(isset($formData['Prenom']) ? $formData['Prenom'] : 'Non renseigné') ?></td></tr>
            <tr><td>Email</td><td><?= htmlspecialchars(isset($formData['Email']) ? $formData['Email'] : 'Non renseigné') ?></td></tr>
            <tr><td>Âge</td><td><?= htmlspecialchars(isset($formData['Age']) ? $formData['Age'] : 'Non renseigné') ?></td></tr>
            <tr><td>Numéro de téléphone</td><td><?= htmlspecialchars(isset($formData['Tel']) ? $formData['Tel'] : 'Non renseigné') ?></td></tr>
            <tr><td>Filière</td><td><?= htmlspecialchars(isset($formData['Filiere']) ? $formData['Filiere'] : 'Non renseigné') ?></td></tr>
            <tr><td>Année</td><td><?= htmlspecialchars(isset($formData['Annee']) ? $formData['Annee'] : 'Non renseigné') ?></td></tr>
            <tr><td>Modules suivis</td><td><?= isset($formData['Module']) && is_array($formData['Module']) ? implode('; ', array_map('htmlspecialchars', $formData['Module'])) : 'Aucun module sélectionné' ?></td></tr>
            <tr><td>Nombre de projets</td><td><?= htmlspecialchars(isset($formData['nb_projet']) ? $formData['nb_projet'] : '0') ?></td></tr>
        </table>
    </fieldset>

    <fieldset>
        <legend>Langues parlées</legend>
        <ul>
            <?php if (isset($formData['langue']) && is_array($formData['langue']) && !empty($formData['langue'])): ?>
                <?php foreach ($formData['langue'] as $index => $langue): ?>
                    <li><?= htmlspecialchars($langue) ?> (Niveau: <?= htmlspecialchars(isset($formData['niveau'][$index]) ? $formData['niveau'][$index] : 'Non renseigné') ?>)</li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune langue sélectionnée</li>
            <?php endif; ?>
        </ul>
    </fieldset>

    <fieldset>
        <legend>Centres d'intérêt</legend>
        <p><?= isset($formData['type_interet']) && is_array($formData['type_interet']) && !empty($formData['type_interet']) ? implode('; ', array_map('htmlspecialchars', $formData['type_interet'])) : 'Aucun centre d\'intérêt sélectionné' ?></p>
    </fieldset>

    <fieldset>
        <legend>Remarques</legend>
        <p><?= htmlspecialchars(isset($formData['remarque']) ? $formData['remarque'] : 'Aucune remarque fournie') ?></p>
        <p>Fichier : <?= isset($_FILES['remarque_file']) && $_FILES['remarque_file']['error'] == 0 ? htmlspecialchars($_FILES['remarque_file']['name']) : 'Aucun fichier fourni' ?></p>
    </fieldset>

    <form action="formulaire.php" method="post" style="display: inline;">
        <button type="submit">Modifier</button>
    </form>
    <form action="valider.php" method="post" style="display: inline;">
        <button type="submit">Valider</button>
    </form>

</body>
</html>
