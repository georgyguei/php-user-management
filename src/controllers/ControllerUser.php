<?php

require_once ROOT_DIR . "/models/UserManager.php";
require_once ROOT_DIR ."/views/View.php";

class ControllerUser
{
    private $_manager;
    private $_view;
    private $_returnData;

    public function __construct($url)
    {
        $this->_manager = new UserManager();
        $this->_view = new View();

        $method = $_SERVER['REQUEST_METHOD'];

        try {
            switch ($method) {
                case 'POST':
                    $this->handlePost();
                    break;
                case 'GET':
                    $this->handleGet();
                    break;
                case 'DELETE':
                    var_dump($url);

                    $this->handleDelete();
                    break;
                case 'PUT':
                    $this->handlePut();
                    break;
                default:
                    throw new \Exception("Invalid request method.", 405);
            }
            $this->_view->generate($this->_returnData);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    private function handlePost()
    {
        if (isset($_POST['name'], $_POST['email'])) {
            $this->_manager->addUser($_POST['name'], $_POST['email']);
            $this->_returnData = [
                "success" => true,
                "status" => 201,
                "message" => "User added successfully"
            ];
        } else {
            throw new \Exception("Invalid POST request.", 400);
        }
    }

    private function handleGet()
    {
        $users = $this->_manager->getUsers();
        $this->_returnData = [
            "success" => true,
            "status" => 200,
            "users" => $users
        ];
    }

    private function handleDelete()
    {
        if (isset($_GET['id'])) {
            $this->_manager->removeUser($_GET['id']);
            $this->_returnData = [
                "success" => true,
                "status" => 200,
                "message" => "User deleted successfully"
            ];
        } else {
            throw new \Exception("Invalid DELETE request.", 400);
        }
    }

    private function handlePut()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT['id'], $_PUT['name'], $_PUT['email'])) {
            $this->_manager->updateUser($_PUT['id'], $_PUT['name'], $_PUT['email']);
            $this->_returnData = [
                "success" => true,
                "status" => 200,
                "message" => "User updated successfully"
            ];
        } else {
            throw new \Exception("Invalid PUT request.", 400);
        }
    }
}