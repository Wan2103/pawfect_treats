document.addEventListener("DOMContentLoaded", function () {
    const merchandiseContainer = document.getElementById("merchandise-container");

    function fetchMerchandise() {
        fetch("fetch_merchandise.php?action=all_merch")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMerchandise(data.merchandise);
                } else {
                    merchandiseContainer.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error("Error fetching merchandise:", error);
                merchandiseContainer.innerHTML = `<p>Failed to load merchandise.</p>`;
            });
    }

    function displayMerchandise(items) {
        merchandiseContainer.innerHTML = "";
        items.forEach(item => {
            const itemCard = document.createElement("div");
            itemCard.classList.add("merch-card");
            itemCard.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <h3>${item.name}</h3>
                <p><strong>Price:</strong> $${item.price}</p>
                <button class="buy-btn" data-id="${item.id}">Buy Now</button>
            `;
            merchandiseContainer.appendChild(itemCard);
        });
    }

    fetchMerchandise();
});
