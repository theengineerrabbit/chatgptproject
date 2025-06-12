<?php
class CategoryController {
    private $file = __DIR__ . '/../data/categories.json';

    private function read() {
        if (!file_exists($this->file)) return [];
        return json_decode(file_get_contents($this->file), true) ?: [];
    }

    private function write($data) {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function addCategory() {
        $input = json_decode(file_get_contents('php://input'), true);
        $categories = $this->read();
        $categories[] = [
            'id' => uniqid(),
            'name' => $input['name'] ?? 'General',
        ];
        $this->write($categories);
        echo json_encode(['status' => 'ok']);
    }

    public function listCategories() {
        echo json_encode($this->read());
    }
}
