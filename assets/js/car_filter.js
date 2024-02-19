// public/js/car_filter.js

const filterForm = document.getElementById("filterForm");
const filterCarsDiv = document.getElementById("filterCars");

filterForm.addEventListener("submit", async (e)=> {
    e.preventDefault(); // Correction de la faute de frappe "preventDefualt" à "preventDefault"

    const marque = document.querySelector("#marque").value; // Ajout du caractère "#" pour sélectionner l'élément par ID
    const mileage = document.querySelector("#mileage").value;
    const year = document.querySelector("#year").value;
    const price = document.querySelector("#price").value;

    try {
        const url = `get_cars?marque=${marque}&mileage=${mileage}&year=${year}&price=${price}`; // Correction du nom de l'URL
        const response = await fetch(url);

        if (response.ok) {
            const filterData = await response.json();
            filterCarsDiv.innerHTML = '';

            if (filterData.cars.length === 0) { 
                const h = document.createElement("h4");
                h.textContent = "Aucun résultat";
                filterCarsDiv.appendChild(h);
            } else {
                filterData.cars.forEach((car) => {
                    // Créer et ajouter des éléments HTML pour afficher les voitures filtrées
                    let carDiv = document.createElement('div');
                    carDiv.innerHTML = `
                        <img src="${car.image}" alt="photo de voiture"> 
                        <h3>${car.marque}</h3>
                        <p>mileage: ${car.mileage} km</p>
                        <p>year: ${car.year}</p>
                        <p>price: ${car.price / 100} €</p>
                        <a href="${car.url}" class="btn btn-card">Je sui interressé par ce véhicule</a>
                    `;
                    filterCarsDiv.appendChild(carDiv);
                });
            }
        } else {
            console.error("Erreur lors de la requête Ajax");
        }
    } catch (error) {
        console.error("Une erreur s'est produite :", error);
    }
});