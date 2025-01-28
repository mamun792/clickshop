<?php

namespace App\Services\Admin\Account;
use Illuminate\Pagination\LengthAwarePaginator;

interface AccountTypeServiceInterface
{
    public function createAccountType(array $data);
    public function updateAccountType($id, array $data);
    public function deleteAccountType($id);
    public function getAllAccountTypes();
    public function getAccountType($id);

    // purpose of this method is to get all account types for select dropdown
    public function createPurpose(array $data);
    public function updatePurpose($id, array $data);
    public function deletePurpose($id);
    public function getAllPurposes();
    public function getPurpose($id);

    // public function createIncome(array $data);
    // public function storeCredit(array $data);
    public function getAllTransactions(array $filters) : LengthAwarePaginator;
    public function storeDebit(array $data);
    public function getAllCredits(array $filters): LengthAwarePaginator;

    public function getAlldebits(array  $filters): LengthAwarePaginator;
     public function storeBalanceTransfer(array $data);
   public function getAllTransfers(array $filters): LengthAwarePaginator;



}
