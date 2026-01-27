document.addEventListener('DOMContentLoaded', () => {

    /* ===========================
       DRAG & DROP
    =========================== */
    const draggables = document.querySelectorAll('.drag-item');
    const dropZones = document.querySelectorAll('.drop-zone');

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', e.target.id);
            e.dataTransfer.effectAllowed = 'move';
        });
    });

    dropZones.forEach(zone => {
        zone.addEventListener('dragover', e => {
            e.preventDefault(); // permette il drop
            zone.classList.add('over'); // effetto hover
        });

        zone.addEventListener('dragleave', e => {
            zone.classList.remove('over');
        });

        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('over');

            const id = e.dataTransfer.getData('text/plain');
            const draggedEl = document.getElementById(id);
            if (!draggedEl) return;

            // Inserisci il termine nella drop zone
            zone.textContent = draggedEl.textContent;

            // Aggiorna input nascosto
            const hiddenInput = zone.nextElementSibling;
            if (hiddenInput && hiddenInput.tagName === 'INPUT') {
                hiddenInput.value = draggedEl.textContent;
            }

            // Nascondi il termine trascinato
            draggedEl.style.display = 'none';
        });
    });

    /* ===========================
       VALIDAZIONE QUIZ
    =========================== */
    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', e => {
            let incomplete = [];

            // 1) Vero/Falso
            const vfNames = [...new Set([...document.querySelectorAll('input[name^="risposte[vf]"]')].map(i => i.name))];
            vfNames.forEach(name => {
                if (!document.querySelector(`input[name="${name}"]:checked`)) {
                    if (!incomplete.includes('Vero/Falso')) incomplete.push('Vero/Falso');
                }
            });

            // 2) Completa Frase
            const cfInputs = document.querySelectorAll('input[name^="risposte[cf]"]');
            if ([...cfInputs].some(input => input.value.trim() === '')) {
                if (!incomplete.includes('Completa Frase')) incomplete.push('Completa Frase');
            }

            // 3) Output Immagine
            const imgInputs = document.querySelectorAll('input[name^="risposte[output_img]"]');
            if ([...imgInputs].some(input => input.value.trim() === '')) {
                if (!incomplete.includes('Output Immagine')) incomplete.push('Output Immagine');
            }

            // 4) Drag & Drop
            if ([...dropZones].some(zone => {
                const hidden = zone.nextElementSibling;
                return hidden && hidden.value.trim() === '';
            })) {
                if (!incomplete.includes('Drag & Drop')) incomplete.push('Drag & Drop');
            }

            // Se ci sono sezioni incomplete, blocca submit e mostra alert
            if (incomplete.length > 0) {
                e.preventDefault();
                alert('Non puoi inviare il quiz. Devi completare tutte le sezioni:\n' + incomplete.join('\n'));
            }
        });
    }

});
