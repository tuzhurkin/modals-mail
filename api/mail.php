<?php

$method = $_SERVER['REQUEST_METHOD'];

// Script Foreach
$c = true;
if( $method === 'POST' ) {
    
    $project_name = 'NAME SITE';
    $admin_email = 'sadnessandvodka@gmail.com';
    $form_subject = 'Заявка с сайта';

    $_POST = json_decode(file_get_contents('php://input'), true);
    
    foreach( $_POST as $key => $value ) {
        if( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
            $message .= "
                " . ( ($c = !$c) ? '<tr>':'<tr style="background-color=#f8f8f8;">' ) . "
                    <td style='padding: 8px; border: 1px solid #e9e9e9;'><b>$key</b></td>
                    <td style='padding: 8px; border: 1px solid #e9e9e9;'>$value</td>
                </tr>
            ";
        }
    }
}
else if( $method === 'GET' ) {
    $project_name = trim($_GET["project_name"]);
    $admin_email = trim($_GET["admin_email"]);
    $form_subject = trim($_GET["form_subject"]);

    foreach( $_GET as $key => $value ) {
        if( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
            $message .= "
                " . ( ($c = !$c) ? '<tr>':'<tr style="background-color=#f8f8f8;">' ) . "
                    <td style='padding: 8px; border: 1px solid #e9e9e9;'><b>$key</b></td>
                    <td style='padding: 8px; border: 1px solid #e9e9e9;'>$value</td>
                </tr>
            ";
        }
    }
}

$message = "<table style='width: 100%;'>$message</table>";

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($project_name).' <'.$window.'>' . PHP_EOL .
'Reply-To: '.$window.'' . PHP_EOL;


mail($admin_email, adopt($form_subject), $message, $headers);
