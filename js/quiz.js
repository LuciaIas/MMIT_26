document.addEventListener('DOMContentLoaded', () => {

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
            e.preventDefault();
            zone.classList.add('over');
        });

        zone.addEventListener('dragleave', e => {
            zone.classList.remove('over');
        });

        zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('over');

    // se il quiz è già inviato, non permettere modifiche
    if (zone.dataset.disabled === 'true') return;

    const id = e.dataTransfer.getData('text/plain');
    const draggedEl = document.getElementById(id);
    if (!draggedEl) return;

    // se la drop-zone contiene già un termine, rimettilo tra i termini
    const existing = zone.querySelector('.drag-item');
    if (existing) {
        document.querySelector('.drag-items').appendChild(existing);
    }

    // inserisci il nuovo termine
    zone.innerHTML = '';
    zone.appendChild(draggedEl);

    // aggiorna input hidden
    const hiddenInput = zone.nextElementSibling;
    if (hiddenInput && hiddenInput.tagName === 'INPUT') {
        hiddenInput.value = draggedEl.textContent.trim();
    }
});
const dragContainer = document.querySelector('.drag-items');

dragContainer.addEventListener('dragover', e => {
    e.preventDefault();
});

dragContainer.addEventListener('drop', e => {
    e.preventDefault();

    const id = e.dataTransfer.getData('text/plain');
    const draggedEl = document.getElementById(id);
    if (!draggedEl) return;

    dragContainer.appendChild(draggedEl);

    // svuota l’input hidden della zona da cui proviene
    document.querySelectorAll('.drop-zone').forEach(zone => {
        const hidden = zone.nextElementSibling;
        if (hidden && hidden.value.trim() === draggedEl.textContent.trim()) {
            hidden.value = '';
            zone.innerHTML = '';
        }
    });
});

    });

    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', e => {
            let incomplete = [];

            const vfNames = [...new Set([...document.querySelectorAll('input[name^="risposte[vf]"]')].map(i => i.name))];
            vfNames.forEach(name => {
                if (!document.querySelector(`input[name="${name}"]:checked`)) {
                    if (!incomplete.includes('Vero/Falso')) incomplete.push('Vero/Falso');
                }
            });

            const cfInputs = document.querySelectorAll('input[name^="risposte[cf]"]');
            if ([...cfInputs].some(input => input.value.trim() === '')) {
                if (!incomplete.includes('Completa Frase')) incomplete.push('Completa Frase');
            }

            const imgInputs = document.querySelectorAll('input[name^="risposte[output_img]"]');
            if ([...imgInputs].some(input => input.value.trim() === '')) {
                if (!incomplete.includes('Output Immagine')) incomplete.push('Output Immagine');
            }

            if ([...dropZones].some(zone => {
                const hidden = zone.nextElementSibling;
                return hidden && hidden.value.trim() === '';
            })) {
                if (!incomplete.includes('Drag & Drop')) incomplete.push('Drag & Drop');
            }

            if (incomplete.length > 0) {
                e.preventDefault();
                alert('Non puoi inviare il quiz. Devi completare tutte le sezioni:\n' + incomplete.join('\n'));
            }
        });
    }
});


