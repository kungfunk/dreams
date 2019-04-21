document.addEventListener('DOMContentLoaded', () => {
    const uploaders = document.querySelectorAll('.file-upload__input');

    function updateLabel(event) {
        const label = this.parentElement.querySelector('.file-upload__label');
        label.innerHTML = event.target.files[0].name;
    }

    uploaders.forEach(form => form.addEventListener('change', updateLabel));
});