<?php

namespace App\Repositories\Admin\Account;

use App\Models\AccountType;
use App\Models\Purpose;
use App\Models\Transaction;
use App\Traits\FileUploadTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountTypeRepository implements AccountTypeRepositoryInterface

{
    protected $model;
    use FileUploadTrait;

    public function __construct(AccountType $accountType)
    {
        $this->model = $accountType;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $accountType = $this->model->findOrFail($id);
        $accountType->update($data);
        return $accountType;
    }

    public function delete($id)
    {
        $accountType = $this->model->findOrFail($id);
        return $accountType->delete();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    // purpose of this method is to get all account types for select dropdown

    public function createPurpose(array $data)
    {
        return Purpose::create($data);
    }

    public function updatePurpose($id, array $data)
    {
        $accountType = Purpose::findOrFail($id);
        $accountType->update($data);
        return $accountType;
    }

    public function deletePurpose($id)
    {
        $accountType = Purpose::findOrFail($id);
        return $accountType->delete();
    }

    public function getAllPurposes()
    {
        return Purpose::latest()->get();
    }

    public function getPurpose($id)
    {
        return Purpose::findOrFail($id);
    }


    public function storeDebit(array $data)
    {
       //   // Handle file upload if a document is provided
        if (isset($data['document'])) {
            $data['document'] = $this->uploadFile($data['document'], 'debit');
        }

        return Transaction::create($data);
    }

    public function getAllCredits(array $filters): LengthAwarePaginator
    {
        $query = Transaction::where('transaction_type', 'credit')->latest();

        if (isset($filters['startDate']) && isset($filters['endDate'])) {
            $query->whereBetween('transaction_date', [$filters['startDate'], $filters['endDate']]);
        }

        if (isset($filters['account_type'])) {
            $query->where('account_id', $filters['account_type']);
        }

        return $query->paginate(10);
    }


    public function getAllDebits(array $filters): LengthAwarePaginator
    {
        $query = Transaction::where('transaction_type', 'debit')->latest();

        if (isset($filters['startDate']) && isset($filters['endDate'])) {
            $query->whereBetween('transaction_date', [$filters['startDate'], $filters['endDate']]);
        }

        if (isset($filters['account_type'])) {
            $query->where('account_id', $filters['account_type']);
        }


        return $query->paginate(10);
    }


    public function getAllTransactions(array $filters): LengthAwarePaginator
    {
        $query = Transaction::latest();

        if (isset($filters['startDate']) && isset($filters['endDate'])) {
            $query->whereBetween('transaction_date', [$filters['startDate'], $filters['endDate']]);
        }

        if (isset($filters['account_type'])) {
            $query->where('account_id', $filters['account_type']);
        }

        return $query->paginate(10);
    }
    

}
