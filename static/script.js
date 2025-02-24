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