/* Gestione filtro in tempo reale 
   Non usiamo jQuery (Vietato dal regolamento)
*/

document.addEventListener("DOMContentLoaded", function() {
    
    // Recuperiamo l'input di ricerca e tutte le card
    var searchInput = document.getElementById('js-search');
    var cards = document.querySelectorAll('.term-card');

    // Se l'input esiste, ascoltiamo l'evento 'keyup' (tasto rilasciato)
    if (searchInput) {
        searchInput.addEventListener('keyup', function(evento) {
            
            // Testo scritto dall'utente (minuscolo)
            var testoUtente = searchInput.value.toLowerCase();

            // Ciclo su tutte le card (Simile a un foreach)
            cards.forEach(function(card) {
                // Recupero il termine salvato nell'attributo data-term
                var termineCard = card.getAttribute('data-term');

                // Se il termine contiene il testo utente -> Mostra
                if (termineCard.includes(testoUtente)) {
                    card.style.display = "block";
                } else {
                    // Altrimenti -> Nascondi
                    card.style.display = "none";
                }
            });
        });
    }
});