<?php


$html = '
<style>
p { text-align: justify; }
td { text-align: justify; }
</style>

<p style="font-size:38px; padding-left:180px; padding-top:120px;">111</p>
<p lang="zh-HK" style="font-size:38px; padding-left:180px;">&#21488;&#21271;&#24066;&#24310;&#24179;&#21271;&#36335;&#20116;&#27573;86&#34399;</p>
<p lang="zh-HK" style="font-size:38px; padding-left:180px;">&#35377;&#23478;&#40778; &#20808;&#29983;&#25910;</p>

<p style="position: absolute; right:0px; padding-top:50px; padding-right:50px;">00001</p>


';


//$get_zip = $_GET['zip'];

//$db = new SQLite3('../../6e_20161215.db');
//$db = new SQLite3('../../6e20160425.db');
#$db = new SQLite3('../../6e20161215.db');
//$db = new SQLite3('../../6e20170430.db');
// 資料庫的名稱要改
$db = new SQLite3('6e20180413.db');

var_dump($db);

$query = "SELECT zip,address,name,cust_no,gendar FROM customer where print = 'Y'";

/*
$query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' " .
              " AND cust_no >= " . "'" . $get_from . "'" .  " AND cust_no < '" . $get_to . "'";

$query = "SELECT zip,address,name,cust_no,gendar FROM customer where print = 'Y'";"
*/
// $query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' AND cust_no < '" . $get_to . "'"         AND cust_no >=  '" . $get_from . "'"; "


//$query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE cust_no = '00217' or cust_no = '00218'";

//$query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and cust_no < '03000'";
//$query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and cust_no >= '03000' and cust_no < '04000'";
//$query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and cust_no >= '04000' and cust_no < '05000'";
//$query = 
//"SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and "
//. "cust_no >= '05000' and cust_no < '06000'";
//$query = 
//"SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and "
//. "cust_no >= '06000' and cust_no < '07000'";
//$query = 
//"SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and "
//. "cust_no >= '07000' and cust_no < '08000'";
//$query = 
//"SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and "
//. "cust_no >= '08000' and cust_no < '09000'";

$get_from = 10;
$get_to = 100;

$query = "SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' and ";
$query .=  "cast(cust_no as decimal) >= $get_from and cast(cust_no as decimal) < $get_to";

$results = $db->query($query);
// $results = $db->query("SELECT zip,address,name,cust_no,gendar FROM customer WHERE print = 'Y' AND zip = '" . "100" . " ORDER BY zip LIMIT 100");


var_dump($results);


$html = "";

while ($row = $results->fetchArray()) {
    //var_dump($row);
    // echo '<p>';
    // print($row[0] . $row[1] . $row[2] . $row[3]);
    // print($row[2] . $row[3]);

    var_dump($row);

    $zip = $row[0];

    // mb_substr($name,0,1,"UTF-8");

    $address = mb_substr($row[1],3,60,"UTF-8");

    $address = str_replace(' ', '', $address);

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

    // // $word = str_word_count($row[1]);
    // print($name);

    $query_string = "SELECT city,area FROM zip WHERE zip = '" . $zip . "'";


// SELECT * FROM myTable WHERE myNumber >= 1 AND myNumber <= 100;

    $zip_result = $db->query($query_string);
    $zip_row = $zip_result->fetchArray();
    $city = $zip_row[0];
    $area = $zip_row[1];

    $html = $html . "<p style='font-size:32px; padding-left:152px; padding-top:120px;'>" . $zip . "</p>";
    // $html = $html . "<p lang='zh-HK' style='font-size:32px; padding-left:180px;'>" . $city . $area . $query_string . "</p>";
    $html = $html . "<p lang='zh-HK' style='font-size:32px; padding-left:150px;'>" . $city . $area . "</p>";
    $html = $html . "<p lang='zh-HK' style='font-size:32px; padding-left:150px;'>" . $address . "</p>";
    $html = $html . "<p lang='zh-HK' style='font-size:32px; padding-left:150px;'>" . $name . " " . $title . "</p>";
    // $html = $html . "<p lang='zh-HK' style='font-size:32px; padding-left:300px;'>" . $name . " " . $gendar . $title . "</p>";
    $html = $html . "<p style='position: absolute; right:100px; padding-top:50px; padding-right:100px;'>" . $cust_no . "</p>";
    $html = $html . "<pagebreak>";

    // echo mb_substr($name,0,1,"UTF-8");


    // print($name);

    // $unicodeHtml = base_convert(bin2hex(iconv("utf-8", "ucs-2", $row[1])), 16, 10); 
    // print "&#" . $unicodeHtml . ";";
    // print '#' . $unicodeHtml;

    // print "&#21488;";
    
    // echo '</p>';
}


// echo $html;

//==============================================================
//==============================================================
//==============================================================

// SELECT count(*) FROM customer WHERE print = 'Y' AND zip <> 111 AND zip <> 112 AND zip > 103 AND zip <> 241 AND zip <> 247 AND zip <> 251 ORDER BY zip

// include("./mpdf60/mpdf.php");

// // $mpdf=new mPDF('-aCJK','A4','','',32,25,27,25,16,13); 
// $mpdf=new mPDF(); 
// $mpdf->SetDisplayMode('fullpage');

// // LOAD a stylesheet
// $stylesheet = file_get_contents('mpdfstyleA4.css');
// $mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

// $mpdf->autoLangToFont = true;

// $mpdf->WriteHTML($query);

// $mpdf->WriteHTML('<pagebreak sheet-size="238mm 126mm" />');

// $mpdf->WriteHTML($html);

// $mpdf->Output();
// exit;
//==============================================================
//==============================================================
//==============================================================


?>