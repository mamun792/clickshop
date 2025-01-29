<?php

namespace App\Repositories\Admin\Account;
use Illuminate\Pagination\LengthAwarePaginator;

interface AccountTypeRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getAll();
    public function get($id);

    // purpose of this method is to get all account types for select dropdown
    public function createPurpose(array $data);
    public function updatePurpose($id, array $data);
    public function deletePurpose($id);
    public function getAllPurposes();
    public function getPurpose($id);

    public function  getAllTransactions(array $data);
    public function storeDebit(array $data);
    public function getAllCredits(array $filters): LengthAwarePaginator;
    public function getAlldebits(array $filters): LengthAwarePaginator;
    public function storeBalanceTransfer(array $data);
    public function getAllTransfers(array $filters): LengthAwarePaginator;
    public function retriveAllTransactions();

    //getTransactionsByMonth($month);
    public function getTransactionsByMonth($month);
    // calculateFinancialMetrics($transactions, $lastMonthTransactions);
    public function calculateFinancialMetrics($transactions, $lastMonthTransactions);
}
