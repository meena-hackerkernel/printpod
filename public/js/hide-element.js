document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelectorAll("img").forEach(img => {
            img.style.display = "none";
        });
    }, 2000);
});
