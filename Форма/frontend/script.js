"use strict"

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('feedbackForm');
    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let error = formValidate(form);

        let formData = new FormData(form);

        if (error === 0) {
            let response = await fetch('../backend/submit_form.php', {
                method: 'POST',
                body: formData
            });
            if (response.ok) {
                let result = await response.json();
                form.reset();
            } else {
                alert("ERROR");
            }
        }
    }

    function formValidate(form) {
        let error = 0;
        let formReq = document.querySelectorAll('._req');

        for (let index = 0; index < formReq.length; index++) {
            const input = formReq[index];
            formRemoveError(input);

            if (input.classList.contains('_email')) {
                if (!emailTest(input)) {
                    formAddError(input);
                    error++;
                }
            } else if (input.id == 'surname') {
                if (!/[a-zA-Zа-яА-ЯёЁ]/i.test(input.value)){
                    formAddError(input);
                    error++;
                }
            } else if (input.id == 'surname') {
                if (!/[a-zA-Zа-яА-ЯёЁ]/i.test(input.value)) {
                    formAddError(input);
                    error++;
                }
            } else if (input.id == 'patronymic' && input.value != '') {
                if (!/[a-zA-Zа-яА-ЯёЁ]/i.test(input.value)) {
                    formAddError(input);
                    error++;
                }
            } else {
                if (input.value == '') {
                    formAddError(input);
                    error++;
                }
            }
        }

        return error;
    }

    function formAddError(input) {
        input.parentElement.classList.add('is-invalid');
        input.classList.add('is-invalid');
    }

    function formRemoveError(input) {
        input.parentElement.classList.remove('is-invalid');
        input.classList.remove('is-invalid');
    }

    function emailTest(input) {
        return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
    }
});