<?php

function pre($s) {
    echo '<pre>';
    print_r($s);
    echo '</pre>';
}

function redirect($url, $permanent = false) {
    header('Location: ' . $url, true, $permanent ? 301 : 302);
}

function flash($type, $message, $title = '', $session = false) {
    $type == 'success' ? 'success' : 'error';
    
    if ($session) {
        $_SESSION['flashMsg'] = [
            'type' => $type,
            'message' => $message,
            'title' => $title
        ];
    } else {
        echo '<div id="flash-msg" class="' . $type . '"><p><strong>' . $title . '</strong>: ' . $message . ' <span>&times;</span></p></div>';
    }
}

function camelCase($str) {
    $explode = explode('-', $str);
    $camel = '';

    foreach ($explode as $s) {
        $camel .= strtoupper($s[0]) . substr($s, 1, strlen($s));
    }

    return $camel;
}