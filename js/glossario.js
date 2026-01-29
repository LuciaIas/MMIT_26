document.addEventListener("DOMContentLoaded", function() {
    
    var searchInput = document.getElementById('js-search');
    var cards = document.querySelectorAll('.term-card');

    if (searchInput) {
        searchInput.addEventListener('keyup', function(evento) {
            
            var testoUtente = searchInput.value.toLowerCase();

            cards.forEach(function(card) {
                var termineCard = card.getAttribute('data-term');

                if (termineCard.includes(testoUtente)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }
});