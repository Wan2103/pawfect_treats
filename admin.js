document.addEventListener("DOMContentLoaded", function () {
    loadAdminDashboard();
});

function loadAdminDashboard() {
    fetch("admin_fetch.php?action=dashboard")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Admin data loaded.");
            } else {
                alert("Access Denied. Redirecting...");
                window.location.href = "index.html";
            }
        })
        .catch(error => console.error("Error loading admin data:", error));
}
