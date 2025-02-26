<?php
session_start();

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=cv_generator_db", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Vérification si l'email est bien envoyé en POST
    if (!isset($_POST['email'])) {
        header("Location: recap.php");
        die("Email non fourni.");
    }

    $email = $_POST['email'];

    // Récupération des données principales de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        die("Utilisateur introuvable.");
    }

    // Sauvegarde des données de l'utilisateur dans la session
    $_SESSION['form_data'] = $userData;

    // Récupération des modules suivis
    $stmt = $pdo->prepare("SELECT module_name FROM user_modules WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $_SESSION['form_data']['module'] = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Récupération des projets
    $stmt = $pdo->prepare("SELECT title, start_date, end_date, description FROM user_projects WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation des données des projets dans la session
    $_SESSION['form_data']['Titre'] = [];
    $_SESSION['form_data']['D_debut'] = [];
    $_SESSION['form_data']['D_fin'] = [];
    $_SESSION['form_data']['Description'] = [];

    // Si des projets existent, on les place dans les bonnes clés de session
    if (!empty($projets)) {
        foreach ($projets as $projet) {
            $_SESSION['form_data']['Titre'][] = $projet['title'];
            $_SESSION['form_data']['D_debut'][] = $projet['start_date'];
            $_SESSION['form_data']['D_fin'][] = $projet['end_date'];
            $_SESSION['form_data']['Description'][] = $projet['description'];
        }
    } else {
        // Assurez-vous que les clés sont toujours présentes même si aucun projet n'est trouvé
        $_SESSION['form_data']['Titre'] = [];
        $_SESSION['form_data']['D_debut'] = [];
        $_SESSION['form_data']['D_fin'] = [];
        $_SESSION['form_data']['Description'] = [];
    }


    // Récupération des stages
    $stmt = $pdo->prepare("SELECT title, company, start_date, end_date, description FROM user_stages WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation des données des stages dans la session
    $_SESSION['form_data']['stage_title'] = [];
    $_SESSION['form_data']['stage_company'] = [];
    $_SESSION['form_data']['stage_start'] = [];
    $_SESSION['form_data']['stage_end'] = [];
    $_SESSION['form_data']['stage_desc'] = [];

    // Si des stages existent, on les place dans les bonnes clés de session
    if (!empty($stages)) {
        foreach ($stages as $stage) {
            $_SESSION['form_data']['stage_title'][] = $stage['title'];
            $_SESSION['form_data']['stage_company'][] = $stage['company'];
            $_SESSION['form_data']['stage_start'][] = $stage['start_date'];
            $_SESSION['form_data']['stage_end'][] = $stage['end_date'];
            $_SESSION['form_data']['stage_desc'][] = $stage['description'];
        }
    } else {
        // Assurez-vous que les clés sont toujours présentes même si aucun stage n'est trouvé
        $_SESSION['form_data']['stage_title'] = [];
        $_SESSION['form_data']['stage_company'] = [];
        $_SESSION['form_data']['stage_start'] = [];
        $_SESSION['form_data']['stage_end'] = [];
        $_SESSION['form_data']['stage_desc'] = [];
    }


    // Récupération des formations
    $stmt = $pdo->prepare("SELECT title, institution, start_date, end_date, description FROM user_formations WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation des données des formations dans la session
    $_SESSION['form_data']['formation_title'] = [];
    $_SESSION['form_data']['formation_institution'] = [];
    $_SESSION['form_data']['formation_start'] = [];
    $_SESSION['form_data']['formation_end'] = [];
    $_SESSION['form_data']['formation_desc'] = [];

    // Si des formations existent, on les place dans les bonnes clés de session
    if (!empty($formations)) {
        foreach ($formations as $formation) {
            $_SESSION['form_data']['formation_title'][] = $formation['title'];
            $_SESSION['form_data']['formation_institution'][] = $formation['institution'];
            $_SESSION['form_data']['formation_start'][] = $formation['start_date'];
            $_SESSION['form_data']['formation_end'][] = $formation['end_date'];
            $_SESSION['form_data']['formation_desc'][] = $formation['description'];
        }
    } else {
        // Assurez-vous que les clés sont toujours présentes même si aucune formation n'est trouvée
        $_SESSION['form_data']['formation_title'] = [];
        $_SESSION['form_data']['formation_institution'] = [];
        $_SESSION['form_data']['formation_start'] = [];
        $_SESSION['form_data']['formation_end'] = [];
        $_SESSION['form_data']['formation_desc'] = [];
    }


    // Récupération des compétences
    $stmt = $pdo->prepare("SELECT name, level FROM user_competences WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation des données de compétences dans la session
    $_SESSION['form_data']['competence_name'] = [];
    $_SESSION['form_data']['competence_level'] = [];

    // Si des compétences existent, on les place dans les bonnes clés de session
    if (!empty($competences)) {
        foreach ($competences as $competence) {
            $_SESSION['form_data']['competence_name'][] = $competence['name'];
            $_SESSION['form_data']['competence_level'][] = $competence['level'];
        }
    } else {
        // Assurez-vous que les clés sont toujours présentes même si aucune compétence n'est trouvée
        $_SESSION['form_data']['competence_name'] = [];
        $_SESSION['form_data']['competence_level'] = [];
    }


    // Récupération des langues
    $stmt = $pdo->prepare("SELECT language, level FROM user_languages WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation des données de langues dans la session
    $_SESSION['form_data']['langue'] = [];
    $_SESSION['form_data']['niveau'] = [];

    // Si des langues existent, on les place dans les bonnes clés de session
    if (!empty($languages)) {
        foreach ($languages as $language) {
            $_SESSION['form_data']['langue'][] = $language['language'];
            $_SESSION['form_data']['niveau'][] = $language['level'];
        }
    } else {
        // Assurez-vous que les clés sont toujours présentes même si aucune langue n'est trouvée
        $_SESSION['form_data']['langue'] = [];
        $_SESSION['form_data']['niveau'] = [];
    }


    // Récupération des centres d'intérêt
    $stmt = $pdo->prepare("SELECT interest FROM user_interests WHERE user_id = ?");
    $stmt->execute([$userData['id']]);
    $_SESSION['form_data']['type_interet'] = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Récupération des remarques
    $stmt = $pdo->prepare("SELECT remarque FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $_SESSION['form_data']['remarque'] = $stmt->fetchColumn();

    // Récupération de la photo
    $stmt = $pdo->prepare("SELECT photo FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $photoPath = $stmt->fetchColumn();

    if ($photoPath) {
        $_SESSION['photo'] = [
            'name' => basename($photoPath),
            'path' => $photoPath,
            'type' => mime_content_type($photoPath)
        ];
    }

    // Redirection vers la page de récapitulatif
    header("Location: recap.php");
    exit();

    // print_r($_SESSION['form_data']);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>
