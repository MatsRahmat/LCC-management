<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\PaginationData;
use App\Models\QuestionPeriodModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;
use App\Enums\StateEnum;

class QuestionPeriodController extends BaseController
{
    // Pages setting
    protected $pages = ['title' => 'Question Period', 'path' => ['Admin', 'Question Period'], 'page_path' => 'a/admin/question-periods'];
    protected QuestionPeriodModel $model;

    public function __construct()
    {
        $this->model = new QuestionPeriodModel();
    }

    public function index()
    {
        $limit = 10;
        $page = $this->request->getVar('page') ?? 1;
        $db = \Config\Database::connect();

        $builder = $db->table('question_periods as qp');
        $builder->select('qp.id as id, qp.start_date as start_date, qp.end_date as end_date, qp.title as title, qp.status as status, u.username as created_by');
        $builder->join('users as u', 'qp.created_by = u.id', 'left');
        $query = $builder->get();

        $data = [
            'page' => $this->pages,
            'questions' => $query->getResultArray(),
            'pagination' => PaginationData::generate($builder, $limit, $page),
        ];
        return view('pages/question_period/question_period_view.php', $data);
    }

    public function add()
    {
        $data = [
            'page' => $this->pages,
        ];
        return view('pages/question_period/add_question_period_view.php', $data);
    }

    public function insert()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        $session = \Config\Services::session();
        try {
            $validationRule = [
                'start_date'    => 'required',
                'end_date'      => 'required',
                'title'         => 'required',
            ];

            $dataToInsert = [
                'start_date'    => $this->request->getPost('start_date'),
                'end_date'      => $this->request->getPost('end_date'),
                'title'         => $this->request->getPost('title'),
                'status'        => $this->request->getPost('status') == "on" ? true : false,
                'created_by'    => $session->get('id')
            ];

            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }

            if (! $this->model->insert($dataToInsert)) {
                return redirect()->back()->withInput()->with(StateEnum::ERROR, 'Gagal menambahkan Question Period');
            }

            $db->transCommit();
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil menambahkan Question Period');
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $data = [
                'page' => $this->pages,
                'question' => $this->model->find($id)
            ];
            return view('pages/question_period/edit_question_period_view.php', $data);
        } catch (DataException $e) {
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $validationRule = [
                'start_date'    => 'required',
                'end_date'      => 'required',
                'title'         => 'required',
            ];

            $dataToInsert = [
                'start_date'    => $this->request->getPost('start_date'),
                'end_date'      => $this->request->getPost('end_date'),
                'title'         => $this->request->getPost('title'),
                'status'        => $this->request->getPost('status') == "on" ? true : false
            ];
            if (! $this->validate($validationRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }

            if (! $this->model->update($id, $dataToInsert)) {
                return redirect()->back()->withInput()->with(StateEnum::ERROR, 'Gagal Mengubah data Question Period');
            }

            $db->transCommit();
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil Mengubah data Question Period');
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            if (! $this->model->delete($id)) {
                return redirect()->back()->with(StateEnum::ERROR, 'Gagal menghapus data');
            }
            return redirect()->back()->with(StateEnum::SUCCESS, 'Berhasil menghapus data');
        } catch (DataException $e) {
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
}
