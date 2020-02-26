<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>
  <link rel="shortcut icon" href="https://statik.tempo.co/favicon/tempo-white.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <style>
    .bg {
      height: 1000px;
      background: rgb(250,250,250);
      background: linear-gradient(121deg, rgba(250,250,250,1) 33%, rgba(225,24,24,1) 100%);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-position-y: 0px;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      /* text-align: center; */
      padding: 0 20px;
    }
    .overlay{
      position: absolute;
      z-index: 10;
      width: 100%;
      height: 100vh;
      background:rgba(247, 155, 218, 0.5);
    }
    .content{
      z-index: 11;
      transition: all 0.5s linear;
      display: block;
    }

    .btn{
      -webkit-box-shadow: 2px 2px 7px 0px rgba(0,0,0,0.48);
      -moz-box-shadow: 2px 2px 7px 0px rgba(0,0,0,0.48);
      box-shadow: 2px 2px 7px 0px rgba(0,0,0,0.48);
      background-color: #fafafa;
    }

    .transparent-input{
      padding: 0;
      background-color:rgba(0,0,0,0) !important;
      border:none !important;
    }

    .numbering{
      margin-left: -28px;
    }

    .hidden {
      display: none;
    }

    .animation-hidden {
      opacity: 0;
    }

    .gender-selected, .topic-selected {
      border: 1px solid #000 !important;
    }

    .row.no-gutters {
      height: 360px;
      overflow-y: scroll;
      margin-right: 0;
      margin-left: 0;

      & > [class^="col-"],
      & > [class*=" col-"] {
        padding-right: 0;
        padding-left: 0;
      }
    }

  </style>
</head>
<body onkeypress="enter(event)">

