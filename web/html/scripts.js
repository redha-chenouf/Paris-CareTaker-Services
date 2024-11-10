document.addEventListener("DOMContentLoaded", () => {
    changeLanguage();
});

function changeLanguage() {
    const language = document.getElementById("languageSelect").value;
    const url = `languages/${language}.json`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Traduction de la section Accueil
            document.querySelector("#homeTitle").innerText = data.home.title;
            document.querySelector("#homeDescription").innerText = data.home.description;
            document.querySelector("#homeButton").innerText = data.home.button;

            // Traduction des appartements en vedette
            const apartments = data.apartments;
            const apartmentsContainer = document.querySelector("#apartmentsList");
            apartmentsContainer.innerHTML = ''; // Efface le contenu précédent

            apartments.forEach((apt, index) => {
                const card = `
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="${apt.image}" class="card-img-top" alt="${apt.alt}">
                            <div class="card-body">
                                <h5 class="card-title">${apt.title}</h5>
                                <p class="card-text">${apt.description}</p>
                                <a href="#" class="btn btn-primary">${apt.button}</a>
                            </div>
                        </div>
                    </div>
                `;
                apartmentsContainer.innerHTML += card;
            });

            // Traduction des services
            const services = data.services;
            const servicesContainer = document.querySelector("#servicesList");
            servicesContainer.innerHTML = ''; // Efface le contenu précédent

            services.forEach((service, index) => {
                const serviceCard = `
                    <div class="col-md-4 text-center">
                        <div class="icon mb-3">
                            <!-- Remplacer l'image par le chemin réel -->
                            <img src="path/to/service${index + 1}.png" alt="${service.title}" class="img-fluid">
                        </div>
                        <h5>${service.title}</h5>
                        <p>${service.description}</p>
                    </div>
                `;
                servicesContainer.innerHTML += serviceCard;
            });

            // Traduction de la section À Propos de Nous
            document.querySelector("#aboutTitle").innerText = data.about.title;
            document.querySelector("#aboutDescription").innerText = data.about.description;
            document.querySelector("#aboutDescription2").innerText = data.about.description2;

            // Traduction de la section Contactez-Nous
            document.querySelector("#contactTitle").innerText = data.contact.title;
            document.querySelector("#contactDescription").innerText = data.contact.description;
        })
        .catch(error => {
            console.error('Error fetching the language file:', error);
        });
}
