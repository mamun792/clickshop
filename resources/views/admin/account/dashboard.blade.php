@extends('admin.master')

@section('main-content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <div class="page-content">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Financial Overview</h1>
                    <p class="text-gray-600 dark:text-gray-400">Track your financial health at a glance</p>
                </div>
                <button id="themeToggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-moon text-gray-800 dark:text-gray-200"></i>
                </button>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                <!-- Total Income -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Income</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                ৳{{ number_format($income) }}
                            </h3>
                            {{-- <span class="text-green-500 text-sm">↑ 12% vs last month</span> --}}
                            <span class="{{ $incomeChange >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm">
                                {{ $incomeChange >= 0 ? '↑' : '↓' }} {{ number_format(abs($incomeChange), 2) }}% vs last month
                            </span>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                            <i class="fas fa-wallet text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Expenses -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Expenses</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                ৳{{ number_format($expenses) }}
                            </h3>
                            <span class="{{ $expensesChange >= 0 ? 'text-red-500' : 'text-green-500' }} text-sm">
                                {{ $expensesChange >= 0 ? '↑' : '↓' }} {{ number_format(abs($expensesChange), 2) }}% vs last month
                            </span>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full">
                            <i class="fas fa-shopping-cart text-red-600 dark:text-red-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Net Balance -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Net Balance</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">

                                ৳{{ number_format($netBalance) }}
                            </h3>
                            <span class="{{ $netBalanceChange >= 0 ? 'text-blue-500' : 'text-red-500' }} text-sm">
                                {{ $netBalanceChange >= 0 ? '↑' : '↓' }} {{ number_format(abs($netBalanceChange), 2) }}% vs last month
                            </span>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                            <i class="fas fa-balance-scale text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Savings Rate -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Savings Rate</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                ৳{{ number_format($savingsRate) }}%
                            </h3>
                            <span class="{{ $savingsRateChange >= 0 ? 'text-purple-500' : 'text-red-500' }} text-sm">
                                {{ $savingsRateChange >= 0 ? '↑' : '↓' }} {{ number_format(abs($savingsRateChange), 2) }}% vs last month
                            </span>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                            <i class="fas fa-piggy-bank text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-3">
                <!-- Monthly Overview Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <h3 class="text-md font-medium text-gray-800 dark:text-white mb-1">Monthly Overview</h3>
                    <canvas id="monthlyOverview" height="150"></canvas>
                </div>

                <!-- Income Distribution Chart -->
                <div class="bg-white dark:bg-gray-800  shadow-sm p-4">
                    <h3 class="text-md font-medium text-gray-800 dark:text-white mb-1">Income Distribution</h3>
                    <canvas id="incomeDistributions" height="50"></canvas>
                </div>
            </div>


            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="transactionTable">
                            <!-- Transactions will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>
@endsection

@push('scripts')


<script>
    document.addEventListener('DOMContentLoaded', function() {









        const backendTransactions = @json($transactions);
        const accountTypes = @json($accountTypes);


        const monthlyCtx = document.getElementById('monthlyOverview').getContext('2d');

        // Process transaction data for chart
        const monthlyData = backendTransactions.reduce((acc, transaction) => {
            const month = new Date(transaction.transaction_date).toLocaleString('default', { month: 'short' });
            const amount = parseFloat(transaction.amount);

            if (transaction.transaction_type === 'credit') {
                acc.income[month] = (acc.income[month] || 0) + amount;
            } else {
                acc.expenses[month] = (acc.expenses[month] || 0) + amount;
            }
            return acc;
        }, {income: {}, expenses: {}});

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: Object.keys(monthlyData.income),
                datasets: [{
                    label: 'Income',
                    data: Object.values(monthlyData.income),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Expenses',
                    data: Object.values(monthlyData.expenses),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { /* keep existing options */ }
        });

        // Income Distribution Chart
        const distributionCtx = document.getElementById('incomeDistributions').getContext('2d');

        const accountTotals = backendTransactions.reduce((acc, transaction) => {
            const account = accountTypes.find(a => a.id === transaction.account_id)?.name || 'Unknown';
            acc[account] = (acc[account] || 0) + parseFloat(transaction.amount);
            return acc;
        }, {});

        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(accountTotals),
                datasets: [{
                    data: Object.values(accountTotals),
                    backgroundColor: [
                        '#10B981', '#3B82F6', '#F59E0B', '#6366F1',
                        '#EC4899', '#8B5CF6', '#14B8A6', '#F97316'
                    ]
                }]
            },
            options: { /* keep existing options */ }
        });

        // Populate Recent Transactions
        const transactionTable = document.getElementById('transactionTable');
        transactionTable.innerHTML = '';

        backendTransactions.forEach(transaction => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                    ${transaction.transaction_date}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                    ${transaction.comments || 'No description'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                    ${accountTypes.find(a => a.id === transaction.account_id)?.name || 'Unknown'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm ${transaction.transaction_type === 'credit' ? 'text-green-600' : 'text-red-600'}">
                    ৳${parseFloat(transaction.amount).toLocaleString()}
                </td>
            `;
            transactionTable.appendChild(row);
        });
    });
    </script>
@endpush
