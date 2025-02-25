<?php
session_start();
// Process file upload for remarque_file
if (isset($_FILES['remarque_file']) && $_FILES['remarque_file']['error'] === UPLOAD_ERR_OK) {
    $uploadTempDir = 'dossier_temp/';  // Temporary folder
    if (!file_exists($uploadTempDir)) {
        mkdir($uploadTempDir);
    }

    $fileTmpPath = $_FILES['remarque_file']['tmp_name'];
    $fileName = basename($_FILES['remarque_file']['name']);
    $tempFilePath = $uploadTempDir . $fileName;

    // Move the temporary file to the temp folder
    if (move_uploaded_file($fileTmpPath, $tempFilePath)) {
        $_SESSION['remarque_file'] = [
            'name' => $fileName,
            'path' => $tempFilePath,
            'type' => $_FILES['remarque_file']['type']
        ];
    }
}

// Process file upload for photo
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadTempDir = 'dossier_temp/';  // Temporary folder
    if (!file_exists($uploadTempDir)) {
        mkdir($uploadTempDir);
    }

    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = basename($_FILES['photo']['name']);
    $tempFilePath = $uploadTempDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $tempFilePath)) {
        $_SESSION['photo'] = [
            'name' => $fileName,
            'path' => $tempFilePath,
            'type' => $_FILES['photo']['type']
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form_data'] = $_POST; // Store form data in session
}

// Retrieve saved session data
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
            <tr>
                <td>Nom</td>
                <td><?= htmlspecialchars(isset($formData['Nom']) ? $formData['Nom'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Prénom</td>
                <td><?= htmlspecialchars(isset($formData['Prenom']) ? $formData['Prenom'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= htmlspecialchars(isset($formData['Email']) ? $formData['Email'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Âge</td>
                <td><?= htmlspecialchars(isset($formData['Age']) ? $formData['Age'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Numéro de téléphone</td>
                <td><?= htmlspecialchars(isset($formData['Tel']) ? $formData['Tel'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Filière</td>
                <td><?= htmlspecialchars(isset($formData['Filiere']) ? $formData['Filiere'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Année</td>
                <td><?= htmlspecialchars(isset($formData['Annee']) ? $formData['Annee'] : 'Non renseigné') ?></td>
            </tr>
            <tr>
                <td>Modules suivis</td>
                <td>
                    <?= isset($formData['Module']) && is_array($formData['Module'])
                        ? implode('; ', array_map('htmlspecialchars', $formData['Module']))
                        : 'Aucun module sélectionné' ?>
                </td>
            </tr>
            <tr>
                <td>Nombre de projets</td>
                <td><?= htmlspecialchars(isset($formData['nb_projet']) ? $formData['nb_projet'] : '0') ?></td>
            </tr>
            <?php if (!empty($formData['Titre']) && is_array($formData['Titre'])): ?>
                <tr>
                    <td>Projets réalisés</td>
                    <td>
                        <ul>
                            <?php foreach ($formData['Titre'] as $index => $titre): ?>
                                <li>
                                    <strong>Titre:</strong> <?= htmlspecialchars($titre) ?><br>
                                    <strong>Date début:</strong> <?= htmlspecialchars($formData['D_debut'][$index] ?? '') ?><br>
                                    <strong>Date fin:</strong> <?= htmlspecialchars($formData['D_fin'][$index] ?? '') ?><br>
                                    <strong>Description:</strong> <?= nl2br(htmlspecialchars($formData['Description'][$index] ?? '')) ?>
                                </li>
                                <hr>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td>Projets réalisés</td>
                    <td>Aucun projet renseigné</td>
                </tr>
            <?php endif; ?>


            <tr>
                <td>Photo</td>
                <td>
                    <?php if(isset($_SESSION['photo'])): ?>
                        <img src="<?= htmlspecialchars($_SESSION['photo']['path']) ?>" alt="Photo" style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                        <br>
                        <?= htmlspecialchars($_SESSION['photo']['name']) ?>
                    <?php else: ?>
                        Aucune photo fournie
                    <?php endif; ?>
                </td>
            </tr>

        </table>
    </fieldset>

    <!-- Stages -->
    <fieldset>
        <legend>Stages</legend>
        <?php if(isset($formData['stage_title']) && is_array($formData['stage_title']) && count($formData['stage_title']) > 0): ?>
            <?php foreach($formData['stage_title'] as $index => $title): ?>
                <div class="stage">
                    <p><strong>Intitulé:</strong> <?= htmlspecialchars($title) ?></p>
                    <p><strong>Entreprise:</strong> <?= htmlspecialchars(isset($formData['stage_company'][$index]) ? $formData['stage_company'][$index] : '') ?></p>
                    <p><strong>Date de début:</strong> <?= htmlspecialchars(isset($formData['stage_start'][$index]) ? $formData['stage_start'][$index] : '') ?></p>
                    <p><strong>Date de fin:</strong> <?= htmlspecialchars(isset($formData['stage_end'][$index]) ? $formData['stage_end'][$index] : '') ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars(isset($formData['stage_desc'][$index]) ? $formData['stage_desc'][$index] : '') ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun stage renseigné.</p>
        <?php endif; ?>
    </fieldset>

    <!-- Formations -->
    <fieldset>
        <legend>Formations</legend>
        <?php if(isset($formData['formation_title']) && is_array($formData['formation_title']) && count($formData['formation_title']) > 0): ?>
            <?php foreach($formData['formation_title'] as $index => $title): ?>
                <div class="formation">
                    <p><strong>Intitulé:</strong> <?= htmlspecialchars($title) ?></p>
                    <p><strong>Établissement:</strong> <?= htmlspecialchars(isset($formData['formation_institution'][$index]) ? $formData['formation_institution'][$index] : '') ?></p>
                    <p><strong>Date de début:</strong> <?= htmlspecialchars(isset($formData['formation_start'][$index]) ? $formData['formation_start'][$index] : '') ?></p>
                    <p><strong>Date de fin:</strong> <?= htmlspecialchars(isset($formData['formation_end'][$index]) ? $formData['formation_end'][$index] : '') ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars(isset($formData['formation_desc'][$index]) ? $formData['formation_desc'][$index] : '') ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune formation renseignée.</p>
        <?php endif; ?>
    </fieldset>

    <!-- Compétences -->
    <fieldset>
        <legend>Compétences</legend>
        <?php if(isset($formData['competence_name']) && is_array($formData['competence_name']) && count($formData['competence_name']) > 0): ?>
            <?php foreach($formData['competence_name'] as $index => $name): ?>
                <div class="competence">
                    <p><strong>Compétence:</strong> <?= htmlspecialchars($name) ?></p>
                    <p><strong>Niveau:</strong> <?= htmlspecialchars(isset($formData['competence_level'][$index]) ? $formData['competence_level'][$index] : '') ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune compétence renseignée.</p>
        <?php endif; ?>
    </fieldset>

    <!-- Langues parlées -->
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

    <!-- Centres d'intérêt -->
    <fieldset>
        <legend>Centres d'intérêt</legend>
        <p><?= isset($formData['type_interet']) && is_array($formData['type_interet']) && !empty($formData['type_interet'])
                ? implode('; ', array_map('htmlspecialchars', $formData['type_interet']))
                : 'Aucun centre d\'intérêt sélectionné' ?></p>
    </fieldset>

    <!-- Remarques -->
    <fieldset>
        <legend>Remarques</legend>
        <p><?= htmlspecialchars(isset($formData['remarque']) ? $formData['remarque'] : 'Aucune remarque fournie') ?></p>
        <p>Fichier : <?= isset($_SESSION['remarque_file']) ? htmlspecialchars($_SESSION['remarque_file']['name']) : 'Aucun fichier fourni' ?></p>
    </fieldset>

    <form action="formulaire.php" method="post" style="display: inline;">
        <button type="submit">Modifier</button>
    </form>
    <form action="enregistrer.php" method="post" style="display: inline;">
        <button type="submit">Valider</button>
    </form>

</body>
</html>
