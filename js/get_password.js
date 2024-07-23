let getpassword = document.querySelector(".get_password");

async function get_password() {
  let name = document.querySelector("input[name=name]").value;
  let email = document.querySelector("input[name=email]").value;
  let message = document.querySelector(".message");
  let form_data = new FormData();

  // Валидация имени
  if (!validateName(name)) {
    message.style.display = "block";
    message.innerHTML = "Некорректное имя";
    return; // Прекращаем выполнение функции, если имя некорректное
  }

  // Валидация email
  if (!validateEmail(email)) {
    message.style.display = "block";
    message.innerHTML = "Некорректный адрес электронной почты";
    return; // Прекращаем выполнение функции, если email некорректный
  }

  form_data.append("email", email);
  form_data.append("name", name);
  let response = await fetch("actions/registration.php", {
    method: "POST",
    body: form_data,
  });
  let data = await response.json();

  if (data) {
    getpassword.textContent = "Пароль отправлен";
    // Отключаем кнопку, чтобы избежать повторного нажатия
    getpassword.disabled = true;
  }
}

getpassword.addEventListener("click", function (e) {
  e.preventDefault();
  get_password();
});

// Функция валидации email
function validateEmail(email) {
  const re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

// Функция валидации имени
function validateName(name) {
  // Простая валидация: только буквы и пробелы
  const re = /^[А-Я][а-яё]*$/;
  return re.test(String(name).trim());
}
