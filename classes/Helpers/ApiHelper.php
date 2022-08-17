<?php
namespace Helpers;

class ApiHelper
{
    private $output_arr = ['status' => false];
    private $storage;

    public function __construct() {
        $this->todo_storage = new Storage(BASE_DIR . 'todo.json');
    }

    public function add() {
        if (!$this->hasPostKey('task_message')) {
            $this->output_arr['message'] = 'something is not set';
            return $this;
        }

        $task_id = $this->todo_storage->add([
            'message' => $_POST['task_message'],
            'status' => false
        ]);

        $this->output_arr = [
            'status' => true,
            'id' => $task_id,
            'message' => 'task has been stored'
        ];

        return $this;
    }

    public function getAll() {
        $entries = $this->todo_storage->getAll();
        $this->output_arr = [
            'status' => true,
            'entries' => $entries,
            'message' => 'all entries where recived'
        ];
        return $this;
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            $this->output_arr = [
                'status' => false,
                'message' => 'uncorect method used for a request'
            ];
            return $this;
        }
        if (!$this->hasGetKey('id')) {
            $this->output_arr = [
                'status' => false,
                'message' => 'no id submited'
            ];
            return $this;
        }
        $id = $_GET['id'];

        if($this->todo_storage->delete($id)) {
            $this->output_arr = [
                'status' => true,
                'message' => 'task has been deleted'
            ];
        }
        else {
            $this->output_arr = [
                'status' => false,
                'message' => 'deletion failed'
            ];
        }

        return $this;
    }

    public function output() {
        echo json_encode($this->output_arr);
    }

    private function hasPostKey($key) {
        return (isset($_POST[$key]) && is_string($_POST[$key]));
    }
    private function hasGetKey($key) {
        return (isset($_GET[$key]) && is_string($_GET[$key]));
    }
}