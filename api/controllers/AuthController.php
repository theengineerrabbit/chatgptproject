<?php
class AuthController {
    private $userFile = __DIR__ . '/../data/users.json';

    private function readUsers() {
        if (!file_exists($this->userFile)) return [];
        $data = json_decode(file_get_contents($this->userFile), true);
        return $data ?: [];
    }

    private function writeUsers($users) {
        file_put_contents($this->userFile, json_encode($users, JSON_PRETTY_PRINT));
    }

    public function login() {
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';
        $users = $this->readUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $token = bin2hex(random_bytes(16));
                $user['token'] = $token;
                $this->writeUsers([$user]);
                echo json_encode(['token' => $token]);
                return;
            }
        }
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
    }
}
