<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [];

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

    private string $usersFile = WRITEPATH . 'users.json';

    /**
     * @param $username
     * @param $password
     * @return array|null
     */
    public function getUserByCredential($username): ?array
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            if ($user['username'] == $username) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    private function getUsers(): array
    {
        return json_decode(file_get_contents($this->usersFile), true);
    }
}
