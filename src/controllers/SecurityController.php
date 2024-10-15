<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../repositories/UserRepository.php';

class SecurityController extends AppController {

    private $userRepository2;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {   
        session_start();

        if (!$this->isPost() && ($_SESSION['role'] !== User::Guest)) {
            header("Location: /maps");
            exit;
        }   

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found.']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User not exist.']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password.']]);
        }

        $this->userRepository->createSession($user);
 
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/maps");
    }


    public function register()
    {
        session_start();

        if (!$this->isPost() && ($_SESSION['role'] !== User::Guest)) {
            header("Location: /maps");
            exit;
        }   

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];
        
        if (!is_null($this->userRepository->getUser($email))) {
            return $this->render('register', ['messages' => ['Account exists!']]);
        }
        
        $user = new User($email, md5($password), $nickname);
        $this->userRepository->addUser($user);

        return $this->render('login');
    }

    public function password()
    {
        if (!$this->isPost()) {
            return $this->render('password');
        }

        $email = $_POST['email'];
        $new_password = $_POST['new-password'];
        $repeated_password = $_POST['repeated-password'];

        if ($new_password !== $repeated_password) {
            return $this->render('password', ['messages' => ['Passwords not match!']]); 
        }

        $user = $this->userRepository->getUser($email);
        $this->userRepository->changePassword($user, md5($new_password));
        
        return $this->render('login');
    }


    public function password2()
    {

        if (!$this->isPost()) {
            return $this->render('password2');
        }

        $new_password = $_POST['new-password'];
        $repeated_password = $_POST['repeated-password'];

        if ($new_password !== $repeated_password) {
            return $this->render('password2', ['messages' => ['Passwords not match!']]); 
        }

        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return $this->render('password2', ['messages' => ['Could not change the password!']]);
        }

        $email = $_SESSION['email'];

        $user = $this->userRepository->getUser($email);
        $this->userRepository->changePassword($user, md5($new_password));
        
        return $this->render('login');
    }


    public function logout() {
        
        session_unset();
        session_destroy();
    
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}");
    }


    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (isset($_SESSION['email'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/maps");
            exit();
        }
    
        $user = $this->userRepository->getUser('guest@guest.pl');
        $this->userRepository->createSession($user);
    
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/maps");
        exit();
    }

}