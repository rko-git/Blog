const searchInput = document.getElementById("searchInput");
const filterButtons = document.querySelectorAll(".filter-btn");
const postCards = document.querySelectorAll(".post-card");
const consentCheckbox = document.getElementById("consent");
const submitButton = document.getElementById("submitButton");

if (searchInput && filterButtons.length > 0 && postCards.length > 0) {
    let activeCategory = "all";

    function getCardCategories(card) {
        return (card.dataset.category || "")
            .split(",")
            .map((slug) => slug.trim().toLowerCase())
            .filter(Boolean);
    }

    function updatePosts() {
        const query = searchInput.value.trim().toLowerCase();
        const activeSlug = activeCategory.toLowerCase();

        postCards.forEach((card) => {
            const title = card.querySelector("h3")?.textContent.toLowerCase() || "";
            const meta = card.querySelector(".meta")?.textContent.toLowerCase() || "";
            const paragraphs = card.querySelectorAll("p");
            const content = paragraphs.length > 0
                ? paragraphs[paragraphs.length - 1].textContent.toLowerCase()
                : "";
            const cardCategories = getCardCategories(card);

            const matchesSearch = !query
                || title.includes(query)
                || meta.includes(query)
                || content.includes(query);
            const matchesCategory = activeSlug === "all"
                || cardCategories.includes(activeSlug);

            card.style.display = matchesSearch && matchesCategory ? "flex" : "none";
        });
    }

    searchInput.addEventListener("input", updatePosts);

    filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
            filterButtons.forEach((btn) => btn.classList.remove("active"));
            button.classList.add("active");
            activeCategory = button.dataset.category || "all";
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
