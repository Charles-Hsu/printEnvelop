# printEnvelop

https://github.com/mpdf/mpdf

<pre>

// load csv to sublime
// first, save with encoding utf-8 with bom
// then, save with encoding utf-8
// done

sqlite3 6e20180413.db // 檔案名稱

// 建立 table schema
CREATE TABLE IF NOT EXISTS cust_old (cust_no, name, phone, birthday, address, print, comment, last_buy_date, gendar);
// 切換成 CSV 模式
.mode csv
// 匯入資料庫
.import 20180413.csv cust_old // 檔案名稱要改
-- .import customer20160216.csv cust_old

// 接下來將就的 cust_old 轉成新的 customer
// 建立新的 customer
CREATE TABLE IF NOT EXISTS customer (id PRIMARY KEY, cust_no, name, nickname, phone, mobile, birthday, zip, address, print, comment, last_buy_date, gendar);
// 將就的資料轉入新的資料表
INSERT INTO customer (id, cust_no, name, phone, birthday, address, print, comment, last_buy_date, gendar) 
    SELECT rowid, cust_no, name, phone, birthday, address, print, comment, last_buy_date, gendar FROM cust_old;

// 切換顯示欄位方式
.mode list

// 更新欄位
// UPDATE customer SET cust_no = '0' || cust_no; // 不曉得做什麼用? 忘記了 XD

// 篩選出郵遞區號
UPDATE customer SET zip = CAST(SUBSTR(TRIM(address),1,3) AS INTEGER);

// 如果 zip 為 0, 則清除 zip 欄位
UPDATE customer SET zip = '' WHERE zip = 0;

// 更新 address 欄位資料
// 刪除郵遞區號並且將空白清除
// 只留下縣市名稱
UPDATE customer SET address = TRIM(SUBSTR(TRIM(address),4)) WHERE LENGTH(zip) <> 0 AND CAST(SUBSTR(TRIM(address),4) AS INTEGER) = 0;

// 建立 zip 基本資料
CREATE TABLE IF NOT EXISTS zip (zip, city, area);
.mode csv
.import 103.12.25-zip.csv zip


// 如果地址當中有區的, 全數移除
update customer set address=replace(address,'中正區','');
update customer set address=replace(address,'大同區','');
update customer set address=replace(address,'中山區','');
update customer set address=replace(address,'松山區','');
update customer set address=replace(address,'大安區','');
update customer set address=replace(address,'萬華區','');
update customer set address=replace(address,'信義區','');
update customer set address=replace(address,'士林區','');
update customer set address=replace(address,'北投區','');
update customer set address=replace(address,'內湖區','');
update customer set address=replace(address,'南港區','');
update customer set address=replace(address,'文山區','');
UPDATE customer SET address=REPLACE(address,'萬里區','');
UPDATE customer SET address=REPLACE(address,'金山區','');
UPDATE customer SET address=REPLACE(address,'板橋區','');


UPDATE customer SET address=REPLACE(address,'坪林區','');
UPDATE customer SET address=REPLACE(address,'烏來區','');
UPDATE customer SET address=REPLACE(address,'永和區','');
UPDATE customer SET address=REPLACE(address,'中和區','');
UPDATE customer SET address=REPLACE(address,'土城區','');
UPDATE customer SET address=REPLACE(address,'三峽區','');
UPDATE customer SET address=REPLACE(address,'樹林區','');
UPDATE customer SET address=REPLACE(address,'鶯歌區','');
UPDATE customer SET address=REPLACE(address,'三重區','');
UPDATE customer SET address=REPLACE(address,'新莊區','');
UPDATE customer SET address=REPLACE(address,'泰山區','');
UPDATE customer SET address=REPLACE(address,'林口區','');
UPDATE customer SET address=REPLACE(address,'蘆洲區','');
UPDATE customer SET address=REPLACE(address,'五股區','');
UPDATE customer SET address=REPLACE(address,'八里區','');
UPDATE customer SET address=REPLACE(address,'淡水區','');

