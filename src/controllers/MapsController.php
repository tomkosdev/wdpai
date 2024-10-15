<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Map.php';
require_once __DIR__ .'/../repositories/MapRepository.php';

class MapsController extends AppController {

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    const UPLOAD_DIRECTORY2 = '/../public/uploads2/';

    private $message = [];
    private $mapRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mapRepository = new MapRepository();
    }


    public function add_map()
    {   
        if ($this->isPost() && 
            is_uploaded_file($_FILES['image']['tmp_name']) && 
            is_uploaded_file($_FILES['map']['tmp_name']) && 
            $this->validate($_FILES['image']) //&& 
            //$this->validate($_FILES['map'], ['.pk3'])
        ) {
            move_uploaded_file(
                $_FILES['image']['tmp_name'], 
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['image']['name']
            );
    
            move_uploaded_file(
                $_FILES['map']['tmp_name'], 
                dirname(__DIR__).self::UPLOAD_DIRECTORY2.$_FILES['map']['name']
            );
    
            $map = new Map($_POST['title'], $_POST['date'], $_POST['description'], $_FILES['image']['name'], $_FILES['map']['name']);
    
            $this->mapRepository->addMap($map);
    
            return $this->maps();
        }
    
        return $this->render('add_map', ['messages' => $this->message]);
    }


    public function download()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $map_name = basename($_POST['map_name']);  
            $file = './public/uploads2/' . $map_name;

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            } else {
                $this->message[] = 'File not found.';
            }
        } else {
            $this->message[] = 'Invalid request method.';

        }

        return $this->render('map_info', ['messages' => $this->message]);
    }



    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->mapRepository->getMapByTitle($decoded['search']));
        }
    }

    public function maps()
    {
        $maps = $this->mapRepository->getMaps();
        return $this->render('maps', ['maps' => $maps]);
    }

    public function liked_maps()
    {
        $maps = $this->mapRepository->getFavourite($_SESSION['email']);
        return $this->render('maps', ['maps' => $maps]);
    }


    public function map_info() {


        $id = $_GET["id"];
        $map = $this->mapRepository->getMap($id);
        $is_liked = $this->mapRepository->isFavourite($id);

        if (!$map) {
            return $this->render('error404');
        }
    
        return $this->render('map_info', ['map' => $map, 'is_liked' => $is_liked['is_map_liked']]);
    }

    public function like_map()
    {
        $id_map = $_GET["id"];
        $id_user = $_SESSION["id"];

        if ($_SESSION['role'] !== User::Guest) {

            $map = $this->mapRepository->getMap($id_map);
            $likes = $map->getLiked();

            $this->mapRepository->likeMap($id_map, $id_user);
        }

        $id = $_GET["id"];
        $map = $this->mapRepository->getMap($id);
        $is_liked = $this->mapRepository->isFavourite($id);

        if (!$map) {
            return $this->render('error404');
        }
        return $this->render('map_info', ['map' => $map, 'is_liked' => $is_liked['is_map_liked']]);
    }


    public function remove_like()
    {
        $id_map = $_GET["id"];
        $id_user = $_SESSION["id"];

        if ($_SESSION['role'] !== User::Guest) {
            $this->mapRepository->removeLike($id_map, $id_user);
        }


        $id = $_GET["id"];
        $map = $this->mapRepository->getMap($id);
        $is_liked = $this->mapRepository->isFavourite($id);

        if (!$map) {
            return $this->render('error404');
        }
        return $this->render('map_info', ['map' => $map, 'is_liked' => $is_liked['is_map_liked']]);
    }


    public function remove_map() 
    {
        $id = $_GET["id"];

        if (!$this->mapRepository->getMap($id)) {
            return $this->render('error404');
        }

        if ($_SESSION['role'] === User::Admin) {
            $this->mapRepository->removeMap($id);
        }

        return $this->maps();
    }



    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large!';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported!';
            return false;
        }
        return true;
    }
}