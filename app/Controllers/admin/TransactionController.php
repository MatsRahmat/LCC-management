<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Enums\StateEnum;
use App\Enums\TransactionTypeEnum;
use App\Helpers\PaginationData;
use App\Models\FinanceModel;
use App\Models\TransactionModel;
use App\Models\TransactionTypeModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;

class TransactionController extends BaseController
{
    protected TransactionModel $model;
    protected $pages =  ['title' => 'Keuangan', 'path' => ['Admin', 'Keuangan'], 'page_path' => 'a/admin/finances'];
    public function __construct()
    {
        $this->model = new TransactionModel();
    }
    public function index()
    {
        $db = \Config\Database::connect();
        $financeModel = new FinanceModel();

        $builder = $db->table('transactions t');
        $builderIncome = $builder
            ->select('t.id as id, t.amount as amount, t.desc as desc, t.created_at as created_at, u.username as username')
            ->where('t.type_id', TransactionTypeEnum::INCOME)
            ->where('t.deleted_at', null)
            ->join('users u', 't.created_by = u.id', 'left')
            ->orderBy('t.id', 'desc')
            ->get(10, 0);

        $sumOfIncome = $builder
            ->selectSum('amount')
            ->where('type_id', TransactionTypeEnum::INCOME)
            ->where('t.deleted_at', null)
            ->get(10, 0);

        $builderOutcome = $builder
            ->select('t.id as id, t.amount as amount, t.desc as desc, t.created_at as created_at, u.username as username')
            ->where('t.type_id', TransactionTypeEnum::OUTCOME)
            ->where('t.deleted_at', null)
            ->join('users u', 't.created_by = u.id', 'left')
            ->orderBy('t.id', 'desc')
            ->get(10, 0);

        $sumOfOutcome = $builder
            ->selectSum('amount')
            ->where('type_id', TransactionTypeEnum::OUTCOME)
            ->where('t.deleted_at', null)
            ->get(10, 0);

        // dd(['income' => $builderIncome->getResultArray(), 'sum income' => $sumOfIncome->getResultArray(), 'oucome' => $builderOutcome->getResultArray(), 'sum outcome' => $sumOfOutcome->getResultArray()]);
        // $income = $this->model->where('type_id', TransactionTypeEnum::INCOME)->orderBy('id', 'DESC')->findAll(10, 0);
        // $outcome = $this->model->where('type_id', TransactionTypeEnum::OUTCOME)->orderBy('id', 'DESC')->findAll(10, 0);
        $balance = $financeModel->find(1);

        if ($balance == null) {
            $financeModel->insert(['id' => 1, 'total' => 0]);
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::INFO, 'Created initial finance rows');
        }

