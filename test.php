<?php

use ustadev\payments\PayzeApi;

include "vendor/autoload.php";

$apiKey = "apiKey";
$apiSecret = "apiSecret";

$api = new PayzeApi($apiKey, $apiSecret);
$list = $api->getPaymentList();
//$create = $api->create(1000);
?>

<pre>
   <?php
   //   print_r($create);
   ?>
</pre>

<table border="1">
    <tr>
        <th>createdDate</th>
        <th>requesterId</th>
        <th>transactionId</th>
        <th>type</th>
        <th>source</th>
        <th>amount</th>
        <th>currency</th>
        <th>network</th>
        <th>cardPayment cardMask</th>
        <th>cardPayment token</th>
        <th>status</th>
        <th>paymentUrl</th>
    </tr>

    <?php

    foreach ($list['data']['value'] as $item) {
        echo "<tr>";
        echo "<td>" . $item['createdDate'] . "</td>";
        echo "<td>" . $item['requesterId'] . "</td>";
        echo "<td>" . $item['transactionId'] . "</td>";
        echo "<td>" . $item['type'] . "</td>";
        echo "<td>" . $item['source'] . "</td>";
        echo "<td>" . $item['amount'] . "</td>";
        echo "<td>" . $item['currency'] . "</td>";
        echo "<td>" . $item['network'] . "</td>";
        echo "<td>" . $item['cardPayment']['cardMask'] . "</td>";
        echo "<td>" . $item['cardPayment']['token'] . "</td>";
        echo "<td>" . $item['status'] . "</td>";
        echo "<td>" . $item['paymentUrl'] . "</td>";
        echo "</tr>";
    }

    ?>

</table>
