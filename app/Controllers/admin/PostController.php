<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Enums\StateEnum;
use App\Models\PostAttachmentModel;
use App\Models\PostModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Services;
use Config\Session;

use function PHPSTORM_META\map;

class PostController extends BaseController
{
    protected $page = ['title' => 'Post', 'path' => ['Admin', 'Post'], 'page_path' => 'a/admin/posts'];
    protected PostModel $model;
    protected PostAttachmentModel $attchModel;
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->model = new PostModel();
        $this->attchModel = new PostAttachmentModel();
        $this->db = Database::connect();
        $this->session = Services::session();

        // $config['upload_path'] = './uploads/';
        // $config['allowed_types'] = 'gif|jpg|png';
        // $config['max_size'] = 2048; // Adjust as needed
        // $config['encrypt_name'] = TRUE;
        // $this->load->library('upload', $config);
    }
    public function index()
    {
        $posts = $this->model->getPostWithAttachment();
        $data = [
            'page' => $this->page,
            'posts' => $posts,
            'total_post' => $this->model->countAllResults()
        ];
        return view('pages/posts/admin_post_view', $data);
    }
    public function add()
    {
        $data = [
            'page' => $this->page
        ];
        return view('pages/posts/add_post_view', $data);
    }
    public function insert()
    {
        $this->db->transBegin();
        $validation = \Config\Services::validation();
        $session = \Config\Services::session();
        $errors = [];
        try {
            $validation->setRules([
                'title' => [
                    'label' => 'Judul',
                    'rules' => 'required|max_length[255]',
                ],
            ]);

            if (! $validation->withRequest($this->request)->run()) {
                $listErrs = $validation->getErrors();
                foreach ($listErrs as $err) {
                    $errors['title'] = $err;
                }
            }

            $dataToInsert = [
                'title' => $this->request->getPost('title'),
                'created_by' => $session->get('id')
            ];

            $idPost = $this->model->insert($dataToInsert, true);


            $dataPostAttachmets = [];

            $files = $this->request->getFiles();
            $uploaded_file = [];

            // dd($files);
            foreach ($files['attachments'] as $file) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $validation->setRules([
                        'attachments' => [
                            'uploaded[attachments]',
                            'is_image[attachments]',
                            'ext_in[attachments,jpg,png,jpeg,gif]',
                            'mime_in[attachments,image/jpg,image/png,image/gif,image/jpeg]',
                            'max_size[attachments,10240]' // 10MB 
                        ]
                    ]);

                    if (! $validation->withRequest($this->request)->run()) {
                        $errors['attachments'] = [$validation->getErrors()];
                    } else {
                        $randomName = $file->getRandomName();

                        $file->store('posts', $randomName);

                        $dataPostAttachmets[] = [
                            'filename' => $randomName,
                            'original_name' => $file->getName(),
                            'size' => $file->getSize(),
                            'url' => base_url('posts/') . $randomName,
                            'post_id' => $idPost
                        ];
                    }
                } else {
                    if (isset($errors['attachments'])) {
                        $errors['attachments'] = [];
                    }
                    $errors['attachments'][] = $file->getErrorString();
                }
            }

            if (!empty($errors) && is_array($errors) && count($errors) > 0) {
                $this->db->transRollback();
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $errors);
            }

            $this->attchModel->insertBatch($dataPostAttachmets);
            $this->db->transCommit();
            return redirect()->to('a/admin/posts')->with(StateEnum::SUCCESS, 'Postingan berhasil di tambah');
        } catch (\Throwable $th) {
            //throw $th;
            $this->db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function edit($id)
    {
        $data = [
            'page' => $this->page,
            'post' => $this->model->getPostWithAttachmentDetail($id)
        ];
        return view('pages/posts/edit_post_view', $data);
    }
    public function update($id)
    {
        $this->db->transBegin();
        $validation = \Config\Services::validation();
        $session = \Config\Services::session();
        $errors = [];
        try {
            $validation->setRules([
                'title' => [
                    'label' => 'Judul',
                    'rules' => 'required|max_length[255]',
                ],
            ]);

            if (! $validation->withRequest($this->request)->run()) {
                $listErrs = $validation->getErrors();
                foreach ($listErrs as $err) {
                    $errors['title'] = $err;
                }
            }

            $dataToInsert = [
                'title' => $this->request->getPost('title'),
                'created_by' => $session->get('id')
            ];

            $this->model->update($id, $dataToInsert);

            $dataPostAttachmets = [];

            $files = $this->request->getFiles();
            $uploaded_file = [];

            // dd($files);
            $existingAttachment = $this->attchModel->where('post_id', $id)->findAll();
            if (isset($files['attachments']) && count($files['attachments']) > 0) {
                foreach ($files['attachments'] as $file) {
                    if ($file->isValid() && ! $file->hasMoved()) {
                        $validation->setRules([
                            'attachments' => [
                                // 'uploaded[attachments]',
                                'is_image[attachments]',
                                'ext_in[attachments,jpg,png,jpeg,gif]',
                                'mime_in[attachments,image/jpg,image/png,image/gif,image/jpeg]',
                                'max_size[attachments,10240]' // 10MB 
                            ]
                        ]);

                        if (! $validation->withRequest($this->request)->run()) {
                            $errors['attachments'] = [$validation->getErrors()];
                        } else {
                            $randomName = $file->getRandomName();

                            $file->store('posts', $randomName);

                            $dataPostAttachmets[] = [
                                'filename' => $randomName,
                                'original_name' => $file->getName(),
                                'size' => $file->getSize(),
                                'url' => base_url('posts/') . $randomName,
                                'post_id' => $id
                            ];
                        }

                        //* Unlink the existing file
                        foreach ($existingAttachment as $exsFile) {
                            $path = WRITEPATH . 'uploads/posts/' . $exsFile['filename'];
                            $this->attchModel->where('post_id', $id)->delete();
                            unlink($path);
                        }
                    } else {
                        // asume that file is no change
                    }
                }
            }

            if (!empty($errors) && is_array($errors) && count($errors) > 0) {
                $this->db->transRollback();
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $errors);
            }

            if (count($dataPostAttachmets) > 0) {
                $this->attchModel->insertBatch($dataPostAttachmets);
            }
            $this->db->transCommit();
            return redirect()->to('a/admin/posts')->with(StateEnum::SUCCESS, 'Postingan berhasil di tambah');
        } catch (\Throwable $th) {
            //throw $th;
            $this->db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function delete($id)
    {
        $this->db->transBegin();
        try {
            $attachs = $this->attchModel->where('post_id')->findAll();
            foreach ($attachs as $file) {
                $path = WRITEPATH . '/uploads/posts/' . $file['filename'];
                unlink($path);
            }
            $this->attchModel->where('post_id', $id)->delete();
            $this->model->delete($id);
            $this->db->transCommit();
            return redirect()->back()->with(StateEnum::SUCCESS, 'Berhasil menghapus post');
        } catch (DataException $e) {
            $this->db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $this->db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
}


// <?php namespace App\Controllers;

// use CodeIgniter\Controller;
// use App\Models\AttachmentModel;

// class PostController extends Controller {
//     public function upload_files() {
//         // Set validation rules
//         $validationRule = [
//             'attachments' => [
//                 'label' => 'Attachments',
//                 'rules' => [
//                     'uploaded[attachments.*]',
//                     'mime_in[attachments.*,image/jpg,image/jpeg,image/png,image/gif]',
//                     'max_size[attachments.*,2048]',
//                     'ext_in[attachments.*,jpg,jpeg,png,gif]',
//                 ],
//             ],
//             'description' => [
//                 'label' => 'Description',
//                 'rules' => 'required|max_length[255]'
//             ],
//         ];

//         if (!$this->validate($validationRule)) {
//             // Validation failed
//             $errors = $this->validator->getErrors();
//             return redirect()->back()->withInput()->with('errors', $errors);
//         }

//         $attachmentModel = new AttachmentModel();
//         $files = $this->request->getFiles();
//         $description = $this->request->getPost('description');
//         $postId = $this->request->getPost('post_id'); // Ensure this is included in your form

//         if ($files && isset($files['attachments'])) {
//             foreach ($files['attachments'] as $file) {
//                 if ($file->isValid() && !$file->hasMoved()) {
//                     $newName = $file->getRandomName();
//                     $file->move(WRITEPATH . 'uploads', $newName);
                    
//                     $attachmentData = [
//                         'post_id' => $postId,
//                         'filename' => $newName,
//                         'size' => $file->getSizeByUnit('kb'),
//                         'created_by' => user()->id,
//                         'description' => $description, // Add the description field
//                     ];

//                     $attachmentModel->insert($attachmentData);
//                 }
//             }
//         }

//         return redirect()->to('/path/to/redirect');
//     }
// }
