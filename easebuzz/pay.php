<?php

    include_once 'easepay-lib.php';

    $MERCHANT_KEY="Y5ABXC5GU2";
    $SALT='GX8VBY9WGF';
    // $ENV='test';  // uncomment it for test env.(testpay.easebuzz.in)
    $ENV='prod'; // uncomment it for production env.(pay.easebuzz.in)

    $posted = array();
    if(!empty($_POST)) {
      foreach($_POST as $key => $value) {
        $posted[$key] = htmlentities($value, ENT_QUOTES);
        $posted[$key] = trim($value);
      }
    }
    $formError = 0;
    if(sizeof($posted) > 0) {
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

        if(
              empty($posted['amount'])
              || empty($posted['firstname'])
              || empty($posted['email'])
              || empty($posted['phone'])
              || empty($posted['productinfo'])
              || empty($posted['surl'])
              || empty($posted['furl'])
        ) {
            $formError = 1;
        }



        easepay_page(array('key' => $MERCHANT_KEY,
        'txnid' => $txnid,
        'amount' => $posted['amount'],
        'firstname' => $posted['firstname'],
        'email' => $posted['email'],
        'phone' => $posted['phone'],
        'udf1' => $posted['udf1'],
        'udf2' => $posted['udf2'],
        'udf3' => $posted['udf3'],
        'udf4' => $posted['udf4'],
        'udf5' => $posted['udf5'],
        'productinfo' =>$posted['productinfo'],
        'surl' => $posted['surl'],
        'furl' => $posted['furl']), $SALT, $ENV);
    }
