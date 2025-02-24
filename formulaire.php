<?php
    session_start();
    // print_r($_SESSION['form_data']);
    $formData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formData = isset($_SESSION['form_data'])?$_SESSION['form_data']: [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style.css">
    <title>Fiche de renseignements</title>
</head>
<body>
    <section>
        <form method="POST" action="recap.php" enctype="multipart/form-data">
        <h1 style="text-align: center;">Fiche de Renseignements</h1>
        <div class="main_content">
            <fieldset class="rens_perso">
                <legend style="text-align: center;">Renseignement Personnels</legend>
                <span>
                    <label for="nom">Nom:</label> <br>
                    <input type="text" id="nom" name="Nom" value="<?= isset($formData['Nom']) ? htmlspecialchars($formData['Nom']) : '' ?>">
                </span>

                <span>
                    <label for="prenom">Prenom:</label> <br>
                    <input type="text" id="prenom" name="Prenom" value="<?= isset($formData['Prenom']) ? htmlspecialchars($formData['Prenom']) : '' ?>">
                    <!-- <input type="text" id="prenom" name="Prenom"> -->
                </span>

                <span>
                    <label for="age">Age:</label> <br>
                    <input type="number" id="age" name="Age" value="<?= isset($formData['Age']) ? htmlspecialchars($formData['Age']) : '' ?>">
                    <!-- <input type="number" id="age" name="Age"> -->
                </span>

                <span>
                    <label for="tel">Numero de Telephone:</label> <br>
                    <input type="tel" id="tel" name="Tel" value="<?= isset($formData['Tel']) ? htmlspecialchars($formData['Tel']) : '' ?>">
                    <!-- <input type="tel" id="tel" name="Tel"> -->
                </span>

                <span>
                    <label for="email">Email:</label>
                    <!-- <input type="email" id="email" name="Email"> -->
                    <input type="email" id="email" name="Email" value="<?= isset($formData['Email']) ? htmlspecialchars($formData['Email']) : '' ?>">
                </span> 
            </fieldset>

            <fieldset>
                <legend>Renseignement Académique</legend>

                <div class="info_academ">
                    <h4>Vous êtes en: </h4>
                    <span style="border-left: 1px solid black;">
                        <label for="2AP">2AP: </label>
                        <input type="radio" name="Filiere" id="2AP" value="2AP" <?= isset($formData['Filiere']) && $formData['Filiere'] === '2AP' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="GSTR">GSTR: </label>
                        <input type="radio" name="Filiere" id="GSTR" value="GSTR" <?= isset($formData['Filiere']) && $formData['Filiere'] === 'GSTR' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="GI">GI: </label>
                        <input type="radio" name="Filiere" id="GI" value="GI" <?= isset($formData['Filiere']) && $formData['Filiere'] === 'GI' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="SCM">SCM: </label>
                        <input type="radio" name="Filiere" id="SCM" value="SCM" <?= isset($formData['Filiere']) && $formData['Filiere'] === 'SCM' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="GC">GC: </label>
                        <input type="radio" name="Filiere" id="GC" value="GC" <?= isset($formData['Filiere']) && $formData['Filiere'] === 'GC' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="MS">MS: </label>
                        <input type="radio" name="Filiere" id="MS" value="MS" <?= isset($formData['Filiere']) && $formData['Filiere'] === 'MS' ? 'checked' : '' ?>>
                    </span>

                    <hr>
                    <span style="border-left: 1px solid black;">
                        <label for="1er_annee">1er année: </label>
                        <input type="radio" name="Annee" id="1er_annee" value="1er annee" <?= isset($formData['Annee']) && $formData['Annee'] === '1er annee' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="2eme_annee">2eme année: </label>
                        <input type="radio" name="Annee" id="2eme_annee" value="2eme annee" <?= isset($formData['Annee']) && $formData['Annee'] === '2eme annee' ? 'checked' : '' ?>>
                    </span>

                    <span>
                        <label for="3eme_annee">3eme année: </label>
                        <input type="radio" name="Annee" id="3eme_annee" value="3eme annee" <?= isset($formData['Annee']) && $formData['Annee'] === '3eme annee' ? 'checked' : '' ?>>
                    </span>

                    <hr>

                    <h4>Modules suivis cette année :</h4>
                    <?php 
                    $modules = ['Pro Av', 'Compilation', 'reseaux Av', 'Web Avancee', 'POO', 'BD'];
                    foreach ($modules as $module) : ?>
                        <span>
                            <label for="<?= $module ?>"><?= $module ?>: </label>
                            <input type="checkbox" name="Module[]" id="<?= $module ?>" value="<?= $module ?>" <?= isset($formData['Module']) && in_array($module, $formData['Module']) ? 'checked' : '' ?>>
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
                    <div class="project">

                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Langues Parlées:</legend>
                <div class="langues">
                    <label for="nb_langues">Nombre de langues parlées:</label>
                    <select name="nb_langues" id="nb_langues">
                        <?php for ($i = 0; $i <= 5; $i++) : ?>
                            <option value="<?= $i ?>" <?= isset($formData['nb_langues']) && $formData['nb_langues'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <div class="langues_container">

                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Centres d'Intérêt</legend>
                <div class="interets">
                    <label for="nb_interets">Nombre de centres d'intérêt:</label>
                    <select name="nb_interets" id="nb_interets">
                        <?php for ($i = 0; $i <= 5; $i++) : ?>
                            <option value="<?= $i ?>" <?= isset($formData['nb_interets']) && $formData['nb_interets'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <div class="interets_container">

                    </div>
                </div>
            </fieldset>


            <fieldset>
                <legend>Vos remarques</legend>
                <textarea name="remarque" id="" rows="8"><?= isset($formData['remarque']) ? htmlspecialchars($formData['remarque']) : '' ?></textarea> <br>
                <!-- <input type="file" name="remarque_file" <?= isset($formData['remarque_file']) ? 'value="' . htmlspecialchars($formData['remarque_file']) . '"' : '' ?>> -->
                <input type="file" name="remarque_file">
            </fieldset>

            <div>
                <button>Envoyer</button>
                <button>Effacer</button>
            </div>
        </div>
        </form>
    
    </section>

    <script src="static/script.js"> </script>
</body>
</html>