<?php
namespace Helpers;

class Storage
{
    private $data = [
        'next_id' => 1,
        'entries' => []
    ];
    private $file_name;

    public function __construct($file_name) {
        $this->file_name = $file_name;
        if (file_exists($file_name)) {
            $content = file_get_contents($file_name);
            $data = json_decode($content, true);
            if (is_array($data)) {
                $this->data = $data;
            }
        }
    }

    public function add($entry) {
        $id = $this->data['next_id']++;
        $this->data['entries'][$id] = $entry;

        $content = json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($this->file_name, $content);

        return $id;
    }

    public function getAll() {
        return $this->data['entries'];
    }
}