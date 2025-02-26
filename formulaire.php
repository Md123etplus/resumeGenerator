<?php
    session_start();
    // print_r($_SESSION['form_data']);
    $formData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
    }
    // print_r($_SESSION['form_data']);  
    $formations = [];
    if (!empty($formData['formation_title'])) {
        foreach ($formData['formation_title'] as $index => $title) {
            $formations[] = [
                'formation_title' => $title,
                'formation_institution' => $formData['formation_institution'][$index] ?? '',
                'formation_start' => $formData['formation_start'][$index] ?? '',
                'formation_end' => $formData['formation_end'][$index] ?? '',
                'formation_desc' => $formData['formation_desc'][$index] ?? ''
            ];
        }
    }

    // Reconstruire les compétences sous forme de tableau d'objets
    $competences = [];
    if (!empty($formData['competence_name'])) {
        foreach ($formData['competence_name'] as $index => $name) {
            $competences[] = [
                'competence_name' => $name,
                'competence_level' => $formData['competence_level'][$index] ?? ''
            ];
        }
    }
    $prefilledStages = [];
    if (!empty($formData['stage_title'])) {
        foreach ($formData['stage_title'] as $index => $title) {
            $prefilledStages[] = [
                'stage_title'   => $title,
                'stage_company' => $formData['stage_company'][$index] ?? '',
                'stage_start'   => $formData['stage_start'][$index] ?? '',
                'stage_end'     => $formData['stage_end'][$index] ?? '',
                'stage_desc'    => $formData['stage_desc'][$index] ?? '',
            ];
        }
    }
    $prefilledLangues = [];
    if (!empty($formData['langue'])) {
        foreach ($formData['langue'] as $index => $langue) {
            $prefilledLangues[] = [
                'langue' => $langue,
                'niveau' => $formData['niveau'][$index] ?? ''
            ];
        }
    }
    $prefilledInterets = [];
    if (!empty($formData['type_interet'])) {
        foreach ($formData['type_interet'] as $index => $interet) {
            $prefilledInterets[] = [
                'type_interet' => $interet
            ];
        }
    }
    $prefilledProjets = [];
    if (!empty($formData['Titre'])) {
        foreach ($formData['Titre'] as $index => $titre) {
            $prefilledProjets[] = [
                'Titre' => $titre,
                'D_debut' => $formData['D_debut'][$index] ?? '',
                'D_fin' => $formData['D_fin'][$index] ?? '',
                'Description' => $formData['Description'][$index] ?? ''
            ];
        }
    }
    


    $formData['formations'] = $formations;
    $formData['competences'] = $competences;
    $formData['stages'] = $prefilledStages;
    $formData['langues'] = $prefilledLangues;
    $formData['interets'] = $prefilledInterets;
    $formData['projets'] = $prefilledProjets;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de renseignements</title>
    <link rel="stylesheet" href="static/style.css">
    <!-- <script src="static/script.js" defer></script> -->
