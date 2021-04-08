let button = document.querySelectorAll('.responseButton');
button.forEach(element => {
    element.addEventListener('click', () => {
        let form = document.querySelector('#form' + element.dataset.id);

        if (form.classList.contains('d-none')) {
            form.classList.remove('d-none');
        }
    })
});
