document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("cat-img")) loadCatOfTheDay();
    if (document.getElementById("merchandise-img")) loadMerchOfTheDay();
    if (document.getElementById("reviews-container")) loadReviews();
    if (document.getElementById("profile-image")) loadProfile();
});

// Generic function to fetch data
function fetchData(url, callback) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                callback(data);
            } else {
                console.error(`Error fetching data from ${url}:`, data.message);
            }
        })
        .catch(error => console.error(`Error loading ${url}:`, error));
}

// Load Profile Data
function loadProfile() {
    fetchData("index.php", (data) => {
        updateElementImage("profile-image", data.userImage);
    });
}

// Load Cat of the Day
function loadCatOfTheDay() {
    fetchData("index.php", (data) => {
        if (data.cat) {
            updateElementImage("cat-img", data.cat.image);
            updateElementText("cat-name", data.cat.name);
            updateElementText("cat-gender", data.cat.gender);
            updateElementText("cat-age", `${data.cat.age} years`);
        }
    });
}

// Load Merchandise of the Day
function loadMerchOfTheDay() {
    fetchData("index.php", (data) => {
        if (data.merchandise) {
            updateElementImage("merchandise-img", data.merchandise.image);
            updateElementText("merchandise-name", data.merchandise.name);
            updateElementText("merchandise-price", `$${data.merchandise.price}`);
        }
    });
}

// Load User Reviews
function loadReviews() {
    fetchData("index.php", (data) => {
        const reviewsContainer = document.getElementById("reviews-container");
        if (!reviewsContainer) return;

        reviewsContainer.innerHTML = ""; // Clear existing reviews

        if (data.reviews.length === 0) {
            reviewsContainer.innerHTML = "<p>No reviews yet.</p>";
            return;
        }

        data.reviews.forEach(review => {
            const reviewElement = document.createElement("p");
            reviewElement.textContent = `⭐ ${review}`;
            reviewsContainer.appendChild(reviewElement);
        });
    });
}

// Utility function to update text content of an element
function updateElementText(elementId, text) {
    const element = document.getElementById(elementId);
    if (element) element.textContent = text;
}

// Utility function to update image source
function updateElementImage(elementId, src) {
    const element = document.getElementById(elementId);
    if (element) element.src = src;
}

// Handle login form
const loginForm = document.getElementById("login-form");
if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        fetch("login_process.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.href = "index.html";
            }
        })
        .catch(error => console.error("Error:", error));
    });
}
