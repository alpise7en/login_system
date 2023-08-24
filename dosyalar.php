<?php
// Start the session (if not already started)
session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
	<style>
		body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #16113a; /* Arka plan rengi */
    }

		.container {
			width: 80%;
			max-width: 1200px;
			margin: 50px auto;
			background-color: #16113a;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		h1 {
			text-align: center;
			margin-top: 0;
			padding: 20px 0;
			color: #007bff;
			border-bottom: 2px solid #007bff;
		}

		.download-buttons {
			text-align: center;
			margin-top: 24px;
		}

		.download-buttons a {
			display: block;
			width: 100%;
			padding: 12px 16px;
			border-radius: 4px;
			text-decoration: none;
			color: #fff;
			background-color: #007bff;
			transition: background-color 0.2s ease;
			margin-bottom: 8px;
		}

		.download-buttons a:hover {
			background-color: #0056b3;
		}

		.footer {
			text-align: center;
			margin-top: 40px;
			padding-top: 20px;
			border-top: 1px solid #007bff;
		}

		.footer p {
			margin: 0;
			color: #007bff;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>Excel Export</h1>
		<div class="button">
			<a class="btn btn-primary" href="admin_page.php">Geri dön</a>
		</div>
		<div class="download-buttons">
			<a class="btn btn-primary" href="download_forms.php?form_type=quality_control_forms">Kalite Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=multiway_valve_control_form">Çok Yollu Vana Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=assembly_quality_control_form">Montaj Kalite Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=ladder_final_control">Merdiven Kalite Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=filtration_control">Filtrasyon Kalite Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=valve_periodic_control_form">Vana Periyodik Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=pump_section_periodic_check">Pompa Bölümü Periyodik Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=rotation_shell_quality_control">Rotasyon Kabuk Kalite Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=white_product_and_electronic_form">Beyaz Ürün ve Elektronik Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=pompa_final_quality_control">Pompa Final Kalite Kontrol Formlarını İndir</a>
			<a class="btn btn-primary" href="download_forms.php?form_type=manufacturing_approval_form">İmalat Onay Formlarını İndir</a>
		</div>
        <div class="footer">
            <p>Gemaş &copy; <?php echo date('Y'); ?></p>
        </div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>