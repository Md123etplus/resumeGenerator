<?php
    session_start();
    // print_r($_SESSION['form_data']);
    $formData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
    }
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
                        <input type="text" id="nom" name="nom" value="<?= isset($formData['nom']) ? htmlspecialchars($formData['nom']) : '' ?>">
                    </span>
                    <span>
                        <label for="prenom">Prénom:</label><br>
                        <input type="text" id="prenom" name="prenom" value="<?= isset($formData['prenom']) ? htmlspecialchars($formData['prenom']) : '' ?>">
                    </span>
                    <span>
                        <label for="age">Âge:</label><br>
                        <input type="number" id="age" name="age" value="<?= isset($formData['age']) ? htmlspecialchars($formData['age']) : '' ?>">
                    </span>
                    <span>
                        <label for="tel">Téléphone:</label><br>
                        <input type="tel" id="tel" name="tel" value="<?= isset($formData['tel']) ? htmlspecialchars($formData['tel']) : '' ?>">
                    </span>
                    <span>
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" value="<?= isset($formData['email']) ? htmlspecialchars($formData['email']) : '' ?>">
                    </span>
                </fieldset>

                <!-- 2. Photo -->
                <fieldset>
                    <legend>Photo</legend>
                    <input type="file" name="photo">
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
    <script src="static\script.js"></script>
</body>
</html>
