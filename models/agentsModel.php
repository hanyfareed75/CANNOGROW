<?php

require_once __DIR__ . '/../config/database.php';

class AgentsModel 
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    /**
     * Get all agents ordered by ID descending
     * @return array
     * @throws PDOException
     */
    public function get(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM del_agents ORDER BY agent_id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Failed to fetch agents: " . $e->getMessage());
        }
    }

    /**
     * Store a new agent
     * @param string $agent_name
     * @param string $address 
     * @param string $mobile_1
     * @param string $mobile_2
     * @param string $notes
     * @return bool
     * @throws PDOException
     */
    public function store(string $agent_name, string $address, string $mobile_1, string $mobile_2, string $notes): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO del_agents (agent_name, address, mobile_1, mobile_2, notes) 
                VALUES (?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$agent_name, $address, $mobile_1, $mobile_2, $notes]);
        } catch (PDOException $e) {
            throw new PDOException("Failed to store agent: " . $e->getMessage());
        }
    }

    /**
     * Store agent areas
     * @param int $agent_id
     * @param string $agent_name
     * @return bool
     * @throws PDOException
     */
    //the agentid is updated from here 
    public function storeAreas(int $area_id, string $agent_name): bool 
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO del_agents_areas (agent_id, area_id, agent_name) 
                VALUES ((SELECT agent_id 
                FROM del_agents 
                WHERE agent_name = '${agent_name}' 
                ORDER BY agent_id DESC 
                LIMIT 1),?, ?)
            ");
            // $this->updateAgentAreas($agent_name);
            return $stmt->execute([$area_id, $agent_name]);
        } catch (PDOException $e) {
            throw new PDOException("Failed to store agent areas: " . $e->getMessage());
        }
    }

    /**
     * Find agent by ID
     * @param int $id
     * @return array|false
     * @throws PDOException
     */
    public function findById(int $id): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM del_agents WHERE agent_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Failed to find agent: " . $e->getMessage());
        }
    }

    /**
     * Update an existing agent
     * @param int $id
     * @param string $agent_name
     * @param string $address
     * @param string $mobile_1
     * @param string $mobile_2
     * @param string $notes
     * @return bool
     * @throws PDOException
     */
    public function update(int $id, string $agent_name, string $address, string $mobile_1, string $mobile_2, string $notes): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE del_agents 
                SET agent_name = ?, 
                    address = ?, 
                    mobile_1 = ?, 
                    mobile_2 = ?, 
                    notes = ?
                WHERE agent_id = ?
            ");
            return $stmt->execute([$agent_name, $address, $mobile_1, $mobile_2, $notes, $id]);
        } catch (PDOException $e) {
            throw new PDOException("Failed to update agent: " . $e->getMessage());
        }
    }

    /**
     * Delete an agent by ID
     * @param int $id
     * @return bool
     * @throws PDOException
     */
    public function delete(int $id): bool
    {
        try {
            // First delete related areas
            $stmt = $this->db->prepare("DELETE FROM del_agents_areas WHERE agent_id = ?");
            $stmt->execute([$id]);

            // Then delete the agent
            $stmt = $this->db->prepare("DELETE FROM del_agents WHERE agent_id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Failed to delete agent: " . $e->getMessage());
        }
    }

    /**
     * Begin a database transaction
     * @return bool
     * @throws PDOException
     */
    public function beginTransaction(): bool
    {
        try {
            return $this->db->beginTransaction();
        } catch (PDOException $e) {
            throw new PDOException("Failed to start transaction: " . $e->getMessage());
        }
    }

    /**
     * Commit the current transaction
     * @return bool
     * @throws PDOException
     */
    public function commit(): bool
    {
        try {
            return $this->db->commit();
        } catch (PDOException $e) {
            throw new PDOException("Failed to commit transaction: " . $e->getMessage());
        }
    }

    /**
     * Rollback the current transaction
     * @return bool
     * @throws PDOException
     */
    public function rollback(): bool
    {
        try {
            return $this->db->rollBack();
        } catch (PDOException $e) {
            throw new PDOException("Failed to rollback transaction: " . $e->getMessage());
        }
    }

    /**
     * Find agent by name and update areas table
     * @param string $agent_name
     * @return bool
     * @throws PDOException
     */
    public function updateAgentAreas(string $agent_name): bool 
    {
        try {
            // First find the agent_id by name
            $stmt = $this->db->prepare("
                SELECT agent_id 
                FROM del_agents 
                WHERE agent_name = ? 
                ORDER BY agent_id DESC 
                LIMIT 1
            ");
            $stmt->execute([$agent_name]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new PDOException("Agent not found: " . $agent_name);
            }

            $agent_id = (int)$result['agent_id'];

            // Update the del_agents_areas table
            $stmt = $this->db->prepare("
                UPDATE del_agents_areas 
                SET agent_id = ? 
                WHERE agent_name = ? 
                AND agent_id IS NULL
            ");
            
            return $stmt->execute([$agent_id, $agent_name]);

        } catch (PDOException $e) {
            throw new PDOException("Failed to update agent areas: " . $e->getMessage());
        }
    }
}