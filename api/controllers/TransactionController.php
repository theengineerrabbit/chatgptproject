<?php
class TransactionController {
    private $file = __DIR__ . '/../data/transactions.json';

    private function read() {
        if (!file_exists($this->file)) return [];
        return json_decode(file_get_contents($this->file), true) ?: [];
    }

    private function write($data) {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function add($type) {
        $input = json_decode(file_get_contents('php://input'), true);
        $transactions = $this->read();
        $transactions[] = [
            'id' => uniqid(),
            'type' => $type, // expense or income
            'category' => $input['category'] ?? null,
            'account' => $input['account'] ?? null,
            'amount_eur' => (float)($input['amount_eur'] ?? 0),
            'target' => $input['target'] ?? 'none', // savings or investments
        ];
        $this->write($transactions);
        echo json_encode(['status' => 'ok']);
    }

    public function addExpense() {
        $this->add('expense');
    }

    public function addIncome() {
        $this->add('income');
    }

    public function summary() {
        $transactions = $this->read();
        $summary = ['income' => 0, 'expense' => 0, 'savings' => 0, 'investments' => 0];
        foreach ($transactions as $t) {
            if ($t['type'] === 'income') {
                $summary['income'] += $t['amount_eur'];
                if ($t['target'] === 'savings') $summary['savings'] += $t['amount_eur'];
                if ($t['target'] === 'investments') $summary['investments'] += $t['amount_eur'];
            } else {
                $summary['expense'] += $t['amount_eur'];
            }
        }
        echo json_encode($summary);
    }
}
