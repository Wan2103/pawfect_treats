document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const guideId = urlParams.get("id");

    fetch(`fetch_guide.php?action=single_guide&id=${guideId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("guide-title").textContent = data.guide.title;
                document.getElementById("guide-content").innerHTML = data.guide.content;
                document.getElementById("vet-image").src = data.guide.vet_image;
            } else {
                document.getElementById("guide-content").innerHTML = `<p>${data.message}</p>`;
            }
        })
        .catch(error => console.error("Error loading guide details:", error));
});
