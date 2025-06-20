<?php
namespace App\Models;

use PDO;

class SettingsModel extends SqlConnect
{
    public function getAll(): array {
        $stmt = $this->db->prepare("SELECT `key`, `value` FROM settings");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function update($key, $value): bool {
        $stmt = $this->db->prepare("UPDATE settings SET value = :value, updated_at = NOW() WHERE `key` = :key");
        return $stmt->execute([
            'key' => $key,
            'value' => $value
        ]);
    }
}