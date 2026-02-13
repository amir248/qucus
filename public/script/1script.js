// добавляем имя из LocalStorage
  const savedUser = localStorage.getItem("username");
 
if(!savedUser){
  const authorizationForm=document.createElement("form");
  // authorizationForm.setAttribute('id','permission');
  authorizationForm.classList.add("permission");
  document.querySelector("#comments").append(authorizationForm);
  const authorization=document.createElement("section");
  authorization.classList.add('login');
  document.querySelector('.permission').append(authorization);
  const input=document.createElement('input');
  input.setAttribute("name","name");
  input.setAttribute("type","text");
  input.setAttribute("id","login");
  input.setAttribute("placeholder","Login");
  document.querySelector('.login').append(input);
  const pass=document.createElement("input");
  pass.setAttribute('id','password');
  pass.setAttribute('type','password');
  pass.setAttribute("placeholder","password");
  document.querySelector(".login").append(pass);
  const push=document.createElement("button");
  push.setAttribute("id","push");
  push.textContent="Авторизироваться";
  document.querySelector(".login").append(push);
}else{
  console.log('non');
  // Если есть, выводим логин вверху
  const userDisplay = document.createElement("div");
  userDisplay.textContent = `Привет, ${savedUser}!`;
  userDisplay.style.fontWeight = "bold";
  userDisplay.style.marginBottom = "10px";
  document.querySelector("#comments").prepend(userDisplay);
}
const form=document.createElement('form');
form.classList.add('formWebWorkshop');
document.getElementById('comments').prepend(form);

const inputSecond=document.createElement('input');
inputSecond.setAttribute("name","message");
inputSecond.setAttribute("type","text");
inputSecond.setAttribute("id","messages");
inputSecond.setAttribute("placeholder","messages");
document.querySelector('#comments > form').append(inputSecond);
const button=document.createElement('button');
button.textContent='send';
document.querySelector('#comments > form').append(button);

const commentsList=document.createElement("div");
commentsList.setAttribute("id","comments-list");
document.querySelector("#comments").after(commentsList);
const forma = document.querySelector(".formWebWorkshop");

forma.addEventListener("submit", async (e) => {
  e.preventDefault(); // чтобы форма не перезагружала страницу
  // собираем данные
  const formData = new FormData(form);
  const data = {};
  data.name="guest";
  // 👉 добавляем логин вручную
  const login = localStorage.getItem("username"); // или другой источник
  if (login) {
    data.name = login;
  }
  formData.forEach((value, key) => {
    data[key] = value;
    console.log(data);
  });
  
  
  try {
    const response = await fetch("https://comments.qucu.ru/200", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    });
    if (response.ok) {
      console.log("Комментарий отправлен!");
      sendButton.disabled=true;
      form.reset();
    } else {
      console.log("Ошибка при отправке комментария");
    }
  } catch (err) {
    console.error(err);
    console.log("Сетевая ошибка");
  }
});

async function loadComments() {
  try {
    const response = await fetch("https://comments.qucu.ru/200");
    if (!response.ok) throw new Error("Ошибка загрузки комментариев");
    const comments = await response.json();
    // контейнер для вывода
    const list = document.getElementById("comments-list");
    list.innerHTML = ""; // очищаем перед выводом
    comments.forEach(c => {
      const item = document.createElement("div");
      item.classList.add("comment");
      item.innerHTML = `<b>${c.name}</b>: ${c.message}`;
      list.appendChild(item);
    });
  } catch (err) {
    console.error(err);
  }
}
setInterval(loadComments,7777);
// loadComments();

const sendButton=document.querySelector(".formWebWorkshop > button");
let inputMessage=document.querySelector("#messages");
sendButton.disabled=true;
function keyDown(){
  inputMessage.addEventListener('keydown',()=>{
    keyTestSubject();
  });
}//keyDown
keyDown();
function keyTestSubject(){
  if(inputMessage.value.length>1){
    sendButton.disabled=false;
  }else{
    sendButton.disabled=true;
  }
}



async function doLogin() {
  const login =document.getElementById("login").value;
  const password = document.getElementById("password").value;

  try {
    const res = await fetch("https://comments.qucu.ru/login3-proxy", {
    // const res = await fetch("https://new.qucu.ru/login3", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",   // чтобы куки передавались
      body: JSON.stringify({ login, password })
    });
// res.cookie("session", token, {
//   httpOnly: true,
//   secure: true,         // обязательно, если HTTPS
//   sameSite: "None"      // иначе Chrome вырежет
// });

    const data = await res.json();
    console.log("Ответ сервера:", data);

    if (res.ok) {
      alert("Успешный вход!");
      localStorage.setItem("username", login);
      console.log(login);
      checkProfile(); // сразу проверить профиль
      if(login){
        // Убираем форму авторизации
      document.querySelector(".permission").remove();
      }
    } else {
      alert(data.message || "Ошибка входа");
    }
  } catch (err) {
    console.error("Ошибка сети:", err);
  }
}

async function checkProfile() {
  const res = await fetch("https://new.qucu.ru/profile3", {
    method: "GET",
    credentials: "include"  // <- тоже важно
  });
  const data = await res.json();
  console.log("Профиль:", data);
}
document.getElementById("push").addEventListener("click", (e) => {
  e.preventDefault();
  doLogin();
});
