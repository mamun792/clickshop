<?php

namespace App\Repositories\Admin\Account;

use App\Models\AccountType;
use App\Models\Purpose;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        $query = Transaction::with(['account', 'purpose'])->latest();

        if (isset($filters['startDate']) && isset($filters['endDate'])) {
            $query->whereBetween('transaction_date', [$filters['startDate'], $filters['endDate']]);
        }

        if (isset($filters['account_type'])) {
            $query->where('account_id', $filters['account_type']);
        }

        if (isset($filters['transaction_type'])) {
            $typeMapping = [
                'income' => 'credit',
                'expense' => 'debit',

            ];

            if (isset($typeMapping[$filters['transaction_type']])) {
                $query->where('transaction_type', $typeMapping[$filters['transaction_type']]);
            }
        }


        return $query->paginate(5);
    }

    public function storeBalanceTransfer(array $data)
    {
        // Retrieve the accounts
        $fromAccount =  Transaction::where('account_id', $data['from_balance'])->latest()->first();
        $toAccount = Transaction::where('account_id', $data['to_balance'])->latest()->first();


        // Check for sufficient balance in the from account
        if ($fromAccount->amount < $data['transfer_amount']) {

            throw new \Exception('Insufficient balance in the source account.');
        }

        // Update the balance in the from account DB::beginTransaction();
        try {
            // Update the account balances
            $fromAccount->amount -= $data['transfer_amount'];
            $toAccount->amount += $data['transfer_amount'];

            // Save the changes
            $fromAccount->save();
            $toAccount->save();


            // Record the tranfer   for the to account (credit)
            $creayte =   Transfer::create([
                'from_account_id' => $data['from_balance'],
                'to_account_id' => $data['to_balance'],
                'transfer_date' => $data['transaction_date'],
                'transfer_amount' => $data['transfer_amount'],
                'transaction_type' => 'credit',
                'comments' => $data['comments'] ?? '',
                'user_id' => auth()->id(),
                'cost' => $data['cost'] ?? 0,

            ]);



            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            //  Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getAllTransfers(array $filters): LengthAwarePaginator
    {
        $query = Transfer::with(['fromAccount', 'toAccount', 'user'])->latest();

        if (isset($filters['startDate']) && isset($filters['endDate'])) {
            $query->whereBetween('transfer_date', [$filters['startDate'], $filters['endDate']]);
        }

        return $query->paginate(10);
    }

    public function retriveAllTransactions()
    {
        return Transaction::latest()->get();
    }

    public function getTransactionsByMonth($month)
    {
        return Transaction::whereMonth('transaction_date', $month)->get();
    }


    public function calculateFinancialMetrics($transactions, $lastMonthTransactions)
    {
        $income = $transactions->where('transaction_type', 'credit')->sum('amount');
        $expenses = $transactions->where('transaction_type', 'debit')->sum('amount');
        $netBalance = $income - $expenses;
        $savingsRate = $income > 0 ? ($netBalance / $income) * 100 : 0;

        $lastMonthIncome = $lastMonthTransactions->where('transaction_type', 'credit')->sum('amount');
        $lastMonthExpenses = $lastMonthTransactions->where('transaction_type', 'debit')->sum('amount');
        $lastMonthNetBalance = $lastMonthIncome - $lastMonthExpenses;

        $incomeChange = $this->calculatePercentageChange($income, $lastMonthIncome);
        $expensesChange = $this->calculatePercentageChange($expenses, $lastMonthExpenses);
        $netBalanceChange = $this->calculatePercentageChange($netBalance, $lastMonthNetBalance);
        $savingsRateChange = $this->calculateSavingsRateChange($savingsRate, $lastMonthIncome, $lastMonthNetBalance);

        return compact('income', 'expenses', 'netBalance', 'savingsRate', 'lastMonthIncome', 'lastMonthExpenses', 'lastMonthNetBalance', 'incomeChange', 'expensesChange', 'netBalanceChange', 'savingsRateChange');
    }

    private function calculatePercentageChange(float $current, float $previous): float
    {
        return $previous > 0 ? (($current - $previous) / $previous) * 100 : 0;
    }

    private function calculateSavingsRateChange(float $savingsRate, float $lastMonthIncome, float $lastMonthNetBalance): float
    {
        return $lastMonthNetBalance > 0 ? ($savingsRate - ($lastMonthNetBalance / $lastMonthIncome) * 100) : 0;
    }
}
