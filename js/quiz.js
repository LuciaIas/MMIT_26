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

            if(!draggedEl) return;

            const answer = zone.dataset.answer;

            if(draggedEl.textContent.trim() === answer.trim()) {
                zone.textContent = draggedEl.textContent;
                zone.classList.add('correct');

                // Aggiorna input nascosto
                const hiddenInput = zone.nextElementSibling;
                if(hiddenInput && hiddenInput.tagName === 'INPUT') {
                    hiddenInput.value = draggedEl.textContent;
                }

                draggedEl.style.display = 'none';
            } else {
                zone.classList.add('incorrect');
                setTimeout(() => zone.classList.remove('incorrect'), 800);
            }
        });
    });
});
