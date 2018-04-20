<!DOCTYPE html>
<html>
<head>
<title>列印信封</title>
<style>

    body {
        /* width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma"; */
        font-family: BiauKai;
    }

    /* body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
        font-family: BiauKai;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 238mm;
        min-height: 126mm;
        padding: 0mm;
        margin: 0mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 0px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 0cm;
        border: 5px red solid;
        height: 126mm; 
        outline: 2cm #FFEAEA solid;
    } */
    /*
    @page {
        size: Letter;
        margin: 0;
    }
    */
    /* @media print {
        html, body {
            width: 238mm;
            height: 126mm;
            font-family: BiauKai;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    } */


    @page {
        size: 238mm 126mm;
    }

    @media print {
        .book {
            margin-top: 150px;
            margin-left: 200px;
            font-size: 32px;
            line-height: 1.2;
        }
        .zip {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            padding-left: 5px;
        }
        .cust_no {
            font-size: 12px;
            /* margin-left: 450px; */
            /* position:absolute; */
            text-align:right;
            margin-right: 100px;
            margin-top: 30px;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }
        .note {
            font-size: 18px;
            /* position:absolute; */
            /* margin-left: 300px; */
            text-align:right;
            margin-right: 100px;
            margin-top: 10px;
            /* font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; */
        }
    }

    /* @media print {
       footer {page-break-after: always;}
    } */

    /* @media print 
    {
        @page
        {
            size: 126mm 238mm;
            size: landscape;
        }
    } */
/* $mpdf->WriteHTML('<pagebreak sheet-size="238mm 126mm" />'); */


</style>
</head>
<body>

<?php

    $db = new SQLite3('6e20180413.db');
    // var_dump($db);

    if (count($_POST)) {
        $from_no = $_POST['from'];
        $to_no   = $_POST['to'];
        // $db = new SQLite3('6e20180413.db');
        $query = "SELECT zip,address,name,cust_no,gendar FROM customer where print = 'Y' AND cast(cust_no as decimal) > $from_no AND cast(cust_no as decimal) < $to_no";
        // echo $query;
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

            $sql = "SELECT city,area FROM zip WHERE CAST(zip as number) = $zip";
            // echo $sql;
            $r = $db->query($sql);

            // var_dump($r);

            $city = "";
            $area = "";

            $zip_row = $r->fetchArray();
            $city = $zip_row[0];
            $area = $zip_row[1];
            echo "<div class='book'>";
            echo "  <div class='page'>";
            echo "      <div class='subpage'>";
            echo "          <div class='font zip'>$zip</div>";
            echo "          <div class='font cityArea'>$city$area</div>";
            echo "          <div class='font address'>$address</div>";
            echo "          <div class='font nameTitle'>$name $title</div>";
            echo "          <div class='font note'>♡母親節♡感恩活動，5/10至5/21為止♡</div>";
            // echo "          <div class='font note'>憑《<b>信封</b>》來就送感恩小禮物</div>";
            echo "          <div class='font cust_no'>$cust_no</div>";
            echo "      </div>";
            echo "  </div>";
            echo "</div>";
            // echo "<div class='pagebreak'></div>";
            echo "<p style='page-break-after:always'></p>";
            // echo "<footer/>";
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