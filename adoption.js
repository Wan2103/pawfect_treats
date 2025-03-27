document.addEventListener("DOMContentLoaded", function () {
    const adoptionContainer = document.getElementById("adoption-container");

    function fetchCats() {
        fetch("adoption.php", { method: "GET" })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.cats.length > 0) {
                    displayCats(data.cats);
                } else {
                    adoptionContainer.innerHTML = `<p>No cats available for adoption.</p>`;
                }
            })
            .catch(error => {
                console.error("Error fetching cats:", error);
                adoptionContainer.innerHTML = `<p>Failed to load cats. Please try again later.</p>`;
            });
    }

    function displayCats(cats) {
        adoptionContainer.innerHTML = ""; // Clear container before adding new content
    
        cats.forEach(cat => {
            const catCard = document.createElement("div");
            catCard.classList.add("cat-card");
            catCard.innerHTML = `
                <h3 class="cat-name">${cat.name}</h3>
                <img src="${cat.image}" alt="${cat.name}">
                <div class="cat-details">
                    <p><strong>Breed:</strong> ${cat.breed}</p>
                    <p><strong>Gender:</strong> ${cat.gender}</p>
                    <p><strong>Age:</strong> ${cat.age} years</p>
                    <p><strong>Neutered:</strong> ${cat.neutered ? "Yes" : "No"}</p>
                    <p>${cat.description}</p>
                    <div class="button-container">
                        <button class="adopt-btn" data-id="${cat.id}">Adopt Me</button>
                        <button class="view-more-btn" data-id="${cat.id}">View More</button>
                    </div>
                </div>
            `;
            adoptionContainer.appendChild(catCard);
        });
    
        // Adoption button event
        document.querySelectorAll(".adopt-btn").forEach(button => {
            button.addEventListener("click", function () {
                const catId = this.getAttribute("data-id");
                adoptCat(catId);
            });
        });
    
        // View More button event
        document.querySelectorAll(".view-more-btn").forEach(button => {
            button.addEventListener("click", function () {
                const catId = this.getAttribute("data-id");
                window.location.href = `detail_cat.html?id=${catId}`;
            });
        });
    }
    

    function adoptCat(catId) {
        fetch("adoption.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cat_id: catId })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) fetchCats(); // Refresh cat list after adoption
        })
        .catch(error => console.error("Error processing adoption:", error));
    }

    fetchCats();
});
