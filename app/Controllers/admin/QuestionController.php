<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuestionFeedbackModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class QuestionController extends BaseController
{

    protected QuestionFeedbackModel $model;

    public function __construct()
    {
        $this->model = new QuestionFeedbackModel();
    }

    public function index()
    {
        $question = $this->model->findAll();
        $data = [
            'page' => ['title' => 'Question'],
            'questions' => $question
        ];
        return view('pages/question/question_view.php', $data);
    }
    public function add()
    {
        return view('pages/question/add_question_view.php');
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
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }

            $dataToInsert = [
                'question'      => $question,
                'status'        => true,
                'created_by'    => $session->get('id')
            ];

            $this->model->insert($dataToInsert);
            $db->transCommit();
            return redirect()->to(base_url('a/admin/master/questions'))->with('success', 'Berhasil Menambahkan Pertanyaan');
        } catch (\Throwable $th) {
            //throw $th;
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            //code...
            $data = $this->model->find($id);
            // dd($data);
            return view('pages/question/edit_question_view.php', $data);
        } catch (DataException $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function update($id)
    {
        try {
            //code...
            dd($this->request);
            $validateRule = [
                'question' => 'required|max_length[100]',
            ];
            if (! $this->validate($validateRule)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
            $dataToInput = [
                'question'  => $this->request->getPost('question'),
                'status'    => $this->request->getPost('status') ? true : false
            ];

            if (! $this->model->update($id, $dataToInput)) {
                return redirect()->back()->with('error', 'Gagal mengubah pertanyaan');
            }

            return redirect()->to('a/admin/master/questions')->with('success', 'Berhasil mengubah pertanyaan');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function delete($id) {}
}
