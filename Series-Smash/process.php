<?php
//if the variables are declared, then the following process is started
if (isset($_POST['winner'], $_POST['looser'],
          $_POST['wScore'], $_POST['lScore']))
{
    function checkExists($mysqli, $token, $score)
    {
        //extract the selected images token numbers and scores
        $qExists = $mysqli->query('
                   SELECT id
                   FROM photos
                   WHERE token = "' . $mysqli->real_escape_string($token) . '"
                   AND score = ' . (int)$score);
        //checks if the given id of selected image is in the database           
        if ($qExists->num_rows >= 1)
            return(true);
        else
            return(false);
    } 
    //when the user clicks an image, the following process is started
    if (checkExists($mysqli, $_POST['winner'], $_POST['wScore']) == true &&
        checkExists($mysqli, $_POST['looser'], $_POST['lScore']) == true)
    {
        //if the winner score is greater, then the winner's score is saved in highScore variable
        //if the loser score is greater, then the loser's score is saved in highScore variable
        if ($_POST['wScore'] >= $_POST['lScore'])
        {
            $highScorePeople = $_POST['winner'];
            $lowScorePeople = $_POST['looser'];
            $highScore = $_POST['wScore'];
            $lowScore = $_POST['lScore'];
        }
        else
        {
            $highScorePeople = $_POST['looser'];
            $lowScorePeople = $_POST['winner'];
            $highScore = $_POST['lScore'];
            $lowScore = $_POST['wScore'];
        }

        //elo rating implementation
        $winnerUpResult = (($highScore - $lowScore) / 400) + 20; //the points to be added in the winner's current score
        $winnerDownResult = (($highScore - $lowScore) / 400) + 20; //the points to be added in the loser's current score

        //if the player with the higher score wins, then update both image's scores
        if ($highScorePeople == $_POST['winner'])
        {
            //the winner player gains points based on the K-value(here, K=20)
            $mysqli->query('
            UPDATE photos
            SET score = score + ' . (int)$winnerUpResult . '
            WHERE token = "' . $mysqli->real_escape_string($highScorePeople) . '"');
            
            //the loser player losses the number of points gained by the winner player
            $mysqli->query('
            UPDATE photos
            SET score = score - ' . (int)$winnerDownResult . '
            WHERE token = "' . $mysqli->real_escape_string($lowScorePeople) . '"');
        }
        //if the player with the lower score wins, then update both image's scores
        else
        {
            //the winner player gains points based on the K-value(here, K=20)
            $mysqli->query('
            UPDATE photos
            SET score = score + ' . (int)$winnerDownResult . '
            WHERE token = "' . $mysqli->real_escape_string($lowScorePeople) . '"');

            //the loser player losses the number of points gained by the winner player
            $mysqli->query('
            UPDATE photos
            SET score = score - ' . (int)$winnerUpResult. '
            WHERE token = "' . $mysqli->real_escape_string($highScorePeople) . '"');
        }
        //if the score goes below 0, it is reset to 0. 
        $mysqli->query('
        UPDATE photos
        SET score = 0
        WHERE score < 0');
    }
    else
    {
        //to redirect the user to the main page with new updated results of all data entries
        header('Location: index.php');
        exit;
    }
}