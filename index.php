<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
	case '/':
        require __DIR__ . '/pages/login.html';
        break;
    case '/admin' :
        require __DIR__ . '/pages/admin.html';
        break;
    case '/signup' :
        require __DIR__ . '/pages/signup.html';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/professor.html';
        break;
}

?>
