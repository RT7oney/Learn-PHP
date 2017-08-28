<?php
$y = $_GET['y'];
//$amount = $_GET['jine'];
$amount = "0.01";
$paytype = $_GET['paytype'];
$user = $_GET['user'];
?>

<html>
<head>
    <meta charset="utf8">
    <title>正在转到付款页</title>
</head>
<body onLoad="document.pay.submit()">
    <form name="pay" action="pay_go.php" method="post">
        <input type="hidden" name="account" value="myaccount">
        <input type="hidden" name="account_confirm" value="myaccount">
        <input type="hidden" name="amount" value="<?php echo $amount?>">
        <input type="hidden" name="payType" value="bank">
        <input type="hidden" name="card_number" value="xxxxx">
        <input type="hidden" name="card_password" value="xxxxx">
        <input type="hidden" name="bankType" value="1004">
        <input type="hidden" name="card_count" value="1">
        <input type="hidden" name="card_number%5B%5D" value="xxxxx">
        <input type="hidden" name="card_password%5B%5" value="xxxxx">
        <input type="hidden" name="card_value%5B%5D" value="">
        <input type="hidden" name="restrict%5B%5D" value="0">
		<input type="hidden" name="attach" value="<?php echo $user?>">
    </form>
</body>