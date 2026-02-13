// In src/index.js
const express = require('express');

const app = express();
const PORT = process.env.PORT || 3700;
const mysql = require('mysql2');

app.set('views','public');
app.set("view engine", "ejs");
app.use(express.static('public'));
app.use(express.static('public_old'));
app.use(express.static('who-is-faster-PHP-or-JS'));


const fs =require('fs');
const path=require('path');
const jsonParser = express.json();
const cors = require('cors');

const dbConfig = require('./get/moduls');
const connection = mysql.createConnection({
  host: process.env.DB_HOST || dbConfig.host,
  user: process.env.DB_USER || dbConfig.user,
  password: process.env.DB_PASSWORD || dbConfig.password,
  database: process.env.DB_DATABASE || dbConfig.database
});

// app.post('/allow-cors',jsonParser,cors(),(request,response)=>{
//   console.log('oK');
//   console.log('oKs');
//   if (!request.body) return response.sendStatus(400);
//   let scriptComments=fs.readFileSync('/public/script/script.js',"utf8",
//   (error,data)=>{
//     console.log("Async read file script.js");
//     if(error) throw error;
//     console.log(data);
//   });
//   response.send(scriptComments);
// });// SCRIPT JS

app.use(cors({
  origin: ['https://qucu.ru','https://comments.qucu.ru'],
  credentials: true
}));
app.use((req, res, next) => {
  res.on('finish', () => {
    console.log('CORS header:', res.get('Access-Control-Allow-Origin'));
  });
  next();
});
app.get('/blozhik/',  function (request,response) {
  response.render('temporaryPage',{
      title: 'Бложик, веб мастерской имени барона сайтоверстаузена.',
      description: 'настоящий божик, несущий в своих недрах благое дело',

      url: 'blozhik'

    })
    response.send('oK');
  });

connection.connect(err=>{
  if(err){
    return err;
    console.log('err');
  }else{
    console.log('database--- oK');
  }
});
const sql = `SELECT * FROM article`;

connection.query(sql, function(err, results) {
  // console.log(results[0]['title']);
  if(err) console.log(err);
  //     console.log(results[1]['title']);
  for(let oj=0;oj<results.length;oj++){
    // console.log("/blozhik/"+`${results[oj]['url']}`);
    // console.log("/blozhik/"+`${results[oj]['description']}`);
    app.use("/blozhik/"+`${results[oj]['url']}`, function(request, response){
      response.render('blozhik', {
        title: `${results[oj]['title']}`,
        description: `${results[oj]['description']}`,
        article: `${results[oj]['text']}`,
        autor: `${results[oj]['autor']}`,
        url: `${results[oj]['url']}`,
        json: `${results[oj]['JSON']}`,
        id: `${results[oj]['id']}`,
        js: `${results[oj]['js']}`
      });
    });
  }//for
   app.use(function(request,response,next){
    response.status(404).send('<div style="object-fit:contain;display:flex;flex-direction:column;justify-content:center;align-items:center;width:100%;min-height:calc(100vh - 20px);background: url(/public/images/nlo.png);margin:0;border:0;background-size:cover;background-position: center;">sorry cant find that! Return to home or main page <span style="font-size:7vh;">404</span> <a href="/blozhik">^_^ Click here to BLOZHIK</a><hr><a href="/">O_o Click here to HomePage</a></div>');
  });
});//connection

app.use("/comments",(request,response)=>{
  response.render("indexPage",{
    title:"Comments",
    text: "Самописная система комментариев. Эта система комментариев без записи в базу данных. Сообщения записываются массивом в документ json форматa. После чего отправляются с сервера обратно в документ. С использованием одного только javascript. Как говорится в пословице: \"все гениальное просто\". Рабочую систему комментариев можно скачать по ссылки с моего гитхаба https://github.com/amir248/comments Вот вам пожалуйста рабочая система комментариев в открытом доступе, это не то что условно бесплатная система комментариев как \"дискус\". Сначало она бесплатная, а потом загромаждает все поля видимости жесточайшими ракламными блоками. Пример работы системы комментариев: https://amir248.github.io/localhost/ ^_^",
    warnings: "На сервере файлы кэшируются, поэтому иногда чтобы увидеть отправленное сообщение надо обновить страницу.",
    description: "Самописная система комментариев, для сайта."
  });
});


app.get("/registration",(request,response)=>{
  response.render("registration.ejs",{
   title: "Registration",
   text: "oK all right!",
   description: "Registration on the site web workshop named after baron saytoverstausen"
  });
});
app.get("/registration2",(request,response)=>{
  response.render("registration2.ejs");
});
// For testing purposes
app.get('/ok', (req, res) => {
    res.send("<h2>It's Working! Again!</h2>");
});
app.get("/",(request,response)=>{
  response.render("main.ejs",{
  });
});
app.get('/who-is-faster-php-or-js',(request,response)=>{
  response.render("who-is-faster-php-or-js.ejs",{
    header:`<h1>who is faster PHP or JS</h1>
<a href="/who-is-faster-php-or-js_php">
    <strong>PHP</strong>
</a>
<a href="/who-is-faster-php-or-js_js">
    <strong>JS</strong>
</a>
<a href="/who-is-faster-php-or-js">
    <strong>or main page With NODE.JS</strong>
</a>
<strong> main page <a href="https://qucu.ru/who-is-faster-php-or-js">web workshop</a></strong>
<strong>It's HEADER</strong> <a href="https://github.com/amir248/who-is-faster-PHP-or-JS">GITHUB</a>`,
    article: `<h2>Article</h2><strong>Who is faster php or js <a href="https://qucu.ru/blozhik/who-is-fast-php-or-js">here text</a></strong><p>для JS взята аякс функция с сайта <a href="https://www.w3schools.com/howto/howto_html_include.asp">W3</a>. PHP подгружает через include("../loadingPlace/index.html"); Обсолютно одинаковое содержимое, отображается через JS и PHP.</p><picture>    <img src="who-is-faster-PHP-or-JS/public/DSC_8541.JPG" alt="Amir"></picture>
<h3>PHP</h3>
<picture>
    <img src="who-is-faster-PHP-or-JS/public/php.png" alt="php">
</picture>
<h3>JS</h3>
<picture>
    <img src="who-is-faster-PHP-or-JS/public/js.png" alt="js">
</picture>
<h3>node.js</h3>
<picture>
    <img src="who-is-faster-PHP-or-JS/public/node.png" alt="node.js">
</picture><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio at, hic vero quae velit ducimus. Reiciendis id ipsam fugit necessitatibus aut amet officia veritatis incidunt. Nobis perferendis modi veritatis a.</p>`,
    footer: `<strong>FOOTER</strong>
<div>
    <ul>
        <li>one</li>
        <li>two</li>
        <li>the</li>
    </ul>
    <ul>
        <li><a href="#">up down</a></li>
        <li>oK</li>
       
    </ul>
    <ul>
        <li><a href="https://qucu.ru/who-is-faster-php-or-js">web workshop</a></li>
        <li>2</li>
        <li>3</li>
    </ul>
</div>
<div>
    <strong>© все права защищены!</strong>
</div>`,
title: 'NODE.JS',
description: 'На каких языках программирования "web" технологиях сайт будет работать быстрее: php, node.js, html(css,js,html)',
json:'',
js: ''
  });
});

app.listen(PORT, () => {
    console.log(`API is listening on port ${PORT}`);
});
