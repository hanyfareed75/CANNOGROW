<?php
abstract class BaseController
{
    protected PDO $db;
    protected string $table;

    public function __construct(PDO $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function renderView(string $view): void
    {
       $results = $this->getAll();
        
        include __DIR__ . "/../views/{$view}.php";
    }
    public function getById($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $fields): bool
    {
        $columns = implode(", ", array_keys($fields));
        $placeholders = implode(", ", array_map(fn($f) => ":$f", array_keys($fields)));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute($fields);
    }

    public function update($id, array $fields): bool
    {
        $set = implode(", ", array_map(fn($f) => "$f = :$f", array_keys($fields)));
        $fields['id'] = $id;

        $stmt = $this->db->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
        return $stmt->execute($fields);
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}