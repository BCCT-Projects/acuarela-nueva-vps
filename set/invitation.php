<?php
     include '../includes/config.php';
     $array = array();
     extract($_POST);
     $response = $a->sendInvitationAdmin($name,$daycare,$licencia,$condado,$email,$phone);
     $array['message'] = 1;
     $array['response'] = $response;
     echo json_encode($array);

?>