<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\PaginationData;
use App\Models\QuestionFeedbackModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use App\Enums\StateEnum;

class QuestionController extends BaseController
{

    protected QuestionFeedbackModel $model;
    protected $pages = ['title' => 'Question Feedback', 'path' => ['Admin', 'Master', 'Question Feedback'], 'page_path' => 'a/admin/master/questions'];

    public function __construct()
    {
        $this->model = new QuestionFeedbackModel();
    }

    public function index()
    {
        $limit = 15;
        $page = $this->request->getVar('page') ?? 1;
        $db = \Config\Database::connect();
        $builder = $db->table('question_feedbacks');
        $query =  $builder->select('*')->get();
        $data = [
            'page'          => $this->pages,
            'questions'     => $query->getResultArray(),
            'pagination'    => PaginationData::generate($builder, $limit, $page)
        ];
        return view('pages/question/question_view.php', $data);
    }

    public function add()
    {
        $data = [
            'page' => $this->pages
        ];
        return view('pages/question/add_question_view.php', $data);
    }

    public function insert()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            //code...
            $validationRule = [
                'question' => 'required|max_length[100]'
            ];

            $question = $this->request->getPost('question');

            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }

            $dataToInsert = [
                'question'      => $question,
                'status'        => true,
                'created_by'    => $session->get('id')
            ];

            if (! $this->model->insert($dataToInsert)) {
                return redirect()->back()->with(StateEnum::ERROR, 'Gagal Menambahkan Pertanyaan');
            }
            $db->transCommit();
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil Menambahkan Pertanyaan');
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $data = [
                'page'      => $this->pages,
                'question'  => $this->model->find($id)
            ];
            return view('pages/question/edit_question_view.php', $data);
        } catch (DataException $e) {
            dd($e->getMessage());
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            //code...
            $validateRule = [
                'question' => 'required|max_length[100]',
            ];

            if (! $this->validate($validateRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }

            $dataToInput = [
                'question'  => $this->request->getPost('question'),
                'status'    => $this->request->getPost('status') ? true : false
            ];

            if (! $this->model->update($id, $dataToInput)) {
                return redirect()->back()->with(StateEnum::ERROR, 'Gagal mengubah pertanyaan');
            }
            $db->transCommit();
            return redirect()->to($this->pages['page_path'])->with(StateEnum::SUCCESS, 'Berhasil mengubah pertanyaan');
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $this->model->delete($id);
            return redirect()->back()->with(StateEnum::SUCCESS, 'Berhasil menghapus pertanyaan');
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, 'Gagal Menghapus pertanyaan');
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, 'Gagal Menghapus pertanyaan');
        }
    }
}
