<?php 

namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\AccountModel;
use alina\project\App\Request;
use alina\project\App\Response;
use alina\project\App\Session;

class AccountController extends Controller
{
    private $model;
    private $reguest;
    private $session;
    private $template_maker;

    public function __construct(){
        parent::__construct();
        session_start();
        $this->model = new AccountModel();
        $this->request = new Request();
        $this->session = new Session();
    }
    
    public function indexAction(){
        if ($this->session->is_session_var('login')) {
            $userdata = $this->model->get_userdata($this->session->get_session_var('login'));
            $view = 'account.twig';
            $title = 'Личная информация';
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'login'=>$this->session->get_session_var('login'),
                        'user' => $userdata
            ]));
        } else {
            header('Location: /');
            exit();
        }
    }

    public function authAction(){
        if (isset($_COOKIE['login'])){
           $this->session->set_session_var('login', $_COOKIE['login']);
        }
        if ($this->session->is_session_var('login')) {
            header('Location: /task');
            exit();
        } else {
            $post = $this->request->post();
            $auth_data = [
                'login'=>$post['login'],
                'password'=>$post['password'],
            ];
            if($post['remember']){
                setcookie('login', $data['login'], time() + 3600 * 24 * 180);
                setcookie('pwd', password_hash($data['password'], PASSWORD_DEFAULT), time()+3600 * 24 * 180);
            }
            $this->session->set_session_var('login', $auth_data['login'] );
            return new Response($this->model->auth_user($auth_data));
        }
    }

    public function registrationAction(){
        if (isset($_COOKIE['login'])) {
            $this->session->set_session_var('login', $_COOKIE['login']);
        }
        if ($this->session->is_session_var('login')) {
            return new Response('', [
                'Location'=>'/task'
            ]);
        } else {
            $post = $this->request->post();
            $reg_data = [
                'login'=>$post['login'],
                'hash'=>password_hash($post['password'], PASSWORD_DEFAULT),
                'email'=>$post['email'],
                'avatar'=>'avatar.jpg',
            ];
            return new Response($this->model->add_user($reg_data));
        }
    }

    public function logoutAction(){
        $this->session->remove_session_var('login');
        setcookie('login', '', time() - 1);
        setcookie('pwd', '', time() - 1);
        return new Response('', [
                'Location'=>'/'
            ]);
    }
}
?>
