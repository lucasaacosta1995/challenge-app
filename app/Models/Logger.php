<?php

namespace App\Models;

use CodeIgniter\Model;

class Logger extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['title', 'price', 'created_at', 'modified_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected string $jsonFilePath = WRITEPATH . 'logger.json';


    //esta funcion podriamos pasarla a una clase en la cual extiendan todas de este tipo para reutilizar codigo
    public function loadLogs()
    {
        $logs = [];

        if (file_exists($this->jsonFilePath) & !empty(file_get_contents($this->jsonFilePath))) {
            $logs =  json_decode(file_get_contents($this->jsonFilePath), true);
        }

        return $logs;
    }
    /**
     * @param $data
     * @return void
     */
    public function createLog($data)
    {
        $logs = $this->loadLogs();
        $logs = array_merge($logs, $data);
        $this->updateFileJson($logs);
    }

    /**
     * @param $data
     * @return void
     */
    private function updateFileJson($data)
    {
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->jsonFilePath, $jsonString);
    }

}
