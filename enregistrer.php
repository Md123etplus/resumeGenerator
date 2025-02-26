<?php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=cv_generator_db", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['form_data'])) {
        $formData = $_SESSION['form_data'];

        // Préparation de l'insertion des données
        $stmt = $pdo->prepare("INSERT INTO users 
            (nom, prenom, email, age, tel, filiere, annee, nb_projet, photo, remarque_file, remarque) 
            VALUES (:nom, :prenom, :email, :age, :tel, :filiere, :annee, :nb_projet, :photo, :remarque_file, :remarque)");

        // Variables des fichiers
        $photo = isset($_SESSION['photo']) ? $_SESSION['photo']['path'] : null;
        $remarqueFile = isset($_SESSION['remarque_file']) ? $_SESSION['remarque_file']['path'] : null;

        // Exécution de la requête
        $stmt->execute([
            ':nom' => $formData['nom'] ?? '',
            ':prenom' => $formData['prenom'] ?? '',
            ':email' => $formData['email'] ?? '',
            ':age' => $formData['age'] ?? 0,
            ':tel' => $formData['tel'] ?? '',
            ':filiere' => $formData['filiere'] ?? '',
            ':annee' => $formData['annee'] ?? '',
            ':nb_projet' => $formData['nb_projet'] ?? 0,
            ':photo' => $photo,
            ':remarque_file' => $remarqueFile,
            ':remarque' => $formData['remarque'] ?? '',
        ]);

        $userId = $pdo->lastInsertId(); // Récupération de l'ID de l'utilisateur

        // Insertion des modules suivis
        if (isset($formData['module']) && is_array($formData['module'])) {
            $stmtModule = $pdo->prepare("INSERT INTO user_modules (user_id, module_name) VALUES (:user_id, :module_name)");
            foreach ($formData['module'] as $module) {
                $stmtModule->execute([
                    ':user_id' => $userId,
                    ':module_name' => $module
                ]);
            }
        }
        //insertion de apropos
        // if (isset($formData['apropos']) && is_array($formData['apropos'])) {
        //     $stmtApropos = $pdo->prepare("INSERT INTO users (user_id, apropos) VALUES (:user_id, :apropos)");
        //     foreach ($formData['apropos'] as $apropos) {
        //         $stmtApropos->execute([
        //             ':user_id' => $userId,
        //             ':apropos' => $apropos
        //         ]);
        //     }
        // }
        // Insertion des projets réalisés
        if (isset($formData['Titre']) && is_array($formData['Titre'])) {
            $stmtProjet = $pdo->prepare("INSERT INTO user_projects (user_id, title, start_date, end_date, description) 
                                        VALUES (:user_id, :title, :start_date, :end_date, :description)");
            foreach ($formData['Titre'] as $index => $titre) {
                $stmtProjet->execute([
                    ':user_id' => $userId,
                    ':title' => $titre,
                    ':start_date' => $formData['D_debut'][$index] ?? '',
                    ':end_date' => $formData['D_fin'][$index] ?? '',
                    ':description' => $formData['Description'][$index] ?? ''
                ]);
            }
        }


        // Insertion des stages
        if (isset($formData['stage_title']) && is_array($formData['stage_title'])) {
            $stmtStage = $pdo->prepare("INSERT INTO user_stages (user_id, title, company, start_date, end_date, description) 
                                        VALUES (:user_id, :title, :company, :start_date, :end_date, :description)");
            foreach ($formData['stage_title'] as $index => $title) {
                $stmtStage->execute([
                    ':user_id' => $userId,
                    ':title' => $title,
                    ':company' => $formData['stage_company'][$index] ?? '',
                    ':start_date' => $formData['stage_start'][$index] ?? '',
                    ':end_date' => $formData['stage_end'][$index] ?? '',
                    ':description' => $formData['stage_desc'][$index] ?? ''
                ]);
            }
        }

        // Insertion des formations
        if (isset($formData['formation_title']) && is_array($formData['formation_title'])) {
            $stmtFormation = $pdo->prepare("INSERT INTO user_formations (user_id, title, institution, start_date, end_date, description) 
                                            VALUES (:user_id, :title, :institution, :start_date, :end_date, :description)");
            foreach ($formData['formation_title'] as $index => $title) {
                $stmtFormation->execute([
                    ':user_id' => $userId,
                    ':title' => $title,
                    ':institution' => $formData['formation_institution'][$index] ?? '',
                    ':start_date' => $formData['formation_start'][$index] ?? '',
                    ':end_date' => $formData['formation_end'][$index] ?? '',
                    ':description' => $formData['formation_desc'][$index] ?? ''
                ]);
            }
        }

        // Insertion des compétences
        if (isset($formData['competence_name']) && is_array($formData['competence_name'])) {
            $stmtCompetence = $pdo->prepare("INSERT INTO user_competences (user_id, name, level) VALUES (:user_id, :name, :level)");
            foreach ($formData['competence_name'] as $index => $name) {
                $stmtCompetence->execute([
                    ':user_id' => $userId,
                    ':name' => $name,
                    ':level' => $formData['competence_level'][$index] ?? ''
                ]);
            }
        }

        // Insertion des langues parlées
        if (isset($formData['langue']) && is_array($formData['langue'])) {
            $stmtLangue = $pdo->prepare("INSERT INTO user_languages (user_id, language, level) VALUES (:user_id, :language, :level)");
            foreach ($formData['langue'] as $index => $langue) {
                $stmtLangue->execute([
                    ':user_id' => $userId,
                    ':language' => $langue,
                    ':level' => $formData['niveau'][$index] ?? ''
                ]);
            }
        }

        // Insertion des centres d'intérêt
        if (isset($formData['type_interet']) && is_array($formData['type_interet'])) {
            $stmtInteret = $pdo->prepare("INSERT INTO user_interests (user_id, interest) VALUES (:user_id, :interest)");
            foreach ($formData['type_interet'] as $interet) {
                $stmtInteret->execute([
                    ':user_id' => $userId,
                    ':interest' => $interet
                ]);
            }
        }

        // Suppression des données en session après enregistrement
        // unset($_SESSION['form_data'], $_SESSION['photo'], $_SESSION['remarque_file']);

        // // Redirection après l'enregistrement
        // header("Location: recap.php");
        // exit();
    } else {
        echo "Aucune donnée trouvée.";
    }
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Génération de CV</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
        }
        .popup button {
            margin: 10px;
            padding: 10px 15px;
            cursor: pointer;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        button {
            padding: 15px 25px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

<button onclick="openPopup()">Générer le CV</button>

<div id="popup-overlay" class="popup-overlay" onclick="closePopup()"></div>

<div id="popup" class="popup">
    <p>Voulez-vous générer votre CV ?</p>
    <button onclick="redirectToCV()">Oui</button>
    <button onclick="closePopup()">Annuler</button>
</div>

<script>
    function openPopup() {
        document.getElementById("popup").style.display = "block";
        document.getElementById("popup-overlay").style.display = "block";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
        document.getElementById("popup-overlay").style.display = "none";
    }

    function redirectToCV() {
        window.location.href = "generate_cv.php";
    }
</script>

</body>
</html>