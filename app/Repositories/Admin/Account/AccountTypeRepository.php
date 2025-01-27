<?php

namespace App\Repositories\Admin\Account;

use App\Models\AccountType;
use App\Models\Purpose;

class AccountTypeRepository implements AccountTypeRepositoryInterface
{
    protected $model;

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


}
