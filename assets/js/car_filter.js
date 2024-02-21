// public/js/car_filter.js



const filterForm = document.getElementById("filterForm");
const filterCarsDiv = document.getElementById("filterCars");

filterForm.addEventListener("submit", async (event)=> {
    event.preventDefault(); 
    const marque = document.getElementById('marque').value;
    const mileage = document.getElementById('mileage').value;
    const year = document.document.getElementById('year').value;
    const price = document.getElementById('price').value;

    try {
        const url = `get_car?marque=${marque}&mileage=${mileage}&year=${year}&price=${price}`;
        const response = await fetch(url);

        if (response.ok) {
            const filterData = await response.json();
            filterCarsDiv.innerHTML = '';

            if (filterData.car.length === 0) { 
                const h = document.createElement("h4");
                h.textContent = "Aucun résultat";
                filterCarsDiv.appendChild(h);
            } else {
                filterData.car.forEach((car) => {
                    
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
            console.error("Erreur lors de la requête Ajax",response.status);
        }
    } catch (error) {
        console.error("Une erreur s'est produite :", error);
    }
}); 
