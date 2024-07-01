function showMessage(text, bad=false) {
    const resultElement = document.getElementById('result');
    resultElement.style.display = 'block';
    if (bad) {
        resultElement.textContent = text;
        resultElement.style.color = 'red';
    } else {
        if (text.length > 0) {
            const headerElement = document.getElementById('header');
            headerElement.style.display = 'block';
            resultElement.textContent = text;
            resultElement.style.color = 'green';
        } else {
            resultElement.textContent = "Ничего не найдено... Попробуйте уточнить запрос!";
            resultElement.style.color = 'red';
        }
    }
}

function hideMessage() {
    const resultElement = document.getElementById('result');
    resultElement.style.display = 'none';
    const headerElement = document.getElementById('header');
    headerElement.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('inputForm');
    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        hideMessage();
        let formData = new FormData(form);
        if (formValidate()) {
            $.ajax({
                url: '../../backend/get_nearest_metro.php?address=' + encodeURIComponent($('#address').val()),
                type: 'GET',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                statusCode: {
                    200: function (response) {
                        showMessage(response.data);
                    },
                    400: function (jqXHR) {
                        showMessage("Ничего не найдено... Попробуйте уточнить запрос!", true);
                        console.error(jqXHR.responseJSON['data']);
                    },
                    500: function (jqXHR) {
                        showMessage('Технические шоколадки! Не получилось найти ни одной станции метро ;(', true);
                        console.error(jqXHR.responseJSON['data']);
                    }
                }
            });
        }

    function formValidate() {
        let valid = true;
        const address = document.getElementById('address');
        address.classList.remove('is-invalid');
        if (address.value == '') {
            element.classList.add('is-invalid');
            valid = false;
        }
        return valid;
    }
}});