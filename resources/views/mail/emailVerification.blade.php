<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Email Verification</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <style>

  </style>
</head>
<body>

<div style="continer">
 <div class="jumbotron text-left">
   <div class="row">
     <div class="col-md-6 content">
       <img src="/logo-tempo-co.png" alt="logo" class="img-fluid mx-auto d-block">
        <br>
        <br>
        <h6>Hai {{ $name }}.</h6>

        <p>
          Kamu telah melakukan registrasi di akun LINE Official Tempo.co. <br>
          Untuk memverifikasi bahwa benar kamu telah melakukan registrasi dan benar bahwa 
          alamat email ini milik kamu, silahkan kamu klik link atau tombol verifikasi di bawah ini
        </p>

        <p>
          <a href="{{ $linkVerification }}" target="_blank">[VERIFIKASI SEKARANG]</a>
        </p>

        <p>
          Mengapa kamu menerima email ini?<br>
          Tempo.co melakukan verifikasi untuk menyelesaikan proses registrasi <br>
          sehingga kami mendapatkan konfirmasi bahwa alamat email ini memang benar
          dimiliki oleh kamu.
        </p>

        <p>
          Jika kamu tidak merasa melakukan registrasi di akun LINE Official Tempo.co. <br>
          silakan abaikan email ini. Link di email ini akan kadaluarsa dalam waktu 1 jam.
        </p>

        Salam,
        <br>
        Tempo.co
     </div>
   </div>
 </div>
</div>
 

</body>
</html>