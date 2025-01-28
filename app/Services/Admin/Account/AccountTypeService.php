<?php

namespace App\Services\Admin\Account;

use App\Repositories\Admin\Account\AccountTypeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountTypeService implements AccountTypeServiceInterface
{
    protected $accountTypeRepository;

    public function __construct(AccountTypeRepositoryInterface $accountTypeRepository)
    {
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function createAccountType(array $data)
    {
        return $this->accountTypeRepository->create($data);
    }

    public function updateAccountType($id, array $data)
    {
        return $this->accountTypeRepository->update($id, $data);
    }

    public function deleteAccountType($id)
    {
        return $this->accountTypeRepository->delete($id);
    }

    public function getAllAccountTypes()
    {
        return $this->accountTypeRepository->getAll();
    }

    public function getAccountType($id)
    {
        return $this->accountTypeRepository->get($id);
    }

    // purpose of this method is to get all account types for select dropdown
    public function createPurpose(array $data)
    {
        return $this->accountTypeRepository->createPurpose($data);
    }


    public function updatePurpose($id, array $data)
    {
        return $this->accountTypeRepository->updatePurpose($id, $data);
    }

    public function deletePurpose($id)
    {
        return $this->accountTypeRepository->deletePurpose($id);
    }

    public function getAllPurposes()
    {
        return $this->accountTypeRepository->getAllPurposes();
    }

    public function getPurpose($id)
    {
        return $this->accountTypeRepository->getPurpose($id);
    }

    public function storeDebit(array $data)
    {
        return $this->accountTypeRepository->storeDebit($data);
    }

    public function getAllCredits(array $filters): LengthAwarePaginator
    {
        return $this->accountTypeRepository->getAllCredits($filters);
    }

    public function getAlldebits(array $filters): LengthAwarePaginator
    {
        return $this->accountTypeRepository->getAlldebits($filters);
    }


    public function getAllTransactions(array $filters): LengthAwarePaginator
    {
        return $this->accountTypeRepository->getAllTransactions($filters);
    }
   
}
