async function send(email, link, id) {
  let form_data = new FormData();
  let message = document.querySelector(".message-modal");
  // Валидация email
  if (!validateEmail(email.value)) {
    message.style.display = "block";
    message.innerHTML = "Некорректный адрес электронной почты";
    return; // Прекращаем выполнение функции, если email некорректный
  }

  form_data.append("email", email.value);
  form_data.append("link", link);
  form_data.append("id", id);
  let response = await fetch("../actions/send.php", {
    method: "POST",
    body: form_data,
  });
  let data = await response.json();
  message.style.display = "block";
  if (data) {
    message.innerHTML = "Тест успешно отправлен";
  } else {
    message.innerHTML = "Пользователь с указанным адресом электронной почты не найден. Пожалуйста, убедитесь, что введённый email правильный и попробуйте еще раз.";
  }
}

let confirmaction = document.getElementById("confirmaction");
let btn = document.querySelector(".btn-user");
let userinput = document.querySelector("input[name=email]");
let linkValue;
let idTest;

function modal(link, id) {
  confirmaction.classList.add("active");
  document.body.style.overflow = "hidden";
  linkValue = link;
  idTest = id;
}

btn.onclick = function () {
  send(userinput, linkValue, idTest);
};

function closeconfirmaction() {
  confirmaction.classList.remove("active");
  document.body.style.overflow = "visible";
}

// Функция валидации email
function validateEmail(email) {
  const re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
