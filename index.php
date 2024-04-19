<?php
$servername="localhost";
$username="root";
$password="";
$database="calculator";
$tablename="history";
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("There is an error occur----->".mysqli_connect_error($conn));
}else{
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $expression = $_POST['expression'];
        $result = $_POST['result'];
        $sql = "INSERT INTO $tablename (calculations,result) VALUES ('$expression', '$result')";
        mysqli_query($conn, $sql);
        
        
        header("Location: index.php");
        exit();
    }
}

?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="calculator.css">
    <title>Calculator</title>
</head>

<body>
    <div class="container" id="main-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="display-box">
            <input type="text" value="" class="displayInput" name="result">
            <input type="hidden" name="expression" value="" class="expressionInput">
        </div>
        <div class="button-rows" style="display: inline-block;">
            <div class="row" id="row1">
                <input type="button" value="AC" class="numberInput">
                <input type="button" value="DEL" class="numberInput">
                <input type="button" value="%" class="numberInput">
                <input type="button" value="/" class="numberInput">

            </div>
            <div class="row" id="row2">
                <input type="button" value="7" class="numberInput">
                <input type="button" value="8" class="numberInput">
                <input type="button" value="9" class="numberInput">
                <input type="button" value="*" style="color: rgb(19, 207, 207);" class="numberInput">
            </div>
            <div class="row" id="row3">
                <input type="button" value="4" class="numberInput">
                <input type="button" value="5" class="numberInput">
                <input type="button" value="6" class="numberInput">
                <input type="button" value="-" style="color: rgb(19, 207, 207);" class="numberInput">
            </div>
            <div class="row" id="row4">
                <input type="button" value="1" class="numberInput">
                <input type="button" value="2" class="numberInput">
                <input type="button" value="3" class="numberInput">
                <input type="button" value="+" style="color: rgb(19, 207, 207);" class="numberInput">
            </div>
            <div class="row" id="row5">
                <input type="button" value="0" class="numberInput">
                <input type="button" value="00" class="numberInput">
                <input type="button" value="." class="numberInput">
                <input type="submit" value="=" style="color:red;" class="numberInput">
            </div>
            
        </div>
        </form>
    </div>
    <div class="historyContainer">
       
        <div class="history">
            <h3>Calculation History</h3>
            <?php
            $history_query = "SELECT * FROM $tablename";
            $history_result = mysqli_query($conn, $history_query);
            if (mysqli_num_rows($history_result) > 0) {
                while ($row = mysqli_fetch_assoc($history_result)) {
                    echo "<p>{$row['calculations']}={$row['result']}</p>";
                }
            }
            ?>
            
        </div>
    </div>



    <!-- script start -->
    <script>
        let numbers = document.querySelectorAll(".numberInput");
        let display = document.querySelector(".displayInput");
        let expression=document.querySelector(".expressionInput");
        // display.disabled=true;
        let c;
    //     document.querySelector("form").addEventListener("submit", function(event) {
    //     event.preventDefault(); // Prevent default form submission behavior
    //     calculate(); // Calculate locally
    // });
        numbers.forEach(number => {
            number.addEventListener("click", function () {
                if (number.value != "AC") {
                    if (number.value != "DEL") {

                        if (number.value == "=") {
                            try {
                                expression.value=display.value;
                                display.value = eval(display.value);

                            } catch (error) {
                                display.value = "Error";
                                console.error("Error:", error);
                            }
                            c=1;

                        }else{
                            if(c==1){
                                display.value=null;
                                display.value=number.value;
                                c=0;
                            }else{
                                display.value += number.value;
                            }
                            
                        }
                        
                    } else {
                        let displayValue = display.value;
                        display.value = displayValue.substring(0, displayValue.length - 1);
                    }

                } else {
                    display.value = null;
                }



            });
        });
        function calculate() {
        try {
            display.value = eval(display.value);
        } catch (error) {
            display.value = "Error";
            console.error("Error:", error);
        }
    }

    </script>
</body>

</html>