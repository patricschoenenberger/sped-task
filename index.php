<?php

require_once "./Checker.class.php";

if(isset($_POST["nve:action"])){
    $number = $_POST['nve_number'];
    switch($_POST["nve:action"]) {
        case "create":
            $n = $checker->createNumber($number);
            if($n === false) {
                $message = "<h2>Error creating Validation Number. Please make sure number has a Length of 17 digits.</h2>";
            } else {
                $message = "<h2>Congratulations! Your number is: $number$n </h2>";
            }
            break;
        case "validate":
            $n = $checker->checkNumber($number);
            if($n === false) {
                $message = "<h2>Your Number is not correct! Please try again</h2>";
            } else {
                $message = "<h2>Congratulations! Your number $number is valid </h2>";
            }
            break;
        default:
            break;
    }
}

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NVE Checker</title>
</head>
<body>
    <?php echo $message; ?>
    <form method="post">
        <input type="hidden" name="nve:action" value="create">
        <input type="text" required name="nve_number" value="<?php echo ""; ?>">
        <button type="submit">Create Validation Number</button>
    </form>
    <form method="post">
        <input type="hidden" name="nve:action" value="validate">
        <input type="text" required name="nve_number" value="<?php echo $number; ?>">       
        <button type="submit">Check Code</button>
    </form>
</body>
</html>