document.getElementById('filter-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch('/car/filter?' + new URLSearchParams(formData), {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        const carsContainer = document.getElementById('filterCars');
        carsContainer.innerHTML = '';

        if (data.cars && data.cars.length > 0) {
            data.cars.forEach(car => {
                // Function to escape HTML special characters
                const escapeHTML = (str) => {
                    return str.replace(/&/g, '&amp;')
                              .replace(/</g, '&lt;')
                              .replace(/>/g, '&gt;')
                              .replace(/"/g, '&quot;')
                              .replace(/'/g, '&#39;');
                };

                const carCard = `
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="/images/car/${escapeHTML(car.image)}" class="card-img-top" alt="voiture">
                            <div class="card-body">
                                <h5 class="card-title">${escapeHTML(car.marque)}</h5>
                                <p class="card-text">
                                    Kilométrage : ${escapeHTML(car.mileage.toString())} km<br>
                                    Année : ${escapeHTML(car.year.toString())}<br>
                                    Prix : ${escapeHTML((car.price / 100).toFixed(2).toString())} €
                                </p>
                                <a href="${escapeHTML(car.url)}" class="btn btn-primary">Voir Détails</a>
                            </div>
                        </div>
                    </div>
                `;
                carsContainer.innerHTML += carCard;
            });
        } else {
            carsContainer.innerHTML = '<p>Aucune voiture ne correspond à vos critères de recherche.</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const carsContainer = document.getElementById('filterCars');
        carsContainer.innerHTML = '<p>Une erreur est survenue lors de la récupération des données. Veuillez réessayer plus tard.</p>';
    });
});
