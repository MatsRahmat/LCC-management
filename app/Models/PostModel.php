<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'created_by'];

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

    public function getPostWithAttachment()
    {
        $this->join('users', 'users.id = posts.created_by', 'left')
            ->select('posts.*, users.username as created_by_name')
            ->orderBy('id', 'DESC');
        $posts = $this->findAll();
        foreach ($posts as $index => $post) {
            $attachModel = new PostAttachmentModel();
            $attach = $attachModel->where('post_id', $post['id'])->findAll();

            $posts[$index]['attachments'] = $attach;
        }
        return $posts;
    }

    public function getPostWithAttachmentDetail($id)
    {
        $post = $this->find($id);

        $attachModel = new PostAttachmentModel();
        $attachment = $attachModel->where('post_id', $post['id'])->findAll();
        $post['attachments'] = $attachment;
        return $post;
    }
}
