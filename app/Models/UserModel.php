<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'phone', 'birth_date', 'nim', 'role_id', 'study_id', 'created_by'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getWithRoleAndProdi($id = null)
    {
        $builder = $this->select('users.id, users.username, users.email, users.phone, users.birth_date as "birth date", users.nim, users.created_at as "created at", r.name as role, CONCAT(ps.name, "-", ps.code) as "prodi"')
            ->join('roles r', 'users.role_id = r.id', 'left')
            ->join('program_studies ps', 'users.study_id = ps.id', 'left')
            ->orderBy('id', 'DESC');

        if (isset($id) && $id != null) {
            return $builder->where('users.id', $id);
        }
        return $builder;
    }
}