</head>
<body>
    <section>
        <form method="POST" action="recap.php" enctype="multipart/form-data">
            <h1 style="text-align: center;">Fiche de Renseignements</h1>
            <div class="main_content">
                <!-- 1. Noms & Coordonnées -->
                <fieldset class="rens_perso">
                    <legend style="text-align: center;">Noms & Coordonnées</legend>
                    <span>
                        <label for="nom">Nom:</label><br>
                        <input type="text" id="nom" name="nom" value="<?= isset($formData['nom']) ? htmlspecialchars($formData['nom']) : '' ?>" required>
                    </span>
                    <span>
                        <label for="prenom">Prénom:</label><br>
                        <input type="text" id="prenom" name="prenom" value="<?= isset($formData['prenom']) ? htmlspecialchars($formData['prenom']) : '' ?>" required>
                    </span>
                    <span>
                        <label for="age">Âge:</label><br>
                        <input type="number" id="age" name="age" value="<?= isset($formData['age']) ? htmlspecialchars($formData['age']) : '' ?>" >
                    </span>
                    <span>
                        <label for="tel">Téléphone:</label><br>
                        <input type="tel" id="tel" name="tel" value="<?= isset($formData['tel']) ? htmlspecialchars($formData['tel']) : '' ?>">
                    </span>
                    <span>
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" value="<?= isset($formData['email']) ? htmlspecialchars($formData['email']) : '' ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    </span>
                </fieldset>

                <!-- 2. Photo & About -->
                <fieldset>
                    <legend>Photo</legend>
                    <input type="file" name="photo">
                    <br>
                    <label for="apropos">À propos:</label><br>
                    <textarea name="apropos" id="apropos" rows="4"><?= isset($formData['apropos']) ? htmlspecialchars($formData['apropos']) : '' ?></textarea>
                </fieldset>

                <!-- 3. Renseignement Académique -->
                <fieldset>
                    <legend>Renseignement Académique</legend>
                    <div class="info_academ">
                        <h4>Vous êtes en:</h4>
                        <span style="border-left: 1px solid black;">
                            <label for="2AP">2AP:</label>
                            <input type="radio" name="filiere" id="2AP" value="2AP" <?= isset($formData['filiere']) && $formData['filiere'] === '2AP' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="GSTR">GSTR:</label>
                            <input type="radio" name="filiere" id="GSTR" value="GSTR" <?= isset($formData['filiere']) && $formData['filiere'] === 'GSTR' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="GI">GI:</label>
                            <input type="radio" name="filiere" id="GI" value="GI" <?= isset($formData['filiere']) && $formData['filiere'] === 'GI' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="SCM">SCM:</label>
                            <input type="radio" name="filiere" id="SCM" value="SCM" <?= isset($formData['filiere']) && $formData['filiere'] === 'SCM' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="GC">GC:</label>
                            <input type="radio" name="filiere" id="GC" value="GC" <?= isset($formData['filiere']) && $formData['filiere'] === 'GC' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="MS">MS:</label>
                            <input type="radio" name="filiere" id="MS" value="MS" <?= isset($formData['filiere']) && $formData['filiere'] === 'MS' ? 'checked' : '' ?>>
                        </span>
                        <hr>
                        <span style="border-left: 1px solid black;">
                            <label for="1er_annee">1er année:</label>
                            <input type="radio" name="annee" id="1er_annee" value="1er annee" <?= isset($formData['annee']) && $formData['annee'] === '1er annee' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="2eme_annee">2ème année:</label>
                            <input type="radio" name="annee" id="2eme_annee" value="2eme annee" <?= isset($formData['annee']) && $formData['annee'] === '2eme annee' ? 'checked' : '' ?>>
                        </span>
                        <span>
                            <label for="3eme_annee">3ème année:</label>
                            <input type="radio" name="annee" id="3eme_annee" value="3eme annee" <?= isset($formData['annee']) && $formData['annee'] === '3eme annee' ? 'checked' : '' ?>>
                        </span>
                        <hr>
                        <h4>Modules suivis cette année :</h4>
                        <?php 
                        $modules = ['Pro Av', 'Compilation', 'reseaux Av', 'Web Avancee', 'POO', 'BD'];
                        foreach ($modules as $module) : ?>
                            <span>
                                <label for="<?= $module ?>"><?= $module ?>:</label>
                                <input type="checkbox" name="module[]" id="<?= $module ?>" value="<?= $module ?>" <?= isset($formData['module']) && in_array($module, $formData['module']) ? 'checked' : '' ?>>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                    <label for="projet">Nombre de projets réalisés cette année:</label>
                    <select name="nb_projet" id="projet">
                        <?php for ($i = 0; $i <= 5; $i++) : ?>
                            <option value="<?= $i ?>" <?= isset($formData['nb_projet']) && $formData['nb_projet'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="project_container">
                        <!-- Les projets seront ajoutés dynamiquement -->
                    </div>
                </fieldset>

                <!-- 4. Stages -->
                <fieldset>
                    <legend>Stages</legend>
                    <div id="stages_container"></div>
                    <button type="button" onclick="addStage()">Ajouter un stage</button>
                </fieldset>

                <!-- 5. Formations -->
                <fieldset>
                    <legend>Formations</legend>
                    <div id="formations_container"></div>
                    <button type="button" onclick="addFormation()">Ajouter une formation</button>
                </fieldset>

                <!-- 6. Compétences et Langues -->
                <fieldset>
                    <legend>Compétences et Langues</legend>
                    <div class="competences">
                        <button type="button" onclick="addCompetence()">Ajouter une compétence</button>
                        <div class="competences_container"></div>
                    </div>
                    <div class="langues">
                        <label for="nb_langues">Nombre de langues parlées:</label>
                        <select name="nb_langues" id="nb_langues">
                            <?php for ($i = 0; $i <= 5; $i++) : ?>
                                <option value="<?= $i ?>" <?= isset($formData['nb_langues']) && $formData['nb_langues'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="langues_container"></div>
                    </div>
                </fieldset>

                <!-- 7. Centres d'Intérêt -->
                <fieldset>
                    <legend>Centres d'Intérêt</legend>
                    <div class="interets">
                        <label for="nb_interets">Nombre de centres d'intérêt:</label>
                        <select name="nb_interets" id="nb_interets">
                            <?php for ($i = 0; $i <= 5; $i++) : ?>
                                <option value="<?= $i ?>" <?= isset($formData['nb_interets']) && $formData['nb_interets'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="interets_container"></div>
                    </div>
                </fieldset>

                <!-- 8. Vos remarques -->
                <fieldset>
                    <legend>Vos remarques</legend>
                    <textarea name="remarque" rows="8"><?= isset($formData['remarque']) ? htmlspecialchars($formData['remarque']) : '' ?></textarea><br>
                    <input type="file" name="remarque_file">
                </fieldset>

                <div>
                    <button type="submit">Envoyer</button>
                    <button type="reset">Effacer</button>
                </div>
            </div>
        </form>
    </section>
    <script>
        const formData = <?= json_encode($formData) ?>;
        var prefilledFormations = <?= json_encode($formData['formations'] ?? []) ?>;
        var prefilledCompetences = <?= json_encode($formData['competences'] ?? []) ?>;
        var prefilledStages = <?= json_encode($formData['stages'] ?? []) ?>;
        var prefilledLangues = <?= json_encode($formData['langues'] ?? []) ?>;
        var prefilledInterets = <?= json_encode($formData['interets'] ?? []) ?>;
        // var prefilledProjets = <?= json_encode($formData['projets'] ?? []) ?>;    
        var prefilledProjets = <?= json_encode($formData['projets'] ?? []) ?>;
        console.log("Projets pré-remplis:", prefilledProjets);
    
        document.addEventListener("DOMContentLoaded", function() {
            prefilledFormations.forEach(formation => {
                addFormation(); // Ajoute une formation vide

                // Sélectionne la dernière formation ajoutée
                var formations = document.querySelectorAll('.formation');
                var lastFormation = formations[formations.length - 1];

                // Remplit les champs avec les valeurs pré-remplies
                lastFormation.querySelector('input[name="formation_title[]"]').value = formation.formation_title;
                lastFormation.querySelector('input[name="formation_institution[]"]').value = formation.formation_institution;
                lastFormation.querySelector('input[name="formation_start[]"]').value = formation.formation_start;
                lastFormation.querySelector('input[name="formation_end[]"]').value = formation.formation_end;
                lastFormation.querySelector('textarea[name="formation_desc[]"]').value = formation.formation_desc;
            });


            prefilledFormations.forEach(formation => addFormation());

            prefilledCompetences.forEach((competence, index) => {
                addCompetence(); // Ajoute une compétence vide

                // Sélectionne la dernière compétence ajoutée
                var competences = document.querySelectorAll('.competence');
                var lastCompetence = competences[competences.length - 1];

                // Remplit les champs avec les valeurs pré-remplies
                lastCompetence.querySelector('input[name="competence_name[]"]').value = competence.competence_name;
                lastCompetence.querySelector('select[name="competence_level[]"]').value = competence.competence_level;
            });
            prefilledStages.forEach(stage => {
                addStage(); // Ajoute un stage vide

                // Sélectionne le dernier stage ajouté
                var stages = document.querySelectorAll('.stage');
                var lastStage = stages[stages.length - 1];

                // Remplit les champs avec les valeurs pré-remplies
                lastStage.querySelector('input[name="stage_title[]"]').value = stage.stage_title;
                lastStage.querySelector('input[name="stage_company[]"]').value = stage.stage_company;
                lastStage.querySelector('input[name="stage_start[]"]').value = stage.stage_start;
                lastStage.querySelector('input[name="stage_end[]"]').value = stage.stage_end;
                lastStage.querySelector('textarea[name="stage_desc[]"]').value = stage.stage_desc;
            });
            prefilledProjets.forEach(proj => {
            addProject(); // Ajoute un projet vide
            console.log("Projet ajouté dynamiquement");

            var projects = document.querySelectorAll('.project');
            var lastProject = projects[projects.length - 1];

            if (lastProject) {
                lastProject.querySelector('input[name="Titre[]"]').value = proj.Titre;
                lastProject.querySelector('input[name="D_debut[]"]').value = proj.D_debut;
                lastProject.querySelector('input[name="D_fin[]"]').value = proj.D_fin;
                lastProject.querySelector('textarea[name="Description[]"]').value = proj.Description;

                console.log("Données du projet insérées:", proj);
            } else {
                console.error("Erreur: Aucun projet ajouté au DOM");
            }
        });


            prefilledLangues.forEach(langue => {
                addLangue(); // Ajoute une langue vide

                var langues = document.querySelectorAll('.langue');
                var lastLangue = langues[langues.length - 1];

                lastLangue.querySelector('input[name="langue[]"]').value = langue.langue;
                lastLangue.querySelector('select[name="niveau[]"]').value = langue.niveau;
            });

            prefilledInterets.forEach(interet => {
                addInteret(); // Ajoute un centre d'intérêt vide

                var interets = document.querySelectorAll('.interet');
                var lastInteret = interets[interets.length - 1];

                lastInteret.querySelector('select[name="type_interet[]"]').value = interet.type_interet;
            });

        });
        

    </script>
    <script src="static\script.js"></script>
</body>
</html>
