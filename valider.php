<?php
session_start();
if(isset($_SESSION['form_data'])&& !empty($_SESSION['form_data'])){
    // Retrieve the session data
    $formData = $_SESSION['form_data'];

    // Create a string with all the form data
    $formDataString = "Nom: " . (isset($formData['Nom']) ? $formData['Nom'] : 'Non renseigné') . "\n" .
                    "Prénom: " . (isset($formData['Prenom']) ? $formData['Prenom'] : 'Non renseigné') . "\n" .
                    "Email: " . (isset($formData['Email']) ? $formData['Email'] : 'Non renseigné') . "\n" .
                    "Âge: " . (isset($formData['Age']) ? $formData['Age'] : 'Non renseigné') . "\n" .
                    "Numéro de téléphone: " . (isset($formData['Tel']) ? $formData['Tel'] : 'Non renseigné') . "\n" .
                    "Filière: " . (isset($formData['Filiere']) ? $formData['Filiere'] : 'Non renseigné') . "\n" .
                    "Année: " . (isset($formData['Annee']) ? $formData['Annee'] : 'Non renseigné') . "\n";

    // Adding the modules followed this year
    $formDataString .= "Modules suivis cette année: ";
    if (!empty($formData['Module']) && is_array($formData['Module'])) {
        $formDataString .= implode("; ", $formData['Module']);
    } else {
        $formDataString .= "Aucun module sélectionné";
    }
    $formDataString .= "\n";

    // Adding the projects
    if (!empty($formData['nb_projet']) && intval($formData['nb_projet']) > 0) {
        $formDataString .= "Nombre de projets réalisés: " . $formData['nb_projet'] . "\n";
        for ($i = 0; $i < intval($formData['nb_projet']); $i++) {
            $formDataString .= "Projet " . ($i + 1) . " : Titre: " . (isset($formData["Titre"][$i]) ? $formData["Titre"][$i] : 'Non renseigné') . "\n";
            $formDataString .= "Date début: " . (isset($formData["D_debut"][$i]) ? $formData["D_debut"][$i] : 'Non renseigné') . "\n";
            $formDataString .= "Date fin: " . (isset($formData["D_fin"][$i]) ? $formData["D_fin"][$i] : 'Non renseigné') . "\n";
            $formDataString .= "Description: " . (isset($formData["Description"][$i]) ? $formData["Description"][$i] : 'Non renseigné') . "\n";
        }
    } else {
        $formDataString .= "Nombre de projets réalisés: 0\n";
    }

    // Adding the languages spoken
    $formDataString .= "Langues parlées: ";
    if (!empty($formData['langue']) && is_array($formData['langue'])) {
        foreach ($formData['langue'] as $index => $langue) {
            $niveau = isset($formData['niveau'][$index]) ? $formData['niveau'][$index] : 'Non renseigné';
            $formDataString .= $langue . " (Niveau: $niveau); ";
        }
    } else {
        $formDataString .= "Aucune langue sélectionnée";
    }
    $formDataString .= "\n";

    // Adding the interests
    $formDataString .= "Centres d'intérêt: ";
    if (!empty($formData['type_interet']) && is_array($formData['type_interet'])) {
        $formDataString .= implode("; ", $formData['type_interet']);
    } else {
        $formDataString .= "Aucun centre d'intérêt sélectionné";
    }
    $formDataString .= "\n";

    // Adding the remarks
    $formDataString .= "Vos remarques: " . (isset($formData['remarque']) ? $formData['remarque'] : 'Aucune remarque fournie') . "\n";


    // Vérifier si un fichier a déjà été enregistré en session (depuis la page récap)
    $remarkFilePath = 'Aucun fichier fourni';

    if (isset($_SESSION['remarque_file'])) {
        $uploadDir = 'remarks/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadir);
        }

        $tempFilePath = $_SESSION['remarque_file']['path']; // Chemin temporaire
        $finalFilePath = $uploadDir . $_SESSION['remarque_file']['name']; // Destination finale

        // Vérifier si le fichier temporaire existe avant de le déplacer
        if (file_exists($tempFilePath) && rename($tempFilePath, $finalFilePath)) {
            $remarkFilePath = $finalFilePath;
            unset($_SESSION['remarque_file']); // Nettoyer la session après la validation
        } else {
            $remarkFilePath = 'Erreur de déplacement du fichier.';
        }
    }
    // Ajouter l'information du fichier à la chaîne de données
    $formDataString .= "Fichier de remarque: " . $remarkFilePath . "\n";
    $formDataString .= "--------------------------------------------\n\n";
    // Save the data to a text file
    file_put_contents('informations.txt', $formDataString, FILE_APPEND);

    // Clear session data after saving
    unset($_SESSION['form_data']);
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="static/style.css">
        <title>Validation des informations</title>
    </head>
    <body>

        <!-- Success Popup -->
        <div class="popup" id="successPopup">
            <h3>Succès!</h3>
            <p>Les informations ont été enregistrées dans <strong>informations.txt</strong></p>
        </div>

        <script>
            // Show the success popup for 3 seconds
            document.addEventListener('DOMContentLoaded', function() {
                var popup = document.getElementById('successPopup');
                popup.classList.add('active');
                setTimeout(function() {
                    popup.classList.remove('active');
                }, 3000);
            });
        </script>

        <h2>Les informations ont été enregistrées avec succès!</h2>

        <a href="formulaire.php">Retour au formulaire</a>

    </body>
    </html>
<?php 
// If the session data is empty, redirect to the form page
    } else {
        header('Location: formulaire.php');
        exit();
    }   
?>