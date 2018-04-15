<!DOCTYPE html>
<html>
<head>
<title>列印信封</title>
</head>
<body>

<?php

    $db = new SQLite3('6e20180413.db');
    var_dump($db);

    if (count($_POST)) {
        $from_no = $_POST['from'];
        $to_no   = $_POST['to'];
        // $db = new SQLite3('6e20180413.db');
        $query = "SELECT zip,address,name,cust_no,gendar FROM customer where print = 'Y' AND cast(cust_no as decimal) > $from_no AND cast(cust_no as decimal) < $to_no";
        echo $query;
        $data = $db->query($query);

        while ($row = $data->fetchArray()) {
            //var_dump($row);
            // echo '<p>';
            // print($row[0] . $row[1] . $row[2] . $row[3]);
            // print($row[2] . $row[3]);
        
            //var_dump($row);
        
            $zip = $row[0];
        
            // mb_substr($name,0,1,"UTF-8");
        
            $address = rtrim(mb_substr($row[1],3,60,"UTF-8"));
 
            // $address = str_replace(' ', '', $address);
        
            $name = $row[2];
            $cust_no = $row[3];
            
            $gendar = $row[4];


            if ($gendar == '1') {
              $title = "先生";
            } else if ($gendar == '2') {
              $title = "小姐";
            } else {
              $title = "";
            }

            echo "($cust_no)($address)($name)($title)<br>";

        }
    }
?>

<h1>陸億家電信封信列印</h1>

<form action="" method="POST">
  開始:<br>
  <input type="text" name="from" value="">
  <br>
  結束:<br>
  <input type="text" name="to" value="">
  <br><br>
  <input type="submit" value="Submit">
</form> 

</body>
</html>