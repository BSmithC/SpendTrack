<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SpendTrack - Expense Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #f3f4f6;
            padding: 40px 20px;
            color: #111827;
        }

        /* Main container */
        .report-container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 40px 48px;
        }

        /* Header section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 3px solid #10b981;
            padding-bottom: 24px;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .title-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: #065f46;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .title-section p {
            color: #6b7280;
            font-size: 14px;
        }

        .meta-section {
            text-align: right;
        }

        .meta-section .date {
            font-size: 14px;
            color: #4b5563;
            background: #f3f4f6;
            padding: 6px 12px;
            border-radius: 30px;
            display: inline-block;
        }

        /* Summary cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .card.income {
            border-left: 5px solid #10b981;
        }

        .card.expense {
            border-left: 5px solid #ef4444;
        }

        .card.balance {
            border-left: 5px solid #3b82f6;
        }

        .card-label {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .card-amount {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
        }

        .card-amount.positive {
            color: #10b981;
        }

        .card-amount.negative {
            color: #ef4444;
        }

        /* Filters summary */
        .filter-summary {
            background: #f9fafb;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 32px;
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            font-size: 14px;
            border: 1px solid #e5e7eb;
        }

        .filter-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label {
            font-weight: 600;
            color: #4b5563;
        }

        .filter-value {
            background: white;
            padding: 4px 12px;
            border-radius: 30px;
            color: #111827;
            border: 1px solid #e2e8f0;
        }

        /* Table styles */
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }

        .transactions-table th {
            text-align: left;
            padding: 14px 12px;
            background: #f9fafb;
            font-weight: 600;
            font-size: 13px;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
        }

        .transactions-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .category-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .amount-positive {
            color: #10b981;
            font-weight: 600;
        }

        .amount-negative {
            color: #ef4444;
            font-weight: 600;
        }

        /* Category breakdown */
        .category-section {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 2px solid #e5e7eb;
        }

        .category-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1f2937;
        }

        .category-grid {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .category-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .category-name {
            width: 140px;
            font-weight: 500;
            color: #374151;
        }

        .progress-bar {
            flex: 1;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #10b981;
            border-radius: 10px;
            width: 0%;
        }

        .category-amount {
            width: 100px;
            text-align: right;
            font-weight: 600;
            color: #111827;
        }

        /* Footer */
        .footer {
            margin-top: 48px;
            padding-top: 24px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }

        /* Print styles - important for PDF generation */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .report-container {
                box-shadow: none;
                padding: 20px;
                max-width: 100%;
            }
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }
            .transactions-table td,
            .transactions-table th {
                break-inside: avoid;
            }
        }

        /* Responsive */
        @media (max-width: 700px) {
            .report-container {
                padding: 24px 20px;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }
            .meta-section {
                text-align: left;
            }
            .category-name {
                width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="header">
            <div class="title-section">
                <h1>SpendTrack · Expense Report</h1>
                <p>Personal finance tracking system</p>
            </div>
            <div class="meta-section">
                <div class="date">Generated: March 25, 2026</div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="card income">
                <div class="card-label">Total Income</div>
                <div class="card-amount positive">$ 3,840.00</div>
            </div>
            <div class="card expense">
                <div class="card-label">Total Expenses</div>
                <div class="card-amount negative">$ 1,895.50</div>
            </div>
            <div class="card balance">
                <div class="card-label">Net Balance</div>
                <div class="card-amount positive">$ 1,944.50</div>
            </div>
        </div>

        <!-- Active Filters (simulated) -->
        <div class="filter-summary">
            <div class="filter-item">
                <span class="filter-label">Period:</span>
                <span class="filter-value">March 1, 2026 – March 25, 2026</span>
            </div>
            <div class="filter-item">
                <span class="filter-label">Categories:</span>
                <span class="filter-value">All</span>
            </div>
        </div>

        <!-- Transactions Table -->
        <h3 style="font-size: 18px; margin-bottom: 16px; font-weight: 600;">📋 Recent Transactions</h3>
        <table class="transactions-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2026-03-24</td>
                    <td>Freelance project</td>
                    <td><span class="category-badge">Work</span></td>
                    <td>Income</td>
                    <td class="amount-positive">+ $1,200.00</td>
                </tr>
                <tr>
                    <td>2026-03-23</td>
                    <td>Grocery store</td>
                    <td><span class="category-badge">Food</span></td>
                    <td>Expense</td>
                    <td class="amount-negative">- $85.40</td>
                </tr>
                <tr>
                    <td>2026-03-22</td>
                    <td>Uber rides</td>
                    <td><span class="category-badge">Transport</span></td>
                    <td>Expense</td>
                    <td class="amount-negative">- $32.00</td>
                </tr>
                <tr>
                    <td>2026-03-20</td>
                    <td>Netflix subscription</td>
                    <td><span class="category-badge">Entertainment</span></td>
                    <td>Expense</td>
                    <td class="amount-negative">- $15.99</td>
                </tr>
                <tr>
                    <td>2026-03-18</td>
                    <td>Salary deposit</td>
                    <td><span class="category-badge">Salary</span></td>
                    <td>Income</td>
                    <td class="amount-positive">+ $2,640.00</td>
                </tr>
                <tr>
                    <td>2026-03-15</td>
                    <td>Restaurant dinner</td>
                    <td><span class="category-badge">Food</span></td>
                    <td>Expense</td>
                    <td class="amount-negative">- $47.80</td>
                </tr>
                <tr>
                    <td>2026-03-10</td>
                    <td>Electricity bill</td>
                    <td><span class="category-badge">Utilities</span></td>
                    <td>Expense</td>
                    <td class="amount-negative">- $93.25</td>
                </tr>
                <tr>
                    <td>2026-03-05</td>
                    <td>Gym membership</td>
                    <td><span class="category-badge">Health</span></td>
                    <td>Expense</td>
                    <td class="amount-negative">- $55.00</td>
                </tr>
            </tbody>
        </table>

        <!-- Category Breakdown Section (visual bars) -->
        <div class="category-section">
            <h3>Spending by Category (March 2026)</h3>
            <div class="category-grid">
                <div class="category-row">
                    <span class="category-name">Food</span>
                    <div class="progress-bar"><div class="progress-fill" style="width: 42%;"></div></div>
                    <span class="category-amount">$ 133.20</span>
                </div>
                <div class="category-row">
                    <span class="category-name">Transport</span>
                    <div class="progress-bar"><div class="progress-fill" style="width: 23%;"></div></div>
                    <span class="category-amount">$ 72.50</span>
                </div>
                <div class="category-row">
                    <span class="category-name">Utilities</span>
                    <div class="progress-bar"><div class="progress-fill" style="width: 30%;"></div></div>
                    <span class="category-amount">$ 93.25</span>
                </div>
                <div class="category-row">
                    <span class="category-name">Entertainment</span>
                    <div class="progress-bar"><div class="progress-fill" style="width: 18%;"></div></div>
                    <span class="category-amount">$ 55.99</span>
                </div>
                <div class="category-row">
                    <span class="category-name">Health</span>
                    <div class="progress-bar"><div class="progress-fill" style="width: 17%;"></div></div>
                    <span class="category-amount">$ 55.00</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>SpendTrack — Personal expense tracking system | Report generated automatically</p>
            <p style="margin-top: 8px;">© 2026 SpendTrack · All financial data is confidential</p>
        </div>
    </div>
</body>
</html>
