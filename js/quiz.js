document.addEventListener('DOMContentLoaded', () => {

    const draggables = document.querySelectorAll('.drag-item');
    const dropZones = document.querySelectorAll('.drop-zone');
    const dragContainer = document.querySelector('.drag-items');

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

        zone.addEventListener('dragleave', () => zone.classList.remove('over'));

        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('over');
            if (zone.dataset.disabled === 'true') return;

            const id = e.dataTransfer.getData('text/plain');
            const draggedEl = document.getElementById(id);
            if (!draggedEl) return;

            const existing = zone.querySelector('.drag-item');
            if (existing) dragContainer.appendChild(existing);

            zone.innerHTML = '';
            zone.appendChild(draggedEl);

            const hiddenInput = zone.nextElementSibling;
            if (hiddenInput && hiddenInput.tagName === 'INPUT') {
                hiddenInput.value = draggedEl.textContent.trim();
            }
        });
    });

    dragContainer.addEventListener('dragover', e => e.preventDefault());

    dragContainer.addEventListener('drop', e => {
        e.preventDefault();
        const id = e.dataTransfer.getData('text/plain');
        const draggedEl = document.getElementById(id);
        if (!draggedEl) return;
        dragContainer.appendChild(draggedEl);

        dropZones.forEach(zone => {
            const hidden = zone.nextElementSibling;
            if (hidden && hidden.value.trim() === draggedEl.textContent.trim()) {
                hidden.value = '';
                zone.innerHTML = '';
            }
        });
    });

    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', e => {
            let incomplete = [];

            const vfNames = [...new Set([...document.querySelectorAll('input[name^="risposte[vf]"]')].map(i => i.name))];
            if (vfNames.some(name => !document.querySelector(`input[name="${name}"]:checked`))) incomplete.push('Vero/Falso');

            if ([...document.querySelectorAll('input[name^="risposte[cf]"]')].some(i => i.value.trim() === '')) incomplete.push('Completa Frase');

            if ([...document.querySelectorAll('input[name^="risposte[output_img]"]')].some(i => i.value.trim() === '')) incomplete.push('Output Immagine');
            
            if ([...dropZones].some(zone => {
                const hidden = zone.nextElementSibling;
                return hidden && hidden.value.trim() === '';
            })) incomplete.push('Drag & Drop');

            if (incomplete.length > 0) {
                e.preventDefault();
                alert('Non puoi inviare il quiz. Devi completare tutte le sezioni:\n' + incomplete.join('\n'));
            }
        });
    }
});
