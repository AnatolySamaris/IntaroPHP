function showMessage(text, bad=false) {
    const messageElement = document.getElementById('message');
    const color = bad ? 'red' : 'green';

    messageElement.style.display = 'block';
    messageElement.textContent = text;
    messageElement.style.color = color;
}

function hideMessage() {
    const messageElement = document.getElementById('message');
    messageElement.style.display = 'none';
}


document.addEventListener("DOMContentLoaded", function() {
    var phoneInput = document.getElementById('phone');
    Inputmask({ mask: '+7 (999) 999-99-99' }).mask(phoneInput);
});


document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('feedbackForm');
    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        hideMessage();
        let formData = new FormData(form);

        if (formValidate()) {
            $.ajax({
                url: '../../backend/submit_form.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                statusCode: {
                    201: function (response) {
                        time = response.data;
                        showMessage('Заявка создана! С вами свяжутся после ' + time);
                    },
                    409: function (jqXHR) {
                        minutes = jqXHR.responseJSON['data'];
                        showMessage('Заявка уже существует! Подождите ещё ' + minutes + ' минут.', true);
                    },
                    500: function (jqXHR) {
                        showMessage('Произошла ошибка при создании заявки! Попробуйте позже.', true);
                        console.error(jqXHR.responseJSON['message']);
                    },
                    502: function (jqXHR) {
                        showMessage('Произошла ошибка при оформлении заявки! Попробуйте позже', true);
                        console.error(jqXHR.responseJSON['message']);
                    }
                }
            });
        }

    function formValidate() {
        let valid = true;

        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        const comment = document.getElementById('comment');

        let elementsArray = [name, email, phone, comment];
        let nameArray = name.value.trim().replace(/\s+/g, ' ').split(' ');

        elementsArray.forEach(el => {
            el.classList.remove('is-invalid');
            if (el.value == '') {
                addError(el);
                valid = false;
            }
        });
        nameArray.forEach(el => {
            const reg = /^[a-zA-Zа-яА-ЯёЁ\s]+$/;
            if (!reg.test(el)){
                addError(name);
                valid = false;
            }
        });
        if (!emailTest(email.value)) {
            addError(email);
            valid = false;
        }
        if (!phoneTest(phone.value)) {
            addError(phone);
            valid = false;
        }
        return valid
    }

    function addError(element) {
        element.classList.add('is-invalid');
    }


    function emailTest(email) {
        var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/;
        return reg.test(email);
    }

    function phoneTest(phone) {
        var reg = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;
        return reg.test(phone)
    }
}});