<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.stripe.com/v1/prices',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'currency=usd&unit_amount='.$_GET['price'].'&product=prod_SBV7HsrQ041w1d',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic c2tfdGVzdF9KYUl2UWt3dG5ueFBNNmlRdk5rNGQ1cE06',
    'Cookie: __stripe_orig_props=%7B%22referrer%22%3A%22%22%2C%22landing%22%3A%22https%3A%2F%2Fconnect.stripe.com%2Foauth%2Ftoken%22%7D; machine_identifier=0FXpLjSpMr3Bs9TLr4WamiG5Tqf9cAJsmDqVUU1RoxvF2tVtWz%2BbCOieS58gb1JcTuI%3D; private_machine_identifier=Ji0fuiTWsbsOhxrsLIHEbCHub%2Frs%2BPdVMil8Y7XzuWKnkvxsYnFSaFitD%2FA71zjqEzo%3D; stripe.csrf=OYTGzVGESkbclt9AI7irdF3kBIcHiaafHc0UxNjzMyP05QONoMxUg8qZi6ABtlQeYNhhCOkYbtikbXgDxXAKRzw-AYTZVJyjxoTKser7pzHxx1xCbwP-r0cykh3JTEYi9mho75XLUg%3D%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
