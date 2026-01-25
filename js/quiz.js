const draggables = document.querySelectorAll('.drag-item');
const dropZones = document.querySelectorAll('.drop-zone');

draggables.forEach(draggable => {
    draggable.addEventListener('dragstart', e => {
        e.dataTransfer.setData('text/plain', e.target.id);
    });
});

dropZones.forEach(zone => {
    zone.addEventListener('dragover', e => e.preventDefault());
    zone.addEventListener('dragenter', e => e.preventDefault());
    zone.addEventListener('drop', e => {
        const id = e.dataTransfer.getData('text');
        const draggedEl = document.getElementById(id);
        if(draggedEl.textContent === zone.dataset.answer) {
            zone.textContent = draggedEl.textContent;
            draggedEl.style.display = 'none';
            zone.style.borderColor = '#0a0';
        } else {
            alert("Non corretto, riprova!");
        }
    });
});
