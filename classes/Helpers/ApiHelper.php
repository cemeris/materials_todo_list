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

    public function output() {
        echo json_encode($this->output_arr);
    }

    private function hasPostKey($key) {
        return (isset($_POST[$key]) && is_string($_POST[$key]));
    }
}