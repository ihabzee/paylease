<?php
require 'Calculator.php';
?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
    <form method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Pattern</label>
            <input type="hidden" name="pattern" id="pattern" value="">
            <strong>
                <div id="pattern-text"></div>
            </strong>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Build you pattern by typing number then click Add.</label>
            <input type="text" name="number" class="form-control" id="number"
                   placeholder="Enter Number">
            <button type="submit" name="add" id="add" class="btn btn-info">Add</button>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Click on Math operation.</label>
            <button type="button" name="sum" id="sum" class="sing btn btn-info">+</button>
            <button type="button" name="sub" id="sub" class="sing btn btn-info">-</button>
            <button type="button" name="multi" id="multi" class="sing btn btn-info">*</button>
            <button type="button" name="divide" id="divide" class="sing btn btn-info">/</button>
        </div>
        <p>Once Pattern is Complete click submit</p>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <div>
        <?php
        if (isset($_POST['submit'])) {
            $calculator = new Calculator();
            try {
                $pattern = $_POST['pattern'];
                $result = $calculator->calculate($pattern);
                ?>
                <div class="alert alert-success">Pattern `<strong><?php echo $pattern ?></strong>` provides following Result: <?php echo $result[0]; ?></div>
                <p>Performed Operations:</p>
                <div>
                    <?php
                    foreach ($calculator->operations as $operation){
                        echo  '<li>' . $operation . '<br>';
                    }
                    ?>
                </div>
                <?php
            } catch (\Exception $e) {
                ?>
                <p>Performed Operations:</p>
                <div>
                    <?php
                    foreach ($calculator->operations as $operation){
                        echo '<li>' . $operation . '<br>';
                    }
                    ?>
                </div>
                <div class="alert alert-danger"><?php echo $e->getMessage(); ?></div>
                <?php
            }
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function () {

        $("#add").click(function () {
            var num = $("#number").val();

            if (num == '') {
                alert('Please add number');
                return false;
            }
            else if (isNaN(num)) {
                alert('Invalid Number');
                return false;
            }
            $("#number").val('');
            appendToPattern(num);
            return false;
        });
        $(".sing").click(function () {
            var sing = $(this).text();
            appendToPattern(sing);
            $("#number").val('')
            return false;
        });

        function appendToPattern(value) {
            var pattern = $("#pattern").val();
            if (pattern.length == 0) {
                pattern = value;
            } else {
                pattern = pattern + ' ' + value;
            }
            $("#pattern").val(pattern);
            $("#pattern-text").text(pattern);
        }
    });
</script>
</body>
</html>