<?php
class AccountController {
    private $file = __DIR__ . '/../data/accounts.json';

    private function read() {
        if (!file_exists($this->file)) return [];
        return json_decode(file_get_contents($this->file), true) ?: [];
    }

    private function write($data) {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function addAccount() {
        $input = json_decode(file_get_contents('php://input'), true);
        $accounts = $this->read();
        $accounts[] = [
            'id' => uniqid(),
            'name' => $input['name'] ?? 'Unnamed',
        ];
        $this->write($accounts);
        echo json_encode(['status' => 'ok']);
    }

    public function listAccounts() {
        echo json_encode($this->read());
    }
}
