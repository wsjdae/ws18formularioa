<!DOCTYPE html>
<?php
  session_start();    
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>ADD QUESTION</title>
	<link rel='stylesheet' type='text/css' href='../styles/caja.css' />
</head>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<body>
    
        <header>
            <?php
            $userName = $_SESSION['erabiltzaile'];
            echo "<span id=userPhp>".$userName."</span>"
            ?>
            <h2>Quiz: crazy questions</h2>
        </header>
        
       
        <div class="cajaMorea">
                <h1>Galdera berri bat gehitu:</h1>
                <p>*-k derrigorrezko eremuak</p>
                <br>
                <form id="galderenF" name="galderenF" action="addQuestionWithImage.php" onsubmit="return true;" method="POST" enctype="multipart/form-data">
                    Egilearen eposta(*): <input type="email" name="email" id="email" required pattern="^([a-z]{2,})([0-9]{3})@ikasle\.ehu\.eus$" value="<?php $userName = $_SESSION['erabiltzaile']; echo $userName ?>" onClick="this.value=''" oninvalid="this.setCustomValidity('Sartu emaila formatu egokian')" oninput="setCustomValidity('')"><br>
                    Galderaren testua(*): <input type="text" name="galdera" id="galdera" required pattern="[^']{10,}?$" oninvalid="this.setCustomValidity('Sartu gutxienez 10 karaktereko luzeera duen galdera')" oninput="setCustomValidity('')"><br>
                    Erantzun zuzena(*): <input type="text" name="zuzena" id="zuzena" required oninvalid="this.setCustomValidity('Erantzun zuzena ezin da hutsik utzi.')" oninput="setCustomValidity('')"><br>
                    Erantzun okerra #1(*): <input type="text" name="okerra1" id="okerra1" required oninvalid="this.setCustomValidity('Erantzun okerra ezin da hutsik utzi.')" oninput="setCustomValidity('')"><br>
                    Erantzun okerra #2(*): <input type="text" name="okerra2" id="okerra2" required oninvalid="this.setCustomValidity('Erantzun okerra ezin da hutsik utzi.')" oninput="setCustomValidity('')"><br>
                    Erantzun okerra #3(*): <input type="text" name="okerra3" id="okerra3" required oninvalid="this.setCustomValidity('Erantzun okerra ezin da hutsik utzi.')" oninput="setCustomValidity('')"><br>
                    Galderaren zailtasuna(*): <input type="text" name="zailt" id="zailt" required pattern="^[0-5]$" oninvalid="this.setCustomValidity('Zailtasuna 0 eta 5 arteko zenbakia izan behar da')" oninput="setCustomValidity('')"><br>
                    Galderaren gai-arloa(*): <input type="text" name="gaia" id="gaia" required oninvalid="this.setCustomValidity('Gaia ezin da hutsik utzi.')" oninput="setCustomValidity('')"><br>
                    Galderarekin zer-ikusia duen irudia:
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

                    <input type="submit" name="bidali" value="Bidali" />
                    <input type="reset" value="Ezabatu" />
                </form>
                <br>
				<?php
					echo "<p><a href='layout.php'>Home</a></p>"
				?>
        </div>
    
</body>

</html>
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

</script>
