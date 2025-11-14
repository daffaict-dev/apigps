<?php

class SensorModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function insert($lat, $lng, $volt) {
        $stmt = $this->db->prepare("INSERT INTO tablegps (latitude, longitude, voltage) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $lat, $lng, $volt);
        return $stmt->execute();
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM tablegps ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tablegps WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tablegps WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
