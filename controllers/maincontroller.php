<?php
class MainController
{
  public $helper;
  public $userModel;
  public function __construct(){
    $this->helper = new Helper();
    $this->userModel = new User();
  }
  public function actionIndex(){
    if ($_SERVER['REQUEST_URI'] != REQUEST_URI_EXIST) {
      header("Location: " . FULL_SITE_ROOT . "/report/noexist");
      die();
    }
    if (isset($_COOKIE['uid'])) {
      header("Location: news");
    }
    $title = SERVER_NAME;
    $styles = [CSS . '/home.css'];
    $scripts = [JS . '/slider.js', JS . '/home.js'];
    require_once './views/common/head.html';
    require_once  './views/home.html';
    require_once './views/common/foot.html';
  }

  public function actionReport($data){
         $incident = $data[0];
         $title = $incident;
         $styles = [CSS . '/report.css'];
         $back = FULL_SITE_ROOT;
         if (isset($_SERVER['HTTP_REFERER'])) {
           $back = $_SERVER['HTTP_REFERER'];
         }
         $boolUser = false;
         if ($this->userModel->isAuth()) {
           $boolUser = true;
         }
         require_once   './views/common/head.html';
         require_once   './views/common/header.html';
         require_once  './views/common/nav.php';
         require_once  './views/report.html';
         $this->helper->outputCommonFoot();
  }
  public function actionPrivacy(){
    $title = 'Политика сайта';
    $styles = [CSS . '/privacy.css'];
    $scripts = [JS . '/privacy.js'];
    require_once   './views/common/head.html';
    require_once   './views/common/header.html';
    require_once  './views/common/nav.php';
    require_once  './views/privacy.html';
    $this->helper->outputCommonFoot($scripts);
  }

  public function actionSearch(){
    if (!isset($_POST['search'])) {
      header("Location: " . FULL_SITE_ROOT . "/report/noexist");
      die();
    }
    if (trim($_POST['search']) == '') {
      $title = 'Пустой поисковой запрос :()';
    } else {
      $title = $_POST['search'];
      $search = $_POST['search'];
      $testModel = new Test();
      $data = $testModel->searchTest($search);
    }
    $title = $_POST['search'];
    $styles = [CSS . '/search.css'];
    require_once   './views/common/head.html';
    require_once   './views/common/header.html';
    require_once  './views/common/nav.php';
    require_once  './views/search.html';
    $this->helper->outputCommonFoot();
  }
}