<div class="bg container-fluid">
  <div class="content text-center" id="content-1">
    <img src="/logo-tempo-co.png" alt="logo" class="img-fluid mx-auto d-block mb-5">
    <h6 class="mb-4 text-muted">
      Selamat Datang di Line Official <br> 
      Account Tempo
    </h6>
    <p class="text-muted mb-4">
      Kami ingin memberikan pengalaman <br>
      membaca berita yang terbaik untuk Kamu, <br>
      jadi kami minta tolong untuk menjawab <br>
      beberapa pertanyaan ya
    </p>
    <button class="btn mb-3 btn-next"  id="btn-welcome">Mulai</button> 
    <br>
    <figure class="figure font-weight-bold">press ENTER</figure>
  </div>

  <div class="content text-left animation-hidden hidden" id="content-2">
    <h5 class="font-weight-bold mbt-4">
    <span class="numbering text-muted">1*</span>  Silahkan masukkan tahun <br> kelahiran kamu*
    </h5>
    <div class="form-group">
      <input type="text" class="form-control mbt-3 transparent-input" id="year" maxlength="4" placeholder="Tahun Lahir" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1'),setYear()" autofocus>
      <small id="error-year"style.display = "block";
      <small id="error-year" .html = messageValidation;class="form-text text-danger"></small>
    </div>
    <button class="btn mb-3 btn-next"  id="btn-welcome">OK  <i class="fas fa-check text-muted"></i></button><br>
    <figure class="figure font-weight-bold">press ENTER</figure>
  </div>

  <div class="content text-left animation-hidden hidden" id="content-3">
    <h5 class="font-weight-bold mt-4">
    <span class="numbering text-muted">2*</span> Selanjutnya silahkan masukkan <br> gender kamu*
    </h5>
    <div class="row">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-fill bd-highlight card-gender" onclick="setGender(1)">
          <div class="card card-gender-child" style="width: 9rem;">
            <i class="fas fa-venus fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">A. Laki - laki</p>
            </div>
          </div>
        </div>
        <div class="p-2 flex-fill bd-highlight card-gender" onclick="setGender(2)">
          <div class="card card-gender-child" style="width: 9rem;">
            <i class="fas fa-mars fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">B. Prempuan</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <small id="error-gender" class="form-text text-danger mb-2"></small>
    <button class="btn mb-3 btn-next"  id="btn-gender">OK  <i class="fas fa-check text-muted"></i></button><br>
    <figure class="figure font-weight-bold">press ENTER</figure>
  </div>

  <div class="content text-left animation-hidden hidden" id="content-4">
    <h5 class="ml-4 font-weight-bold mt-5">
     <span class="numbering text-muted">3*</span> Selanjutnya, untuk <br> memberikan pengalaman <br> maksimal, silahkan pilih <br> topik yang kamu minati*
    </h5>
    <figcapton class="ml-4 mb-4">Minimal 5</figcapton> <br><br>
    <figcapton class="ml-4 mb-2" id="topic-selected-info"></figcapton> 
    <div class="p-4 mt-1 row no-gutters">
      <!-- <div class="d-flex bd-highlight"> -->
      <div class="col-xs-6 col-sm-4">
        <div class="p-1 bd-highlight card-topic" onclick="setTopic(1)">
          <div class="card card-topic-child">
            <i class="fas fa-venus fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">A. Kesehatan</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-4">
        <div class="p-1 bd-highlight card-topic" onclick="setTopic(2)">
          <div class="card card-topic-child">
            <i class="fas fa-mars fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">B. Otomotif</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-4">
        <div class="p-1 bd-highlight card-topic" onclick="setTopic(3)">
          <div class="card card-topic-child">
            <i class="fas fa-mars fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">B. Otomotif</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-4">
        <div class="p-1 bd-highlight card-topic" onclick="setTopic(4)">
          <div class="card card-topic-child">
            <i class="fas fa-mars fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">B. Otomotif</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-4">
        <div class="p-1 bd-highlight card-topic" onclick="setTopic(5)">
          <div class="card card-topic-child">
            <i class="fas fa-mars fa-4x text-center mt-4"></i>
            <div class="card-body">
              <p class="card-text">B. Otomotif</p>
            </div>
          </div>
        </div>
      </div>
      <!-- </div> -->
    </div>
    <small id="error-topic" class="ml-4 form-text text-danger mb-2"></small>
    <button class="ml-4 btn mb-3 btn-next"  id="btn-topic">OK  <i class="fas fa-check text-muted"></i></button><br>
    <figure class="ml-4 figure font-weight-bold">press ENTER</figure>
  </div>

  <div class="content text-left animation-hidden hidden" id="content-5">
    <h5 class="font-weight-bold mbt-5">
      <span class="numbering text-muted">4*</span>Terakhir, masukkan alamat email <br> Kamu!
    </h5>
    <p>
      Kami akan mengirimkan link verifikasi <br> yang akan kadaluarsa dalam waktu 1 <br> jam ke alamat email Kamu.
    </p>
    <div class="form-group">
      <input type="email" class="form-control mbt-3 transparent-input" id="email" placeholder="Email" oninput="setEmail()" autofocus>
      <small id="error-email" class="form-text text-danger mb-2"></small>
    </div>
    <button class="btn mb-3 btn-next"  id="btn-email">OK  <i class="fas fa-check text-muted"></i></button><br>
    <figure class="figure font-weight-bold">press ENTER</figure>
  </div>

  <div class="content animation-hidden hidden" id="content-6">
    <p>
      Registrasi kamu hampir selesai.
    </p>
    <p>
      Kami telah mengirimkan email verifikasi <br>
      ke alamat email yang telah kamu isi.
    </p>
    <p>
      Lakukan verifikasi dengan cek email <br>
      kamu sebelum waktu habis!
    </p>
    <button class="btn mt-4"  id="btn-welcome">Tutup</i></button><br>
  </div>

  <!-- <nav class="navbar fixed-bottom navbar-light bg-light">
    <a class="navbar-brand" href="#">Fixed bottom</a>
  </nav> -->
  <div class="overlay"></div>
</div>