        $data = [
            'page'      => $this->pages,
            'incomes'   => $builderIncome->getResultArray(),
            'outcomes'  => $builderOutcome->getResultArray(),
            'total_income'  => $sumOfIncome->getResultArray(),
            'total_outcome' => $sumOfOutcome->getResultArray(),
            'balance'   => $balance
        ];
        return view('pages/finance/finance_view', $data);
    }
    public function create()
    {
        $transType = new TransactionTypeModel();
        $data = [
            'page' => $this->pages,
            'types' => $transType->findAll()
        ];

        return view('pages/finance/add_finance_view', $data);
    }
    public function insert()
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $financeModel = new FinanceModel();
        $db->transBegin();
        try {
            $validateRule = [
                'type_id'       => 'required',
                'amount'        => 'required',
                'desc'          => 'required',
            ];

            if (!$this->validate($validateRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }

            $type = $this->request->getPost('type_id');
            $amount = $this->request->getPost('amount');
            $dataToInsert = [
                'type_id'   => $type,
                'amount'   => $amount,
                'desc'   => $this->request->getPost('desc'),
                'created_by'    => $session->get('id')
            ];

            $existingData = $financeModel->find(1);

            $dataToUpdate = [];

            if ($type == TransactionTypeEnum::INCOME) {
                $dataToUpdate['total'] = $existingData['total'] + $amount;
            } elseif ($type == TransactionTypeEnum::OUTCOME) {
                $dataToUpdate['total'] = $existingData['total'] - $amount;
            }

            $financeModel->update(1, $dataToUpdate);
            $this->model->insert($dataToInsert);
            $db->transCommit();
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil menambahkan data');
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->withInput()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function edit($id)
    {
        $transTypeModel = new TransactionTypeModel();
        try {
            $transResult = $this->model->find($id);
            $data = [
                'trans' => $transResult,
                'page' => $this->pages,
                'types' => $transTypeModel->findAll(),
            ];
            return view('pages/finance/edit_finance_view', $data);
        } catch (DataException $e) {
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function update($id)
    {
        $db = \Config\Database::connect();
        $financeModel = new FinanceModel();
        $db->transBegin();
        try {
            $validateRule = [
                'amount'        => 'required',
                'desc'          => 'required',
            ];

            if (!$this->validate($validateRule)) {
                return redirect()->back()->withInput()->with(StateEnum::ERRORS, $this->validator->getErrors());
            }

            $amount = (int)$this->request->getPost('amount');

            $dataToInsert = [
                'amount'    => $amount,
                'desc'   => $this->request->getPost('desc'),
            ];
            $prevValue = $this->model->find($id);
            $existingData = $financeModel->find(1);

            $financeDataToUpdate = [
                'total' => $existingData['total']
            ];

            if ($prevValue['amount'] > $amount) {
                $differentValue = (int) $prevValue['amount'] - $amount;
                $financeDataToUpdate['total'] = $existingData['total'] - $differentValue;
            } elseif ($prevValue['amount'] < $amount) {
                $differentValue =  $amount - (int) $prevValue['amount'];
                $financeDataToUpdate['total'] = $existingData['total'] + $differentValue;
            }

            $financeModel->update(1, $financeDataToUpdate);
            $this->model->update($id, $dataToInsert);

            $db->transCommit();

            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil mengubah data');
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $currentData = $this->model->find($id);
            $financeModel = new FinanceModel();
            $currentBalance = $financeModel->find(1);
            $dataToUpdate = [
                'total' => (int)$currentBalance['total'] - (int)$currentData['amount']
            ];
            $financeModel->update(1, $dataToUpdate);
            $this->model->delete($id);
            $db->transCommit();
            return redirect()->to(base_url($this->pages['page_path']))->with(StateEnum::SUCCESS, 'Berhasil menghapus data');
        } catch (DataException $e) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $e->getMessage());
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
    public function income()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $limit = 10;
        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $limit;

        $builder->select('t.id as id, t.amount as amount, t.desc as desc, t.created_at as created_at, u.username as created_by')
            ->where('t.type_id', TransactionTypeEnum::INCOME)
            ->where('t.deleted_at', null)
            ->join('users u', 'u.id = t.created_by', 'left')
            ->orderBy('t.id', 'DESC');
        $query = $builder->get($limit, $offset);

        $sumAmount = $this->model->selectSum('amount')->where('type_id', TransactionTypeEnum::INCOME)->findAll($limit, $offset);

        $data = [
            'page' => $this->pages,
            'incomes' => $query->getResultArray(),
            'total_income' => is_array($sumAmount) && count($sumAmount) > 0 ? $sumAmount[0]['amount'] : 0,
            'pagination'    => PaginationData::generate($builder, $limit, $page)
        ];

        return view('pages/finance/finance_income_view', $data);
    }
    public function outcome()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $limit = 10;
        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $limit;

        $builder->select('t.id as id, t.amount as amount, t.desc as desc, t.created_at as created_at, u.username as created_by')
            ->where('t.type_id', TransactionTypeEnum::OUTCOME)
            ->where('t.deleted_at', null)
            ->join('users u', 'u.id = t.created_by', 'left')
            ->orderBy('t.id', 'DESC');
        $query = $builder->get($limit, $offset);

        $sumAmount = $this->model->selectSum('amount')->where('type_id', TransactionTypeEnum::OUTCOME)->findAll($limit, $offset);

        $data = [
            'page' => $this->pages,
            'outcomes' => $query->getResultArray(),
            'total_outcome' => is_array($sumAmount) && count($sumAmount) > 0 ? $sumAmount[0]['amount'] : 0,
            'pagination'    => PaginationData::generate($builder, $limit, $page)
        ];

        return view('pages/finance/finance_outcome_view', $data);
    }
    public function allHistory()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('transactions t');
            $limit = 10;
            $page = $this->request->getVar('page') ?? 1;
            $offset = ($page - 1) * $limit;

            $builder->select('t.id as id, t.amount as amount, tt.name as type, t.type_id as type_id,  t.desc as desc, t.created_at as created_at, u.username as created_by')
                // ->where('t.type_id', TransactionTypeEnum::OUTCOME)
                ->where('t.deleted_at', null)
                ->join('users u', 'u.id = t.created_by', 'left')
                ->join('transaction_types tt', 't.type_id = tt.id', 'left')
                ->orderBy('t.id', 'DESC');
            $query = $builder->get($limit, $offset);

            $sumOfOutcome = $this->model->selectSum('amount')->where('type_id', TransactionTypeEnum::OUTCOME)->findAll($limit, $offset);
            $sumOfIncome = $this->model->selectSum('amount')->where('type_id', TransactionTypeEnum::INCOME)->findAll($limit, $offset);

            $sumAmount = (int)$sumOfIncome[0]['amount'] - (int)$sumOfOutcome[0]['amount'];

            $data = [
                'page' => $this->pages,
                'transactions' => $query->getResultArray(),
                'total' => $sumAmount,
                'pagination'    => PaginationData::generate($builder, $limit, $page)
            ];

            return view('pages/finance/finance_all_view', $data);
        } catch (\Throwable $th) {
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
}
