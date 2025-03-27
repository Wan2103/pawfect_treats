document.addEventListener("DOMContentLoaded", function () {
    const guideContainer = document.getElementById("guide-container");

    function fetchGuides() {
        fetch("fetch_guide.php?action=all_guides") // ✅ Correct API path
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayGuides(data.guides);
                } else {
                    guideContainer.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error("Error fetching guides:", error);
                guideContainer.innerHTML = "<p>Failed to load guides. Please try again later.</p>";
            });
    }

    function displayGuides(guides) {
        guideContainer.innerHTML = "";

        guides.forEach(guide => {
            const guideCard = document.createElement("div");
            guideCard.classList.add("guide-card");

            // ✅ Fix: Ensure content exists, otherwise show a fallback message
            const previewText = guide.content ? guide.content.substring(0, 100) + "..." : "No description available.";

            guideCard.innerHTML = `
                <h3>${guide.title}</h3>
                <p>${previewText}</p>
                <button class="read-more" data-id="${guide.id}">Read More</button>
            `;

            guideContainer.appendChild(guideCard);
        });

        document.querySelectorAll(".read-more").forEach(button => {
            button.addEventListener("click", function () {
                const guideId = this.getAttribute("data-id");
                window.location.href = `detail_guide.html?id=${guideId}`;
            });
        });
    }

    fetchGuides();
});
