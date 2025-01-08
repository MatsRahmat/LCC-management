<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Enums\RoleEnum;
use App\Enums\StateEnum;
use App\Helpers\FileHelper;
use App\Helpers\PaginationData;
use App\Models\PaymentAttachmentModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class PaymentAttachmentController extends BaseController
{
    protected $pages =  ['title' => 'Bukti Pembayaran', 'path' => ['Admin', 'Bukti Pembayaran'], 'page_path' => 'a/admin/payment-attachments'];
    protected PaymentAttachmentModel $model;

    public function __construct()
    {
        $this->model = new PaymentAttachmentModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $page = $this->request->getVar('page') ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $builder = $db->table('payment_attachments pa');
        $builder->select('pa.*, u.username as created_by');
        $builder->join('users u', 'pa.created_by = u.id', 'left');
        $builder->orderBy('id', 'DESC');
        $query = $builder->get($limit, $offset);
        //* Set condition to find only the available data
        $builder->where('deleted_at', null);
        $data = [
            'page'          => $this->pages,
            'data'          => $query->getResultArray(),
            'pagination'    => PaginationData::generate($builder, $limit, $page)
        ];
        return view('pages/payment_attachment/payment_attachment_view', $data);
    }

    public function add()
    {
        $data = [
            'page' => $this->pages,
        ];

        $role = (int) \Config\Services::session()->get('role');
        if (RoleEnum::isAdminRole($role)) {
            return view('pages/payment_attachment/add_payment_attachment_admin_view', $data);
        } else {
            return view('pages/payment_attachment/add_payment_attachment_user_view', $data);
        }
    }
    public function insert()
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $db->transBegin();
        try {
            // dd($this->request);
            $validation = \Config\Services::validation();
            $validation->setRules([
                'attachment' => [
                    'label' => 'Bukti Transfer',
                    'rules' => [
                        'uploaded[attachment]',
                        'is_image[attachment]',
                        // 'mime_in[attachment,image/jpeg,image/jpg,image/png]',
                        'ext_in[attachment,png,jpeg,jpg]',
                        'max_size[attachment,5120]',
                    ],
                    // 'rules' => 'uploaded[attachment]|is_image[attachment]'
                ],
                'desc' => 'required|max_length[255]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $validation->getErrors());
            }

            $dataToInsert = [
                'desc'          => $this->request->getPost('desc'),
                'created_by'    => (int) $session->get('id')
            ];
            // dd($this->request);
            $attch = $this->request->getFile('attachment');

            if (! $attch->hasMoved() && $attch->isValid()) {
                $originalName = $attch->getName();
                $storedName = $attch->getRandomName();
                $size = $attch->getSize();
                $attch->store('storage', $storedName);

                $dataToInsert['filename'] = $storedName;
                $dataToInsert['original_name'] = $originalName;
                $dataToInsert['size'] = $size;
                $dataToInsert['url'] = base_url('storage/') . $storedName;

                $this->model->insert($dataToInsert, true);
                $db->transCommit();

                $role = (int)$session->get('role');
                if (RoleEnum::isAdminRole($role)) {
                    return redirect()->to(base_url($this->pages['page_path']));
                } else {
                    //TODO Redirect dipending on role, if admin redirect back to admin page, else if user, redirect to user page

                }
            }
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, 'Invalid File');
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function edit($id)
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        try {
            $dataFind = $this->model->find($id);
            $dataFind['size_formated'] = FileHelper::calculateSize($dataFind['size']);
            $data = [
                'attach' => $dataFind,
                'page' =>  $this->pages
            ];

            //* Redirect dipending role
            $role = (int)$session->get('role');
            if (RoleEnum::isAdminRole($role)) {
                return view('pages/payment_attachment/edit_payment_attachment_admin_view', $data);
            } else {
                return view('pages/payment_attachment/edit_payment_attachment_user_view', $data);
            }
        } catch (DataException $e) {
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function update($id)
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $db->transBegin();
        try {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'desc' => [
                    'label' => 'Description',
                    'rules' => 'required|max_length[255]'
                ],
                'attachment' => [
                    'label'     => 'Bukti Pembayaran',
                    'rules'     => [
                        'uploaded[attachment]',
                        'is_image[attachment]',
                        'ext_in[attachment,jpeg,png,jpg]',
                        'max_size[attachment,5120]'
                    ]
                ]
            ]);
            if (! $validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $validation->getErrors());
            }

            $dataToInsert = [
                'desc'  => $this->request->getPost('desc')
            ];

            $attach = $this->request->getFile('attachment');
            if (isset($attach) && $attach->isValid() && ! $attach->hasMoved()) {

                //* Get existing data
                $existingData = $this->model->find($id);
                //* Write path to the file
                $pathToFile = WRITEPATH . '/uploads/storage/' . $existingData['filename'];
                //* Delete the exising file
                unlink($pathToFile);

                $size = $attach->getSize();
                $originalName = $attach->getName();
                //* Move the new file with the same filename
                $attach->store('storage', $existingData['filename']);

                $dataToInsert['filename'] = $existingData['filename'];
                $dataToInsert['original_name'] = $originalName;
                $dataToInsert['size'] = $size;
                $dataToInsert['url'] = base_url('storage/') . $existingData['filename'];
            }

            $this->model->update($id, $dataToInsert);
            $db->transCommit();
            $role = (int)$session->get('role');
            if (RoleEnum::isAdminRole($role)) {
                return redirect()->to(base_url($this->pages['page_path']));
            } else {
                //TODO: Redirect to user page
                // return redirect()->to();
            }
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $e->getMessage());
        } catch (Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $db->transBegin();
        try {
            $existingData = $this->model->find($id);

            $pathFile = WRITEPATH . '/uploads/storage/' . $existingData['filename'];
            unlink($pathFile);

            $this->model->delete($id);
            $db->transCommit();

            $role = (int)$session->get('role');
            if (RoleEnum::isAdminRole($role)) {
                return redirect()->to(base_url($this->pages['page_path']));
            } else {
                //TODO: Redirect to user page
                // return redirect()->to();
            }
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
}
