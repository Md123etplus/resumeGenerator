//handle the action when "2AP" checked
document.addEventListener("DOMContentLoaded", function () {
    const filiereRadios = document.querySelectorAll('input[name="filiere"]');
    const annee3eme = document.getElementById("3eme_annee");

    function toggleAnnee() {
        const is2APChecked = document.getElementById("2AP").checked;

        if (is2APChecked) {
            annee3eme.disabled = true;
            annee3eme.checked = false;
        } else {
            annee3eme.disabled = false;
        }
    }

    // Appliquer la règle au chargement de la page
    toggleAnnee();

    // Ajouter un écouteur sur chaque radio "Filiere"
    filiereRadios.forEach(radio => {
        radio.addEventListener("change", toggleAnnee);
    });
});

//generating project form details
document.addEventListener("DOMContentLoaded", function () {
    const projectContainer = document.querySelector(".project_container");
    const projectSelect = document.getElementById("projet");

    projectSelect.addEventListener("change", function () {
        projectContainer.innerHTML = ""; // Vider le container
        for (let i = 1; i <= this.value; i++) {
            const projectDiv = document.createElement("div");
            projectDiv.classList.add("project");
            projectDiv.innerHTML = `
                <h2>Projet ${i}</h2>
                <span>
                    <label for="titre${i}">Titre</label>
                    <input type="text" name="Titre[]" id="titre${i}">
                </span>
                <span>
                    <label for="debut${i}">Date début</label>
                    <input type="date" name="D_debut[]" id="debut${i}">
                </span>
                <span>
                    <label for="fin${i}">Date fin</label>
                    <input type="date" name="D_fin[]" id="fin${i}">
                </span>
                <span>
                    <label for="Description${i}">Description</label> <br>
                    <textarea name="Description[]" id="Description${i}"></textarea>
                </span>

                <hr>
            `;
            projectContainer.appendChild(projectDiv);
        }
    });


    //generating language form details
    const languesContainer = document.querySelector(".langues_container");
    const languesSelect = document.getElementById("nb_langues");

    languesSelect.addEventListener("change", function () {
        languesContainer.innerHTML = ""; // Clear the container
        
        for (let i = 1; i <= this.value; i++) {
            const langueDiv = document.createElement("div");
            langueDiv.classList.add("langue");
            langueDiv.innerHTML = `
                <h2>Langue ${i}</h2>
                <span>
                    <label for="langue${i}">Langue:</label>
                    <input type="text" name="langue[]" id="langue${i}" placeholder="Entrez la langue">
                </span> <br> <br>
                <span>
                    <label for="niveau${i}">Niveau:</label>
                    <select name="niveau[]" id="niveau${i}">
                        <option value="">Sélectionnez un niveau</option>
                        <option value="debutant">Débutant</option>
                        <option value="intermediaire">Intermédiaire</option>
                        <option value="avance">Avancé</option>
                        <option value="natif">Natif</option>
                    </select>
                </span>

                <hr>
            `;
            languesContainer.appendChild(langueDiv);
        }
    });

    //generating interest form details
    const interetsContainer = document.querySelector(".interets_container");
    const interetsSelect = document.getElementById("nb_interets");

    interetsSelect.addEventListener("change", function () {
        interetsContainer.innerHTML = ""; // Clear the container
        
        for (let i = 1; i <= this.value; i++) {
            const interetDiv = document.createElement("div");
            interetDiv.classList.add("interet");
            interetDiv.innerHTML = `
                <h2>Centre d'intérêt ${i}</h2>
                <span>
                    <label for="interet${i}">Type d'intérêt:</label>
                    <select name="type_interet[]" id="type_interet${i}">
                        <option value="">Sélectionnez un type</option>
                        <option value="sport">Sport</option>
                        <option value="musique">Musique</option>
                        <option value="lecture">Lecture</option>
                        <option value="voyage">Voyage</option>
                        <option value="technologie">Technologie</option>
                        <option value="art">Art</option>
                        <option value="cuisine">Cuisine</option>
                        <option value="photographie">Photographie</option>
                        <option value="jardinage">Jardinage</option>
                        <option value="autre">Autre</option>
                    </select>
                </span>
                <hr>
            `;
            interetsContainer.appendChild(interetDiv);
        }
    });
   
});

 // dynamic js for new 
    // --- Fonctions communes ---
    function removeElement(button) {
        button.parentElement.remove();
    }

    // --- Ajout dynamique pour les Projets (code existant) ---
    document.addEventListener("DOMContentLoaded", function () {
        const projectContainer = document.querySelector(".project_container");
        const projectSelect = document.getElementById("projet");
        projectSelect.addEventListener("change", function () {
            const projectContainer = document.querySelector(".project_container");
            projectContainer.innerHTML = ""; // Vider le container

            for (let i = 0; i < this.value; i++) {
                addProject(); // Ajoute un projet à chaque itération
            }
        });

        // --- Langues (code existant) ---
        // addLangue();
        // // --- Centres d'Intérêt (code existant) ---
        // addInteret();
        
    });

    function addProject() {
        const projectContainer = document.querySelector(".project_container");
        const index = projectContainer.children.length + 1; // Déterminer le numéro du projet
    
        const projectDiv = document.createElement("div");
        projectDiv.classList.add("project");
        projectDiv.innerHTML = `
            <h2>Projet ${index}</h2>
            <span>
                <label for="titre${index}">Titre:</label>
                <input type="text" name="Titre[]" id="titre${index}">
            </span>
            <span>
                <label for="debut${index}">Date début:</label>
                <input type="date" name="D_debut[]" id="debut${index}">
            </span>
            <span>
                <label for="fin${index}">Date fin:</label>
                <input type="date" name="D_fin[]" id="fin${index}">
            </span>
            <span>
                <label for="Description${index}">Description:</label><br>
                <textarea name="Description[]" id="Description${index}"></textarea>
            </span>
            <hr>
        `;
        projectContainer.appendChild(projectDiv);
    }
    
    //ajout d'une langue
    function addLangue() {
        const languesContainer = document.querySelector(".langues_container");
        const index = languesContainer.children.length + 1; // Déterminer le numéro de la nouvelle langue
    
        const langueDiv = document.createElement("div");
        langueDiv.classList.add("langue");
        langueDiv.innerHTML = `
            <h2>Langue ${index}</h2>
            <span>
                <label for="langue${index}">Langue:</label>
                <input type="text" name="langue[]" id="langue${index}" placeholder="Entrez la langue">
            </span><br><br>
            <span>
                <label for="niveau${index}">Niveau:</label>
                <select name="niveau[]" id="niveau${index}">
                    <option value="">Sélectionnez un niveau</option>
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire">Intermédiaire</option>
                    <option value="avance">Avancé</option>
                    <option value="natif">Natif</option>
                </select>
            </span>
            <hr>
        `;
        languesContainer.appendChild(langueDiv);
    }
    //add Interest
    function addInteret() {
        const interetsContainer = document.querySelector(".interets_container");
        const index = interetsContainer.children.length + 1; // Déterminer le numéro du nouvel intérêt
    
        const interetDiv = document.createElement("div");
        interetDiv.classList.add("interet");
        interetDiv.innerHTML = `
            <h2>Centre d'intérêt ${index}</h2>
            <span>
                <label for="interet${index}">Type d'intérêt:</label>
                <select name="type_interet[]" id="type_interet${index}">
                    <option value="">Sélectionnez un type</option>
                    <option value="sport">Sport</option>
                    <option value="musique">Musique</option>
                    <option value="lecture">Lecture</option>
                    <option value="voyage">Voyage</option>
                    <option value="technologie">Technologie</option>
                    <option value="art">Art</option>
                    <option value="cuisine">Cuisine</option>
                    <option value="photographie">Photographie</option>
                    <option value="jardinage">Jardinage</option>
                    <option value="autre">Autre</option>
                </select>
            </span>
            <hr>
        `;
        interetsContainer.appendChild(interetDiv);
    }
    
    // --- Fonctions pour les nouveaux éléments ---

    // Ajout d'un Stage
    function addStage() {
        var container = document.getElementById('stages_container');
        var count = container.children.length + 1;
        var div = document.createElement('div');
        div.className = 'stage';
        div.innerHTML = `
            <h3>Stage ${count}</h3>
            <label>Intitulé: <input type="text" name="stage_title[]"></label><br>
            <label>Entreprise: <input type="text" name="stage_company[]"></label><br>
            <label>Date de début: <input type="date" name="stage_start[]"></label><br>
            <label>Date de fin: <input type="date" name="stage_end[]"></label><br>
            <label>Description:<br> <textarea name="stage_desc[]"></textarea></label><br>
            <button type="button" onclick="removeElement(this)">Supprimer ce stage</button>
            <hr>
        `;
        container.appendChild(div);
    }

    // Ajout d'une Formation
    function addFormation() {
        var container = document.getElementById('formations_container');
        var count = container.children.length + 1;
        var div = document.createElement('div');
        div.className = 'formation';
        div.innerHTML = `
            <h3>Formation ${count}</h3>
            <label>Intitulé: <input type="text" name="formation_title[]"></label><br>
            <label>Établissement: <input type="text" name="formation_institution[]"></label><br>
            <label>Date de début: <input type="date" name="formation_start[]"></label><br>
            <label>Date de fin: <input type="date" name="formation_end[]"></label><br>
            <label>Description:<br> <textarea name="formation_desc[]"></textarea></label><br>
            <button type="button" onclick="removeElement(this)">Supprimer cette formation</button>
            <hr>
        `;
        container.appendChild(div);
    }

    // Ajout d'une Compétence
    function addCompetence() {
        var container = document.querySelector('.competences_container');
        var count = container.children.length + 1;
        var div = document.createElement('div');
        div.className = 'competence';
        div.innerHTML = `
            <h3>Compétence ${count}</h3>
            <label>Nom de la compétence: <input type="text" name="competence_name[]"></label><br>
            <label>Niveau: 
                <select name="competence_level[]">
                    <option value="">Sélectionnez un niveau</option>
                    <option value="Débutant">Débutant</option>
                    <option value="Intermédiaire">Intermédiaire</option>
                    <option value="Avancé">Avancé</option>
                </select>
            </label><br>
            <button type="button" onclick="removeElement(this)">Supprimer cette compétence</button>
            <hr>
        `;
        container.appendChild(div);
    }
// document.addEventListener("DOMContentLoaded", function() {

//     prefilledStages.forEach(stage => addStage(stage));
//     prefilledFormations.forEach(formation => addFormation(formation));
// });

   