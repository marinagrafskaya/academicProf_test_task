//Класс, который представляет сам тест
class Quiz {
  constructor(questions, results) {
    //Массив с вопросами
    this.questions = questions;

    //Массив с возможными результатами
    this.results = results;

    //Количество набранных очков
    this.score = 0;

    //Номер результата из массива
    this.result = 0;

    //Номер текущего вопроса
    this.current = 0;
  }

  Click(index) {
    //Добавляем очки
    let value = this.questions[this.current].Click(index);
    this.score += value;

    let correct = -1;

    //Если было добавлено хотя бы одно очко, то считаем, что ответ верный
    if (value >= 1) {
      correct = index;
    } else {
      //Иначе ищем, какой ответ может быть правильным
      for (let i = 0; i < this.questions[this.current].answers.length; i++) {
        if (this.questions[this.current].answers[i].value >= 1) {
          correct = i;
          break;
        }
      }
    }

    this.Next();

    return correct;
  }

  //Переход к следующему вопросу
  Next() {
    this.current++;

    if (this.current >= this.questions.length) {
      this.End();
    }
  }

  //Если вопросы кончились, этот метод проверит, какой результат получил пользователь
  End() {
    for (let i = 0; i < this.results.length; i++) {
      if (this.results[i].Check(this.score)) {
        this.result = i;
      }
    }
  }
}

//Класс, представляющий вопрос
class Question {
  constructor(text, answers) {
    this.text = text;
    this.answers = answers;
  }

  Click(index) {
    return this.answers[index].value;
  }
}

//Класс, представляющий ответ
class Answer {
  constructor(text, value) {
    this.text = text;
    this.value = value;
  }
}

//Класс, представляющий результат
class Result {
  constructor(text, value) {
    this.text = text;
    this.value = value;
  }

  //Этот метод проверяет, достаточно ли очков набрал пользователь
  Check(value) {
    if (this.value <= value) {
      return true;
    } else {
      return false;
    }
  }
}

let nameTesth1 = document.querySelector("h1");
let testData = document.querySelector(".inputTest").value;
let data = JSON.parse(testData);
nameTesth1.innerText = data.name_test;

let questionsTest = document.querySelector(".questionsTest").value;
let dataquestions = JSON.parse(questionsTest);


let answersTest = document.querySelector(".answersTest").value;
let dataanswers = JSON.parse(answersTest);


let time = data.time;

//Массив с результатами
const results = [
  new Result("Тест не пройден :(", 0),
  new Result("Тест пройден!", data.minimum_score),
];

//Массив с вопросами
const questions = [];

dataquestions.forEach(question => {
  // Создаем копию вопроса
  const newQuestion = new Question(question.text_questions, []); // Создаем пустой массив для ответов

  // Цикл по ответам
  dataanswers.forEach(answer => {
    // Проверяем, что ответ соответствует текущему вопросу
    if (answer.id_question === question.id_questions) {
      // Создаем новый ответ и добавляем его в массив ответов к текущему вопросу
      const newAnswer = new Answer(answer.text_answer, parseInt(answer.number_of_points, 10));
      newQuestion.answers.push(newAnswer);
    }
  });

  // Добавляем вопрос в массив questions
  questions.push(newQuestion);
}); 


//Сам тест
const quiz = new Quiz(questions, results);
Update();

let stoptimer = false;

//Обновление теста
function Update() {
  //Проверяем, есть ли ещё вопросы
  if (quiz.current < quiz.questions.length) {
    let head = document.getElementById("head");
    //Если есть, меняем вопрос в заголовке
    head.innerHTML = quiz.questions[quiz.current].text;

    //Удаляем старые варианты ответов
    let buttons = document.getElementById("buttons");
    buttons.innerHTML = "";

    //Создаём кнопки для новых вариантов ответов
    for (let i = 0; i < quiz.questions[quiz.current].answers.length; i++) {
      let btn = document.createElement("div");
      btn.className = "button";

      btn.innerHTML = quiz.questions[quiz.current].answers[i].text;

      btn.setAttribute("index", i);

      buttons.appendChild(btn);
    }

    //Выводим номер текущего вопроса
    let pages = document.getElementById("pages");
    pages.innerHTML = quiz.current + 1 + " / " + quiz.questions.length;

    //Вызываем функцию, которая прикрепит события к новым кнопкам
    Init();
  } else {
    //Если это конец, то выводим результат
    buttons.innerHTML = "";
    head.innerHTML = quiz.results[quiz.result].text;
    pages.innerHTML = "Баллы: " + quiz.score;
    stoptimer = true;
  }
}

function Init() {
  //Находим все кнопки
  let btns = document.getElementsByClassName("button");

  for (let i = 0; i < btns.length; i++) {
    //Прикрепляем событие для каждой отдельной кнопки
    //При нажатии на кнопку будет вызываться функция Click()
    btns[i].addEventListener("click", function (e) {
      Click(e.target.getAttribute("index"));
    });
  }
}

function Click(index) {
  //Получаем номер правильного ответа
  let correct = quiz.Click(index);

  //Находим все кнопки
  let btns = document.getElementsByClassName("button");

  if (index == 4) {
    //Делаем кнопки серыми
    for (let i = 0; i < btns.length; i++) {
      btns[i].className = "button button_passive";
    }
    //Ждём секунду и обновляем тест
    setTimeout(Update, 2000);
  } else {
    //Делаем кнопки серыми
    for (let i = 0; i < btns.length; i++) {
      btns[i].className = "button button_passive";
    }

    //Если это тест с правильными ответами, то мы подсвечиваем правильный ответ зелёным, а неправильный - красным

    if (correct >= 0) {
      btns[correct].className = "button button_correct";
    }

    if (index != correct) {
      btns[index].className = "button button_wrong";
    }

    //Ждём секунду и обновляем тест
    setTimeout(Update, 2000);
  }
}

let finish = document.querySelector(".finish");
finish.addEventListener("click", function () {
  if(quiz.score < data.minimum_score) {
    window.location.href = "../index.php";
  } else {
    test(quiz.score);
  }
});

function countdown(duration, onFinish, stopCondition) {
  let timer = duration;
  let minutes, seconds;

  let timer_display = document.querySelector(".timer");

  let interval = setInterval(() => {
    minutes = Math.floor(timer / 60);
    seconds = Math.floor(timer % 60);

    timer_display.textContent = `${minutes
      .toString()
      .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;

    if (--timer < 0) {
      clearInterval(interval);
      onFinish(); // Вызываем функцию завершения
    } else if (stopCondition()) {
      // Проверяем условие остановки
      clearInterval(interval);
    }
  }, 1000); // Обновляем каждую секунду
}


countdown(
  time,
  () => {
    alert("Время вышло!!!");
    window.location.href = "../index.php";
  },
  () => {
    // Условие остановки
    return stoptimer == true; // Останавливаем таймер, если кнопок на странице нет
  }
);

let IdUser = document.querySelector('.IdUser').value;
let id_test = data.id_test;

async function test(score) {
  let form_data = new FormData();
  form_data.append("score", score);
  form_data.append("id_user", IdUser);
  form_data.append("id_test", id_test);
  let response = await fetch("../actions/user-results.php", {
    method: "POST",
    body: form_data,
  });
  let data = await response.json();
  if (data) {
    window.location.href = "../index.php";
  }
}
