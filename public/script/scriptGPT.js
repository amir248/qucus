// после создания формы и элементов
const registerForm = document.forms['registerForm'] || document.querySelector('form[name="registerForm"]');

document.querySelector('#start').disabled = true;

// разблокировать кнопку при вводе
document.querySelector('#nameCommentsSystem').addEventListener('input', keyTestSubject);
document.querySelector('#message').addEventListener('input', keyTestSubject);

function keyTestSubject() {
  const nameLen = document.querySelector('#nameCommentsSystem').value.length;
  const msgLen = document.querySelector('#message').value.length;

  document.querySelector('#start').disabled = !(nameLen > 2 && msgLen > 7);

  document.querySelector('#nameCommentsSystem').style.background = nameLen > 2 ? 'rgba(0,255,0,0.1)' : 'rgba(255,0,0,0.1)';
  document.querySelector('#message').style.background = msgLen > 7 ? 'rgba(0,255,0,0.1)' : 'rgba(255,0,0,0.1)';
}

document.querySelector('#start').addEventListener('click', () => {
  if (!registerForm) {
    console.error('Form not found!');
    return;
  }

  const userNameF = registerForm.elements['login'].value;
  const messageF = registerForm.elements['message'].value;

  const user = {
    userName: userNameF,
    message: messageF,
    date: new Date(),
    idea: importantBag
  };

  const puto3 = 'https://qucu.ru/' + `${importantBag.id}` + '.json';

  fetch(puto3, {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(user),
    mode: 'cors',
    credentials: 'include'
  })
  .then(response => response.text())
  .then(result => {
    console.log(result);
    document.querySelector('#message').value = '';
    // Можно разблокировать кнопку, чтобы можно было отправлять снова:
    keyTestSubject();
  })
  .catch(error => {
    console.error('Error:', error);
    document.querySelector('#start').disabled = false; // разблокировать при ошибке
  });

  document.querySelector('#start').disabled = true; // заблокировать кнопку сразу после клика, чтобы предотвратить двойные отправки
});