<script>
  let data = {
    year: null,
    gender: null,
    topic: [],
    email: null
  }
  let messageValidation = null;

  let click = 0;
  const next = document.querySelectorAll('.btn-next');
  next.forEach(function(el){
    el.addEventListener('click', function(e){
      if(click == 0) {
        click += 1;
        let contentPrev = document.getElementById('content-' + click);
        let contentNext = document.getElementById('content-' + (click + 1));
        animation(contentPrev, contentNext);
      }else {
        if(validationForm()) {
          click += 1;
          let contentPrev = document.getElementById('content-' + click);
          let contentNext = document.getElementById('content-' + (click + 1));
          animation(contentPrev, contentNext);
        }
      }
    });

  });
  
  function enter(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
      // console.log(click);
      if(click == 0) {
        click += 1;
        let contentPrev = document.getElementById('content-' + click);
        let contentNext = document.getElementById('content-' + (click + 1));
        animation(contentPrev, contentNext);
      }else {
        if(validationForm()) {
          click += 1;
          let contentPrev = document.getElementById('content-' + click);
          let contentNext = document.getElementById('content-' + (click + 1));
          animation(contentPrev, contentNext);
        }
      }
    }
  }

  function animation(contentPrev, contentNext) {
    contentPrev.classList.add('animation-hidden');
    contentPrev.addEventListener('transitionend', function(e) {
        contentPrev.classList.add('hidden');
        contentNext.classList.remove('hidden');
        setTimeout(function () {
          contentNext.classList.remove('animation-hidden');
        }, 20);
      }, {
        capture: false,
        once: true,
        passive: false
    });
  }

  function setYear() {
    data.year = document.getElementById('year').value;
  }

  const cardGender = document.querySelectorAll('.card-gender');
  const cardGenderChild = document.querySelectorAll('.card-gender-child');
  cardGender.forEach(function (el) {
    el.addEventListener('click', function(e){
      cardGenderChild.forEach(function (el2, i) {
        if(el2.classList.contains("gender-selected")) {
          el2.classList.remove("gender-selected");
        }
      });
      e.target.parentElement.classList.add('gender-selected');
    })
  })

  function setGender(type) {
    data.gender = type;
  }

  const cardTopic = document.querySelectorAll('.card-topic');
  const cardTopicChild = document.querySelectorAll('.card-topic-child');
  cardTopic.forEach(function (el) {
    el.addEventListener('click', function(e){
      if(e.target.parentElement.classList.contains("topic-selected")) {
        e.target.parentElement.classList.remove("topic-selected");
      }else {
        e.target.parentElement.classList.add('topic-selected');
      }
    })
  })

  function setTopic(id) {
    let minimalTopic = 5;
    if(data.topic.includes(id)) {
      let index = data.topic.indexOf(id);
      if (index > -1) {
        data.topic.splice(index, 1);
      }
    }else {
      data.topic.push(id);
    }
    if(data.topic.length > (minimalTopic - 1)) {
      document.getElementById("topic-selected-info").innerHTML = (data.topic.length) + " dipilih";
    }else {
      document.getElementById("error-topic").innerHTML = null;
      document.getElementById("topic-selected-info").innerHTML = "Pilih " + (minimalTopic - data.topic.length) + " lagi";
    }
  }

  function setEmail() {
    data.email = document.getElementById('email').value;
  }

  function saveData() {
    console.log(data);
  }

  function validationForm() {
    if (click == 1) {
      if(data.year == null || data.year == "") {
        messageValidation = null;
        messageValidation = 'Tahun lahir tidak boleh kosong';
        document.getElementById("error-year").innerHTML = messageValidation;
        document.getElementById("error-year").style.color = 'red';
        return false;
      }else {
        document.getElementById("error-year").innerHTML =  null;
        return true;
      }
    }
  
    if( click == 2) {
      if(data.gender == null || data.gender == "") {
        messageValidation = null;
        messageValidation = 'Jenis kelamin tidak boleh kosong';
        document.getElementById("error-gender").innerHTML = messageValidation;
        document.getElementById("error-gender").style.color = 'red';
        return false;
      }else {
        // console.log(click);
        document.getElementById("error-gender").innerHTML = null;
        return true;
      }
    }

    if( click == 3) {
      if(data.topic == null || data.topic == "") {
        messageValidation = null;
        messageValidation = 'Topic tidak boleh kosong';
        document.getElementById("error-topic").innerHTML = messageValidation;
        document.getElementById("error-topic").style.color = 'red';
        return false;
      }else {
        // console.log(click);
        if(data.topic.length != 5) {
          messageValidation = "Topic masih kurang  " + (5 - data.topic.length) + " lagi";
          document.getElementById("error-topic").innerHTML = messageValidation;
          document.getElementById("error-topic").style.color = 'red';
          return false;
        }else {
          document.getElementById("error-topic").innerHTML = null;
          return true;
        }
      }
    }

    if( click == 4) {
      if(data.email == null || data.email == "") {
        messageValidation = null;
        messageValidation = 'Email tidak boleh kosong';
        document.getElementById("error-email").innerHTML = messageValidation;
        document.getElementById("error-email").style.color = 'red';
        return false;
      }else {
        var isEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(isEmail.test(String(data.email).toLowerCase())) {
          document.getElementById("error-email").innerHTML = null;
          return true;
        }else {
          messageValidation = 'Format email salah';
          document.getElementById("error-email").innerHTML = messageValidation;
          document.getElementById("error-email").style.color = 'red';
          return false;
        }
        // console.log(click);
      }
    }

  }
</script>
</body>
</html>