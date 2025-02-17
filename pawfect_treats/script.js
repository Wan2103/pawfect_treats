document.addEventListener("DOMContentLoaded", function () {
    fetch("http://localhost/pawfect_treats/load_cats.php")
        .then(response => response.json())
        .then(data => {
            const catList = document.getElementById("cat-list");
            catList.innerHTML = ""; // Clear existing content

            data.forEach(cat => {
                const catCard = `
                    <div class="adoption-card">
                        <div class="love-icon">❤️</div>
                        <div class="adoption-info">
                            <img class="adoption-cat-img" src="${cat.image}" alt="${cat.name}">
                            <div class="adoption-details">
                                <div class="adoption-fosterer-info">
                                    <img class="fosterer-img" src="${cat.fosterer_image}" alt="${cat.fosterer_name}">
                                    <span class="adoption-fosterer-name">${cat.fosterer_name}</span>
                                </div>
                                <p><strong>Name:</strong> ${cat.name}</p>
                                <p><strong>Gender:</strong> ${cat.gender}</p>
                                <p><strong>Age:</strong> ${cat.age} months</p>
                                <p><strong>Neutered/Spayed:</strong> ${cat.neutered}</p>
                                <p>${cat.description}</p>
                                <div class="adoption-buttons">
                                    <button class="adoption-btn">Adopt Me</button>
                                    <button class="say-hi-btn">Say Hi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                catList.innerHTML += catCard;
            });
        })
        .catch(error => console.error("Error fetching cats:", error));
});

function openResetPasswordModal() {
    document.getElementById("reset-password-modal").style.display = "flex";
}

function closeResetPasswordModal() {
    document.getElementById("reset-password-modal").style.display = "none";
}

// Send Reset Link
document.getElementById("send-reset-link").addEventListener("click", function () {
    const email = document.getElementById("reset-email").value;

    if (email) {
        fetch("reset_password.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "email=" + encodeURIComponent(email)
        })
        .then(response => response.text())
        .then(message => alert(message))
        .catch(error => console.error("Error:", error));

        closeResetPasswordModal();
    } else {
        alert("Please enter your email.");
    }
});


