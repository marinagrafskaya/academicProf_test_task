async function autreg() {
    let login = document.querySelector("input[name=email]").value;
    let password = document.querySelector("input[name=password]").value;
    let message = document.querySelector('.message');
    let form_data = new FormData();
    form_data.append('login', login);
    form_data.append('password', password);
    let response = await fetch('actions/signin.php', {
        method: 'POST',
        body: form_data
    });
    let data = await response.json();
    if (data.status === true) {
        if(data.role === 'admin') {
            location.href = 'admin/index.php';  
        } else {
           location.href = 'index.php';
        }
        message.style.display = 'none';
        message.innerHTML = '';
    } else {
        message.style.display = 'block';
        message.innerHTML = data.message;
    }
}


let loginbutton = document.querySelector('.login-button');
loginbutton.addEventListener('click', function (e) {
    e.preventDefault();
    autreg();
})
