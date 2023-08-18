<?php

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:logout.php');
   exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "user_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


//Bugün kontrol edilen ürün sayisini almak icin 
$today = date("Y-m-d");
$sql = "SELECT COUNT(*) as total FROM quality_control_forms WHERE check_date = '$today'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCheckedItemsToday = $row["total"];
} else {
    $totalCheckedItemsToday = 0;
}


// Haftalık kontrol edilen ürün sayısını almak için 
$startOfWeek = date("Y-m-d", strtotime('monday this week'));
$endOfWeek = date("Y-m-d", strtotime('sunday this week'));

$sql_weekly = "SELECT COUNT(*) as total FROM quality_control_forms WHERE check_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
$result_weekly = $conn->query($sql_weekly);

if ($result_weekly && $result_weekly->num_rows > 0) {
    $row_weekly = $result_weekly->fetch_assoc();
    $totalCheckedItemsWeekly = $row_weekly["total"];
} else {
    $totalCheckedItemsWeekly = 0;
}

// Aylık kontrol edilen ürün sayısını almak için
$startOfMonth = date("Y-m-01");
$endOfMonth = date("Y-m-t");

$sql_monthly = "SELECT COUNT(*) as total FROM quality_control_forms WHERE check_date BETWEEN '$startOfMonth' AND '$endOfMonth'";
$result_monthly = $conn->query($sql_monthly);

if ($result_monthly && $result_monthly->num_rows > 0) {
    $row_monthly = $result_monthly->fetch_assoc();
    $totalCheckedItemsMonthly = $row_monthly["total"];
} else {
    $totalCheckedItemsMonthly = 0;
}

// Toplam kontrol edilen ürün sayısını almak için
$sql_total = "SELECT COUNT(*) as total FROM quality_control_forms";
$result_total = $conn->query($sql_total);

if ($result_total && $result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $totalCheckedItemsTotal = $row_total["total"];
} else {
    $totalCheckedItemsTotal = 0;
}

// Yüzde hesaplaması
$percent = ($totalCheckedItemsTotal > 0) ? round(($totalCheckedItemsMonthly / $totalCheckedItemsTotal) * 100) : 0;


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="dashboard.css" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
        <img src="logo.png" alt="GEMAS Logo" class="logo"> GEMAŞ
    </div>
    <div class="list-group list-group-flush my-3">
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </a>
        <form action="" method="GET">
            <select id="exfiles" name="exfiles" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                <option value="">Dosya seç</option>
                <option value="download">Excel Dosyası1</option>
                <option value="download">Excel Dosyası2</option>
            </select>
        </form>
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
            <i class="fas fa-chart-line me-2"></i>Analytics
        </a>
        <a href="kayit.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
            <i class="fas fa-paperclip me-2"></i>Kullanıcı ekle
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
            <i class="fas fa-shopping-cart me-2"></i>Store Mng
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
            <i class="fas fa-gift me-2"></i>Products
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
            <i class="fas fa-comment-dots me-2"></i>Chat
        </a>
        <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
            <i class="fas fa-power-off me-2"></i>Logout
        </a>
    </div>
