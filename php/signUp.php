<!DOCTYPE HTML>
<html>
<head> 
	<title>SIGN UP</title> 
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../styles/caja.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<body>
	<div class="cajaUrdina">
	<h3>SIGN UP</h3>
	<p>*-k derrigorrezko eremuak</p>
	
	<br>
		<form id="signUpF" name="signUpF" action="" onsubmit="return true;" method="POST" enctype="multipart/form-data"> 
			Eposta(*): <input type="email" name="email" id="email" required pattern="^([a-z]{2,})([0-9]{3})@ikasle\.ehu\.eus$" value="xxxxxx000@ikasle.ehu.eus" onfocusout='eginAjaxEmail()' onClick="this.value=''" oninvalid="this.setCustomValidity('Sartu emaila formatu egokian')" oninput="setCustomValidity('')"><br>
			Deiturak(*): <input type="text" name="deiturak" id="deiturak" required pattern="^([A-Z]{1}[a-z]+\s)([A-Z]{1}[a-z]+(\s)?)+$" oninvalid="this.setCustomValidity('Sartu Izena eta abizena, gutxienez bat')" oninput="setCustomValidity('')"><br>
			Pasahitza(*): <input type="password" name="pasahitza" id="pasahitza" required pattern="^.{8,}$" oninvalid="this.setCustomValidity('Gutxienez 8ko luzeera izan behar du.')"  onfocusout='eginAjaxPasahitza()' oninput="setCustomValidity('')"><br>
			Errepikatu pasahitza(*): <input type="password" name="pasahitza2" id="pasahitza2" required pattern="^.{8,}$" oninput="check(this)" onchange="check(this)"><br>
			Irudia:
			<div id="divMain">
				<div id="divInputLoad">
					<div id="divFileUpload">
						<input id="file-upload" name="file-upload" type="file" accept="image/*" />
					</div>
				
					<div id="file-preview-zone">
					</div>
				</div>
			</div>			
			<br>
			<br>
			
			<input type="submit" name="bidali" id="bidali" value="Erregistratu"/>
			<input type="reset" value="Ezabatu"/>
	</form> 	
	<br>
	<span id="mensaje"></span>
	<span id="mensaje2"></span>
	<span><a href='layout.php'>Home</a></span>
	</div>
	
	<?php
	include 'dbKonfiguratu.php';

	if(isset($_POST['bidali'])){
		# code...
			$esteka = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
		
			if($esteka->connect_errno){
				die( "Huts egin du konexioak MySQL-ra: (".
					$esteka-> connect_errno. ") " . 
					$esteka-> connect_error);
			}
			echo "Konexioa egin da:" .$esteka->host_info;
			echo "<br>";
			$imagename=$_FILES["file-upload"]["name"];
			$encriptedPss = password_hash($_POST['pasahitza'], PASSWORD_DEFAULT);
			echo ".$encriptedPss.";
			if (!empty($imagename)){
				$imagetmp=addslashes(file_get_contents($_FILES['file-upload']['tmp_name']));
				
				$sql = "INSERT INTO erregistratuak(EPOSTA,DEITURAK,PASAHITZA,ARGAZKIA) VALUES ('$_POST[email]', '$_POST[deiturak]', '$encriptedPss', '$imagetmp')";
			}else{
				$sql = "INSERT INTO erregistratuak(EPOSTA,DEITURAK,PASAHITZA) VALUES ('$_POST[email]', '$_POST[deiturak]', '$encriptedPss')";
			}	

			//
			$sql2 = mysqli_query($esteka,"SELECT * FROM `erregistratuak` WHERE `EPOSTA` LIKE '$_POST[email]'");
			$count = mysqli_num_rows($sql2);
			if($count != "0"){
				echo " Erabiltzailea badago erregistratuta.";
			}else{
				$ema=mysqli_query($esteka, $sql);
				if (!$ema) {
				die('Errorea query-a gauzatzerakoan: ' .mysqli_error($esteka));
				}
				echo "Erabiltzaile bat gehitu da!<br>";
				echo "<p><a href='layout.php'> Hasiera </a>";
			}
	}
	

	?>
	
	<script>
	
		function check(input) {
			var $pash2 = $("#pasahitza2").val();
			var $pash1 = $("#pasahitza").val();
			if ($pash1 != $pash2) {
				input.setCustomValidity('Sartu pasahitza bera');
			} else {
				input.setCustomValidity('');
			}
		}
	</script>	
		
</body>
	<script>
		function readFile(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					var filePreview = document.createElement('img');
					filePreview.id = 'file-preview';
					//e.target.result contents the base64 data from the image uploaded
					filePreview.src = e.target.result;
					console.log(e.target.result);

					var previewZone = document.getElementById('file-preview-zone');
					previewZone.appendChild(filePreview);
				}

				reader.readAsDataURL(input.files[0]);
				}
		}

		var fileUpload = document.getElementById('file-upload');
		fileUpload.onchange = function (e) {
		readFile(e.srcElement);
		}

		function eginAjaxEmail(){
			var eposta = $('input[name="email"]');
			var data = 'email=' + eposta.val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "emailEgiaztatu.php",
		        data: data,
				dataType: "html",
				success: function(response){
					$("#mensaje").html(response);
				} 
			}
		)};

		function eginAjaxPasahitza(){
			var password = $('input[name="pasahitza"]');
			var data = 'pasahitza=' + password.val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "pasahitzaEgiaztatu.php",
				data: data,
				dataType: "html",
				success: function(response){
					$("#mensaje2").html(response);
				}
			})
		
		}
	</script>

</html>
