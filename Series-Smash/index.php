<?php 
    //this enables database connectivity using PHP 
    require_once("init.php");
    //this links the main process file to the main webpage displaying the images 
	require_once("process.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Series-Smash</title>
</head>
<body>
<header> 
	<h1>Series-Smash </h1> 
</header> 
	<p id="first">What is your favorite T.V. Show?</p>  
	<p id="second">Click to choose. This or That.</p>  
	<div id="dual">
        <!-- links the file which diplays random images for the user to choose from on the main page -->
		<?php require_once("ajax/ajax.dual.php"); ?> 
	</div>
<footer>Designed and developed for DAA assignment by <a target="_blank">Rajshree & Priya</a></footer>
<script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".photos").click(function() {
                    $("#loader").fadeIn("fast"); //determines transition for the gif on clicking a new image
                    //attr returns or sets any attribute value  
                    //here, it is used to retrieve the value of the selected image by the user and stores it in the respective variables for token and score values
                    var tokenFirst  = $(".faces:first-child .photos").attr("data-token"),
                        tokenSecond = $(".faces:last-child .photos").attr("data-token"),
                        scoreFirst  = $(".faces:first-child .photos").attr("data-score"),
                        scoreSecond = $(".faces:last-child .photos").attr("data-score"),
                        //initialize the tokens and scores for dynamically selected pictues
                        winner,
                        looser,
                        wScore,
                        lScore;
                        //assigns the selected image as winner and it's score based on elo rating algorithm            
                        if (tokenFirst == $(this).attr("data-token"))
                        {
                            winner = tokenFirst;
                            looser = tokenSecond;
                            wScore = scoreFirst;
                            lScore = scoreSecond;
                        }
                        else
                        {
                            winner = tokenSecond;
                            looser = tokenFirst;
                            wScore = scoreSecond;
                            lScore = scoreFirst;
                        }
                    //allows the get/post request to be sent to the http 
                    //for submitting & retrieving data without re-loading the whole page
                    $.ajax({
                        type: "post", 
                        url: "index.php", //contains the url we want to reach with the ajax call
                        data: "winner=" + winner + "&looser=" + looser + "&wScore=" + wScore + "&lScore=" + lScore,
                        cache: false,
                        success: function(data) {
                            $("body").html(data);
                            $("#loader").fadeOut("fast"); //determines transition for the gif on clicking a new image
                        }
                    });
                });
            });
        </script>
</body>
</html>