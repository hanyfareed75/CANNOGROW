<?php
require_once __DIR__ . '/../models/agentsModel.php';
require_once __DIR__ . '/../models/areaModel.php';

class AgentController
{
  private $model;
  private $submodel;


  public function __construct()
  {
    $this->model = new AgentsModel();
    $this->submodel = new AreaModel();;
  }
  public function get()
  {


    $result = $this->model->get();

    $selecteditems = $this->submodel->getselected();


    require __DIR__ . '/../views/agent.php';
  }
  function getAPI()
  {

    return $this->model->get();
  }
  public function store($agent_name, $address, $mobile_1, $mobile_2, $notes)
  {
    try {
      if ($this->model->store($agent_name, $address, $mobile_1, $mobile_2, $notes)) {

        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      return $e;
    }
  }

  public function findById(int $id)
  {
    return $this->model->findById($id); /* return agent by ID */
  }

  //public function storeareas($agent_id, $area_id) { /* assign area */ }
  public function update(int $id, string $agent_name, string $address, string $mobile_1, string $mobile_2, string $notes): bool
  {
    return $this->model->update($id, $agent_name, $address, $mobile_1, $mobile_2, $notes);
  }

  public function delete(int $id): bool
  {
    return $this->model->delete($id);
  }
  //create function storeAreas 
  /**
   * Store agent areas
   * @param mixed $agent_id The agent ID
   * @param mixed $area_id The area ID
   * @return bool Returns true on success or false on failure
   * @throws TypeError If arguments are of wrong type
   */
  public function storeAreas($area_id, $agent_name): bool
  {
    // Convert to integers and validate
    // $agent_id = filter_var($agent_id, FILTER_VALIDATE_INT);
    // $area_id = filter_var($area_id, FILTER_VALIDATE_INT);

    // if ($agent_name === false || $area_id === false) {
    //     throw new TypeError('Agent ID and Area ID must be valid integers');
    // }

    return $this->model->storeAreas($area_id, $agent_name);
  }

  /**
   * Begin a new database transaction
   * @return bool Returns true on success or false on failure
   */
  public function beginTransaction(): bool
  {
    return $this->model->beginTransaction();
  }

  /**
   * Commit the current database transaction
   * @return bool Returns true on success or false on failure
   */
  public function commit(): bool
  {
    return $this->model->commit();
  }

  /**
   * Rollback the current database transaction
   * @return bool Returns true on success or false on failure
   */
  public function rollback(): bool
  {
    return $this->model->rollback();
  }
}
