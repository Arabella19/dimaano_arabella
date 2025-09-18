<?php
defined('PREVENT_DIRECT_ACCESS') OR exit ('No direct script access allowed');

class StudentsModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($first_name, $last_name, $email) {
        $data = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email
        ];
        return $this->db->table('students')->insert($data);
    }

    public function get_records_with_pagination($limit_clause)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primary_key} DESC {$limit_clause}";
        $result = $this->db->raw($sql);
        return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function searchStudents(string $keyword, int $page = 1, int $per_page = 10): array
    {
        $offset = ($page - 1) * $per_page;

        if (trim($keyword) !== '') {
            $kw = "%{$keyword}%";
            $sql = "SELECT id, first_name, last_name, email
                    FROM students
                    WHERE first_name LIKE ?
                       OR last_name LIKE ?
                       OR email LIKE ?
                    ORDER BY id DESC
                    LIMIT ?, ?";
            $stmt = $this->db->raw($sql, [$kw, $kw, $kw, $offset, $per_page]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT id, first_name, last_name, email
                    FROM students
                    ORDER BY id DESC
                    LIMIT ?, ?";
            $stmt = $this->db->raw($sql, [$offset, $per_page]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function count_filtered_records(string $keyword): int
    {
        if (trim($keyword) !== '') {
            $kw = "%{$keyword}%";
            $sql = "SELECT COUNT(*) as cnt
                    FROM students
                    WHERE first_name LIKE ?
                       OR last_name LIKE ?
                       OR email LIKE ?";
            $stmt = $this->db->raw($sql, [$kw, $kw, $kw]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($row['cnt'] ?? 0);
        } else {
            $sql = "SELECT COUNT(*) as cnt FROM students";
            $stmt = $this->db->raw($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($row['cnt'] ?? 0);
        }
    }
}