</div>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i>
                                    <span class="admin_name"><?php echo $_SESSION['admin_name']; ?></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-2">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                               <h3 class="fs-2"><?php echo $totalCheckedItemsToday; ?></h3>
                                <p class="fs-5">Bugün Kontrol Edilenler</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                            <h3 class="fs-2"><?php echo $totalCheckedItemsWeekly; ?></h3>
                                <p class="fs-5">Bu hafta kontrol edilenler</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                            <h3 class="fs-2"><?php echo $totalCheckedItemsMonthly; ?></h3>
                                <p class="fs-5">Bu ay kontrol edilenler</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                  <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                        <h3 class="fs-2"><?php echo $totalCheckedItemsTotal; ?></h3>
                        <p class="fs-5">Toplam kontrol edilenler</p>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" style="width: 300px; height: 184px;">
         <canvas id="myBarChart"></canvas>
        </div>

                <div class="row my-5">
                <h3 class="fs-4 mb-3 recent-orders-heading">Forms</h3>
                    <div class="col">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Arama yap..." onkeydown="handleEnter(event)">
                     <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="filterTable()">Ara</button>
                     </div>
                  </div>
                  <div style="overflow-x: auto;">
                          <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Kod</th>
                                    <th scope="col">Seri No</th>
                                    <th scope="col">Üretim Tarihi</th>
                                    <th scope="col">Çizimlere ve özel taleplere uygunluk</th>
                                    <th scope="col">Dış temizlik ve yüzey kalitesi</th>
                                    <th scope="col">İç temizlik</th>
                                    <th scope="col">Boru bağlantılarının terazisi</th>
                                    <th scope="col">İç elemanların uygunluğu</th>
                                    <th scope="col">Kafadan terazi kontrolü</th>
                                    <th scope="col">kapak, oring, vida, somun kontrolü</th>
                                    <th scope="col">Filtre ayak temizliği</th>
                                    <th scope="col">Filtre ayağına uygun vida kontrolü</th>
                                    <th scope="col">Etiketlerin kontrolü</th>
                                    <th scope="col">İç elyaf laminasyonu</th>
                                    <th scope="col">Sonuç</th>
                                    <th scope="col">Notlar</th>
                                    <th scope="col">Numarası</th>
                                    <th scope="col">Kontrol süresi</th>
                                    <th scope="col">Kontrol eden</th>
                                    <th scope="col">Kontrol tarihi</th>
                                    <th scope="col">Video linki</th>
                                    <th scope="col">Müşteri</th>
                                </tr>
                            </thead>
                            
                            <tbody>
   <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "user_db";

      $conn = new mysqli($servername, $username, $password, $database);

      if ($conn->connect_error) {
         die("Connection Failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM quality_control_forms";
      $result = $conn->query($sql);

      if (!$result) {
         die("Invalid query: " . $conn->error);
      }

      while ($row = $result->fetch_assoc()) {
         $video_name = $row["code"] . "-" . $row["serial_number"];
         $video_link = $row["video_link"];
         $link_or_text = ($video_link != '') ? '<a href="' . $video_link . '" target="_blank">' . $video_name . '</a>' : 'Video Yok';
         
         echo '
         <tr>
            <td>' . $row["code"] . '</td>
            <td>' . $row["serial_number"] . '</td>
            <td>' . $row["production_date"] . '</td>
            <td>' . $row["compliance_with_drawings_special_requests"] . '</td> 
            <td>' . $row["external_cleaning_surface_quality"] . '</td>
            <td>' . $row["internal_cleaning_surface_quality"] . '</td>
            <td>' . $row["scales_of_pipe_connections"] . '</td>
            <td>' . $row["compatibility_of_internal_elements"] . '</td>
            <td>' . $row["checking_the_scale_from_the_head"] . '</td>
            <td>' . $row["checking_the_cover_o_ring_screw_nut"] . '</td>
            <td>' . $row["filter_foot_cleaning"] . '</td> 
            <td>' . $row["screw_checking_suitable_for_filter_foot"] . '</td>
            <td>' . $row["checking_the_labels"] . '</td>
            <td>' . $row["internal_fiber_lamination"] . '</td>
            <td>' . $row["result"] . '</td>
            <td>' . $row["notes"] . '</td>
            <td>' . $row["number"] . '</td>
            <td>' . $row["check_time"] . '</td> 
            <td>' . $row["checker"] . '</td>
            <td>' . $row["check_date"] . '</td>
            <td>' . $link_or_text . '</td>
            <td>' . $row["client"] . '</td>
         </tr>';
      }

      $conn->close();
   ?>
</tbody>

                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /#page-content-wrapper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
    <script>
        function handleEnter(event) {
            if (event.key === "Enter") {
                filterTable();
            }
        }

        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementsByClassName("table")[0];
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) { // Skip the header row (i=0)
                td = tr[i].getElementsByTagName("td");
                var visible = false;
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            visible = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = visible ? "" : "none";
            }
        }
    </script>


<script>
  // Verileri PHP değişkenlerinden alalım
  var totalCheckedItemsToday = <?php echo $totalCheckedItemsToday; ?>;
  var totalCheckedItemsWeekly = <?php echo $totalCheckedItemsWeekly; ?>;
  var totalCheckedItemsMonthly = <?php echo $totalCheckedItemsMonthly; ?>;
  var totalCheckedItemsTotal = <?php echo $totalCheckedItemsTotal; ?>;

  // Bar Chart için gerekli verileri hazırlayalım
  var ctx = document.getElementById("myBarChart").getContext("2d");
        var myBarChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Bugün", "Bu Hafta", "Bu Ay", "Toplam"],
                datasets: [
                    {
                        label: "Kontrol Edilen Ürünler",
                        data: [totalCheckedItemsToday, totalCheckedItemsWeekly, totalCheckedItemsMonthly, totalCheckedItemsTotal],
                        backgroundColor: [
                            "rgba(1,209,255,255)",    /* Kırmızı renk tonu */
                            "rgba(1,209,255,255)",    /* Mavi renk tonu */
                            "rgba(1,209,255,255)",    /* Sarı renk tonu */
                            "rgba(1,209,255,255)",    /* Turkuaz renk tonu */
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
            x: {
                grid: {
                    display: false // X ekseni (yatay çizgiler) için gridLines'i kapat
                }
            },
            y: {
                beginAtZero: true,
            },
        },
    },
});
</script>


</body>

</html>
