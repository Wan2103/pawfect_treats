// This event listener will execute once the DOM content has fully loaded
document.addEventListener("DOMContentLoaded", function () {
    // Declare variables to hold elements that will be dynamically updated
    const profileImage = document.getElementById("profile-image");
    const catImage = document.getElementById("cat-img");
    const catName = document.getElementById("cat-name");
    const catGender = document.getElementById("cat-gender");
    const catAge = document.getElementById("cat-age");
    const merchandiseImage = document.getElementById("merchandise-img");
    const merchandiseName = document.getElementById("merchandise-name");
    const merchandisePrice = document.getElementById("merchandise-price");
    const reviewsContainer = document.getElementById("reviews-container");
    const profileUsername = document.getElementById("profile-username");
    const profileEmail = document.getElementById("profile-email");
    const profileRole = document.getElementById("profile-role");

    // Function to fetch data from a given URL and execute a callback with the data
    function fetchData(url, callback) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data);
                } else {
                    console.error(`Error fetching data from ${url}:`, data.message || "Unknown error");
                }
            })
            .catch(error => console.error(`Error loading ${url}:`, error));
    }

    // Fetch Profile Data (including profile image, username, email, etc.)
    fetchData("fetch_profile.php?action=profile", (data) => {
        console.log(data);  // Log the response to verify data
        if (data.success) {
            profileUsername.textContent = data.username;
            profileEmail.textContent = data.email;
            profileRole.textContent = data.role;
            profileImage.src = data.images;
        } else {
            console.error("Profile data not fetched successfully");
        }
    });

    // Fetch Cat of the Day details
    fetchData("fetch_cat.php?action=cat", (data) => {
        if (data.image && data.name && data.gender && data.age) {
            catImage.src = data.image;
            catName.textContent = data.name;
            catGender.textContent = data.gender;
            catAge.textContent = data.age;
        } else {
            catName.textContent = "Cat details unavailable";
            catGender.textContent = "";
            catAge.textContent = "";
            console.error("Cat data is incomplete in response");
        }
    });

    // Fetch Merchandise of the Day details
    fetchData("fetch_merchandise.php?action=merchandise", (data) => {
        if (data.data && data.data.length > 0) {
            const merchandise = data.data[0]; // Assuming there's one item in the response array
            merchandiseName.textContent = merchandise.item_name;  // 'item_name' from database
            merchandisePrice.textContent = `$${merchandise.price}`;  // 'price' from database
        } else {
            merchandiseName.textContent = "No merchandise available.";
            merchandisePrice.textContent = "";
        }
    });

    // Fetch User Reviews and display them
    fetchData("fetch_reviews.php?action=reviews", (data) => {
        reviewsContainer.innerHTML = "";
        if (data.reviews && Array.isArray(data.reviews)) {
            data.reviews.forEach(review => {
                const reviewElement = document.createElement("p");
                if (review.review && review.review_point) {
                    reviewElement.textContent = `${review.review} (Rating: ${review.review_point}/5)`;
                } else {
                    reviewElement.textContent = `${review} (Rating: Not Available)`;
                }
                reviewsContainer.appendChild(reviewElement);
            });
        } else {
            console.error("No reviews found or reviews data is in incorrect format");
            reviewsContainer.innerHTML = "No reviews available.";
        }
    });
});

// This event listener will manage the login form and reset password functionality
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById('login-form');

    // Handle login form submission via AJAX
    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        var formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        fetch('login_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.replace(data.redirect); // Redirect to index.html
            } else {
                alert(data.message); // Show error message
            }
        })
        .catch(() => {
            alert('There was an error. Please try again.');
        });
    });

    // Handle Forgot Password button click
    document.getElementById('reset-password-btn').addEventListener('click', function() {
        document.getElementById('reset-popup').style.display = 'block';
    });

    // Close reset popup
    document.getElementById('close-reset').addEventListener('click', function() {
        document.getElementById('reset-popup').style.display = 'none';
    });

    // Handle reset password confirmation
    document.getElementById('confirm-reset').addEventListener('click', function() {
        var resetEmail = document.getElementById('reset-email').value;
        // Implement the password reset logic here (e.g., AJAX request to reset password)
        alert("Password reset instructions have been sent to " + resetEmail);
        document.getElementById('reset-popup').style.display = 'none';
    });
});
