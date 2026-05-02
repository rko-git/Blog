const searchInput = document.getElementById("searchInput");
const filterButtons = document.querySelectorAll(".filter-btn");
const postCards = document.querySelectorAll(".post-card");
const consentCheckbox = document.getElementById("consent");
const submitButton = document.getElementById("submitButton");

if (searchInput && filterButtons.length > 0 && postCards.length > 0) {
    let activeCategory = "all";

    function updatePosts() {
        const query = searchInput.value.trim().toLowerCase();

        postCards.forEach((card) => {
            const title = card.querySelector("h3").textContent.toLowerCase();
            const content = card.querySelector("p:last-of-type").textContent.toLowerCase();
            const category = card.dataset.category;

            const matchesSearch = title.includes(query) || content.includes(query);
            const matchesCategory = activeCategory === "all" || category === activeCategory;

            card.style.display = matchesSearch && matchesCategory ? "flex" : "none";
        });
    }

    searchInput.addEventListener("input", updatePosts);

    filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
            filterButtons.forEach((btn) => btn.classList.remove("active"));
            button.classList.add("active");
            activeCategory = button.dataset.category;
            updatePosts();
        });
    });
}

if (consentCheckbox && submitButton) {
    const updateSubmitState = () => {
        submitButton.disabled = !consentCheckbox.checked;
    };

    consentCheckbox.addEventListener("change", updateSubmitState);
    updateSubmitState();
}
