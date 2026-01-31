document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('js-search');
    const termsGrid = document.querySelector('.terms-grid');

    if (searchInput && termsGrid) {
        searchInput.addEventListener('keyup', function() {
            const testoUtente = searchInput.value.toLowerCase();
            const cards = termsGrid.querySelectorAll('.term-card');

            cards.forEach(card => {
                const termineCard = card.getAttribute('data-term').toLowerCase();
                card.style.display = termineCard.includes(testoUtente) ? "block" : "none";
            });
        });
    }
});
