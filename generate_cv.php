<?php
session_start();
ob_start(); // Empêche l'affichage avant la redirection

require('fpdf/fpdf.php');

$upload_dir = 'dossier_temp/';
$uploaded_img = "";

// Vérifier et créer le dossier s'il n'existe pas
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Vérifier si les données sont en session ou en post
if (isset($_SESSION['form_data'])) {
    $formData = $_SESSION['form_data'];
} else {
    $formData = $_POST; // Si pas de session, on prend les données post
}

// Récupération des champs
$nom = $formData['Nom'] ?? $formData['nom'] ?? '';
$prenom = $formData['Prenom'] ?? $formData['prenom'] ?? '';
$email = $formData['Email'] ?? $formData['email'] ?? '';
$num_tel = $formData['Tel'] ?? $formData['num_tel'] ?? '';
$titre = $formData['titre'] ?? '';

// Récupération des tableaux dynamiques
$langues = $formData['langue'] ?? [];
$competences = $formData['competence_name'] ?? $formData['competence'] ?? [];
$centres_interet = $formData['type_interet'] ?? $formData['centre_interet'] ?? [];
$formations = $formData['formation_title'] ?? $formData['formation'] ?? [];
$stages = $formData['stage_title'] ?? $formData['stage'] ?? [];

// Gérer l'upload d'image
if (isset($_FILES['uploaded_img']) && $_FILES['uploaded_img']['error'] == 0) {
    $file_name = basename($_FILES['uploaded_img']['name']);
    $target_file = $upload_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['uploaded_img']['tmp_name']);
    if ($check !== false && in_array($file_type, ['png', 'jpg', 'jpeg'])) {
        if (move_uploaded_file($_FILES['uploaded_img']['tmp_name'], $target_file)) {
            $uploaded_img = $target_file;
        }
    }
} elseif (isset($_SESSION['photo']['path'])) {
    $uploaded_img = $_SESSION['photo']['path'];
}

// Création du PDF
class PDF extends FPDF {
    function Header() {
        global $uploaded_img, $nom, $titre ,$prenom;

        $this->SetFillColor(242, 242, 242);
        $this->Rect(0, 0, 77, 297, 'F'); // Colonne grise

        $this->SetFillColor(20, 50, 80);
        $this->Rect(0, 15, 210, 40, 'F'); // Bandeau bleu

        if (!empty($uploaded_img)) {
            $this->Image($uploaded_img, 10, 10, 40); // Image
        }

        $this->SetFont('Arial', 'B', 24);
        $this->SetTextColor(255, 255, 255);

        $this->SetXY(0, 23);
        $this->Cell(280, 12, mb_convert_encoding($prenom . ' ' . $nom, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $this->SetFont('Arial', '', 24);
        $this->SetXY(0, 35);
        $this->Cell(210, 10, mb_convert_encoding($titre, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $this->SetXY(10, 55);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(14);
    }

    // Fonction pour ajouter du contenu dans la partie grise
    function addGreySection($title, $contentArray, $x = 10) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(68, 114, 196);
        $this->SetX($x);
        $this->Cell(0, 6, mb_convert_encoding($title, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
        $this->Ln(2);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->SetX($x);

        if (!empty($contentArray)) {
            foreach ($contentArray as $content) {
                $this->MultiCell(0, 6, mb_convert_encoding($content, 'ISO-8859-1', 'UTF-8'));
                $this->Ln(2);
            }
        }

        // Déplacer le curseur après la section
        $this->Ln(10); // Ajoute un espace après chaque section
    }

    // Fonction pour ajouter du contenu dans la partie blanche
    function addWhiteSection($title, $contentArray, $x = 80) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(68, 114, 196);
        $this->SetX($x);
        $this->Cell(0, 6, mb_convert_encoding($title, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
        $this->Ln(2);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->SetX($x);

        if (!empty($contentArray)) {
            foreach ($contentArray as $content) {
                $this->SetX(80);
                $this->MultiCell(0, 6, mb_convert_encoding($content, 'ISO-8859-1', 'UTF-8'));
                $this->Ln(2);
            }
        }

        // Déplacer le curseur après la section
        $this->Ln(10); // Ajoute un espace après chaque section
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Partie coordonnées (dans la colonne grise)
$pdf->addGreySection("Coordonnées :", [
    "Email: " . $email,
    "Téléphone: " . $num_tel
]);
$pdf->addGreySection("Profil :", [
    
]);

// Langues et centres d'intérêt (dans la colonne grise)
$pdf->addGreySection("Langues :", array_map(function ($langue, $niveau) {
    return "$langue : $niveau";
}, $formData['langue'], $formData['niveau']));

$pdf->addGreySection("Centres d'intérêt :", $formData['type_interet']);

// Déplacer le curseur après la colonne grise
$pdf->SetY(60); // Position après la colonne grise

// Ajout des formations (dans la partie blanche)
$formations = [];
foreach ($formData['formation_title'] as $index => $title) {
    $formations[] = $title . " - " . $formData['formation_institution'][$index] . "            (" . $formData['formation_start'][$index] . "    /   " . $formData['formation_end'][$index] . ")";
}
$pdf->addWhiteSection("Formations :", $formations);

// Ajout des stages avec entreprise et dates (dans la partie blanche)
$stages = [];
foreach ($formData['stage_title'] as $index => $title) {
    $stages[] = $title . " - " . $formData['stage_company'][$index] . "           (" . $formData['stage_start'][$index] . "    /    " . $formData['stage_end'][$index] . ")";
    $stages[] = "   " . $formData['stage_desc'][$index]; // Sous-intitulé
}
$pdf->addWhiteSection("Expériences Professionnelles :", $stages);

// Ajout des compétences (dans la partie blanche)
$competences = [];
if (isset($_SESSION['form_data']['competence_name']) && is_array($_SESSION['form_data']['competence_name']) &&
    isset($_SESSION['form_data']['competence_level']) && is_array($_SESSION['form_data']['competence_level'])) {

    foreach ($_SESSION['form_data']['competence_name'] as $index => $name) {
        $level = $_SESSION['form_data']['competence_level'][$index] ?? 'Non spécifié';
        $competences[] = "$name - Niveau: $level";
    }
}
$pdf->addWhiteSection("Compétences :", $competences);

// Génération du PDF
$pdfFile = 'cv.pdf';
$pdf->Output('F', $pdfFile);

ob_end_flush();
header("Location: $pdfFile");
exit();
?>