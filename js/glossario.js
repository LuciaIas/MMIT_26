document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('js-search');
    const tornaSu = document.getElementById('tornaSu');
    const termsGrid = document.querySelector('.terms-grid');

    if (searchInput && termsGrid) {
        searchInput.addEventListener('keyup', function() {
            const testoUtente = searchInput.value.toLowerCase();
            const cards = termsGrid.querySelectorAll('.term-card');

            cards.forEach(card => {
                const termineCard = card.getAttribute('data-term').toLowerCase();
                if (termineCard.includes(testoUtente) || testoUtente === "") {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }
});