UPDATE customer SET address=REPLACE(address,'三芝區','');
UPDATE customer SET address=REPLACE(address,'石門區','');
UPDATE customer SET address=REPLACE(address,'七堵區','');
UPDATE customer SET address=REPLACE(address,'安樂區','');
UPDATE customer SET address=REPLACE(address,'仁愛區','');
UPDATE customer SET address=REPLACE(address,'暖暖區','');

UPDATE customer SET address=REPLACE(address,'石碇區','');
UPDATE customer SET address=REPLACE(address,'深坑區','');
UPDATE customer SET address=REPLACE(address,'瑞芳區','');
UPDATE customer SET address=REPLACE(address,'雙溪區','');
UPDATE customer SET address=REPLACE(address,'貢寮區','');
UPDATE customer SET address=REPLACE(address,'平溪區','');
UPDATE customer SET address=REPLACE(address,'汐止區','');
UPDATE customer SET address=REPLACE(address,'新店區','');

// 修正地址的錯誤, 之幾以前用空白顯示, 列印信封會出問題
//update customer set address='台北市中山北路7段14巷38-2號1樓' where cust_no='00110';
//update customer set address='台北市葫蘆街132號-5之2樓' where cast(cust_no as decimal) = 443;
//update customer set address='台北市社子街98巷8號6樓-3之B棟' where cast(cust_no as decimal) = 475;
//update customer set address='北市延平北路6段116巷52-1號2樓' where cast(cust_no as decimal) = 516';
//update customer set address='台北市重慶北路4段49巷40弄42號-1' where cast(cust_no as decimal) = 539;
//update customer set address='台北市延平北路6段116巷29號-2之3樓' where cust_no='00944';
//update customer set address='北市社中街269-1號3樓' where cust_no='01499';
//update customer set address='台北市葫蘆街132-4號5樓' where cust_no='01608';
//update customer set address='台北市延平北路6段258巷56弄5號-1' where cust_no='01612';
//update customer set address='台北市重慶北路4段79號-1之2樓' where cust_no='02853';
//update customer set address='台北市忠誠路2段118巷16之2號2樓' where cust_no='06585';
//update customer set address='台北市社中街158之2號' where cust_no='06820';
//update customer set address='台北市通河西街2段107之1號2樓' where cust_no='06987';
//update customer set address='台北市葫蘆街47巷4之1號2樓' where cust_no='07069';
//update customer set address='台北市延平北路6段116巷29之2號4樓' where cust_no='08247';
//update customer set address='台北市社正路61之1號5樓' where cust_no='08591';
//update customer set address='台北市延平北路6段116巷54號-1' where cust_no='04641';
//update customer set address='台北市中山北路7段213號-6之10樓' where cust_no='04661';
//update customer set address='台北市社中街271號-1之3樓' where cust_no='04779';
//update customer set address='台北市社子街128號-1之5樓' where cust_no='04939';
//update customer set address='台北市承德路4段12巷26號-1之8樓' where cust_no='04993';
//update customer set address='台北市延平北路5段1巷36號-1之2樓' where cust_no='05180';
//update customer set address='台北市中正路707巷19號-1之3樓' where cust_no='05403';
//update customer set address='台北市克強路32號-1之3樓' where cust_no='05677';
//update customer set address='台北市中山北路7段14巷29-8號' where cust_no='05815';
//update customer set address='台北市中山北路7段81巷38之6號2樓' where cust_no='05999';
//update customer set address='台北市中正路707巷1之1號2樓' where cust_no='06181';
//update customer set address='台北市中正路707巷13之1號9樓' where cust_no='06352';

</pre>

修改 6e_example_CJK.php
修改資料庫名稱
啟動, 列印 100 到 200 的客戶信封指令如下：
 
http://localhost/6e_example_CJK.php?from=100&to=200
