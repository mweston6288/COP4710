

<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
	case '/':
        require __DIR__ . '/samples/login.html';
        break;
    case '/admin' :
        require __DIR__ . '/samples/admin.html';
        break;
    case '/signup' :
        require __DIR__ . '/samples/signup.html';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/samples/professor.html';
        break;
}

?>
