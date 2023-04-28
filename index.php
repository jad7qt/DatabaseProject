<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':                   // URL (without file name) to a default LOGIN screen
      require 'login.php';
      break; 
    case '/login.php':
      require 'login.php';
      break;
    case '/about.html':
        require 'about.html';
        break;
    case '/addCustomer.php':
        require 'addCustomer.php';
        break;
    case '/addTechnician.php':
        require 'addTechnician.php';
        break;
    case '/contact.php':
        require 'contact.php';
        break;
    case '/homepage.php':   
        require 'homepage.php';
        break;
    case '/logout.php':
        require 'logout.php';
        break;
    case '/payments.php':
        require 'payments.php';
        break;
    case '/searchResults.php':
        require 'searchResults.php';
        break;
    case '/services.html':
        require 'services.html';
        break;
   default:
      http_response_code(404);
      exit('Not Found');
}  
?>