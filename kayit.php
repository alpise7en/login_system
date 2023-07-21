<?php
include("config.php");

if(isset($_POST['kaydet']))
{
    $name = $_POST["kullaniciadi"];
    $email = $_POST["email"];
    $password = md5($_POST["parola"]);
    $cpass = md5($_POST["parola_confirm"]);
    $user_type = "";

    if(isset($_POST['user_type'])) {
        $user_type = $_POST['user_type'];
    }

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
        $error[] = 'Kullanıcı zaten mevcut!';
    } else {
        if($password != $cpass) {
            $error[] = 'Şifre eşleşmiyor!';
        } else {
            $insert = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name','$email','$password','$user_type')";
            $query_result = mysqli_query($conn, $insert);

            if($query_result) {
                header('location: admin_page.php');
                exit();
            } else {
                $error[] = 'Veritabanına ekleme hatası: ' . mysqli_error($conn);
            }
        }
    }

    mysqli_close($conn);
}
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Üye Kayıt</title>
  </head>
  <body>

<div class="container p-5">
    <div class="card p-5">

    <form action="kayit.php" method="POST">
    
    <div class="form-group">
    <label for="exampleInputEmail1">Kullanıcı Adı</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="kullaniciadi" placeholder="Kullanıcı adı giriniz">
  </div>    
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email giriniz">
  </div>
  <div class="form-group">
  <label for="exampleInputPassword1">Şifre</label>
  <input type="password" class="form-control" id="exampleInputPassword1" name="parola" placeholder="Şifre giriniz">
</div>

<div class="form-group">
  <label for="exampleInputConfirmPassword1">Şifreyi Onayla</label>
  <input type="password" class="form-control" id="exampleInputConfirmPassword1" name="parola_confirm" placeholder="Şifreyi onaylayınız">
</div>

  <div class="form-group form-check">
  <input type="checkbox" class="form-check-input" name="user_type" value="admin" id="adminCheckbox" onclick="toggleRegularCheckbox()">
  <label class="form-check-label" for="adminCheckbox">Admin</label>
</div>

<div class="form-group form-check">
  <input type="checkbox" class="form-check-input" name="user_type" value="user" id="regularCheckbox" onclick="toggleAdminCheckbox()">
  <label class="form-check-label"  for="regularCheckbox">User</label>
</div>
  <button type="submit" name="kaydet" class="btn btn-primary">Kaydet</button>
</form>

    </div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
  function toggleRegularCheckbox() {
    var regularCheckbox = document.getElementById("regularCheckbox");
    regularCheckbox.disabled = !regularCheckbox.disabled;
  }

  function toggleAdminCheckbox() {
    var adminCheckbox = document.getElementById("adminCheckbox");
    adminCheckbox.disabled = !adminCheckbox.disabled;
  }
</script>
  </body>
</html>