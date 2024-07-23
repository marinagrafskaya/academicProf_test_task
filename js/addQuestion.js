function addQuestion() {
    // Клонируем существующий блок вопросов
    const questionBlock = document.querySelector(".body-answer-test").cloneNode(true);

    // Очищаем значения полей в новом блоке
    questionBlock.querySelectorAll("input, textarea").forEach(el => el.value = "");

    // Добавляем новый блок в форму
    document.querySelector(".answer-test").appendChild(questionBlock);
}