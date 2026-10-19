<x-calc.page
    title="Bank Reconciliation Calculator - SolveKit"
    description="Free bank reconciliation calculator: adjust the bank statement for deposits in transit and outstanding checks, and your books for fees, interest and NSF checks, until they agree."
    lede="Reconcile your bank statement."
    about="Adjusted bank balance = statement balance + deposits in transit − outstanding checks ± bank errors. Adjusted book balance = book balance + interest and collections − fees and NSF checks ± book errors. They should match; record the book-side items in your ledger. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'reconcile', 'fields' => ['bank', 'deposits', 'checks', 'bank_error', 'book', 'interest', 'collections', 'fees', 'nsf', 'book_error']]"
    :how-to="[
        ['name' => 'Adjust the bank side', 'text' => ''],
        ['name' => 'Adjust the book side', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Do the example balances reconcile?', 'answer' => 'Reconciled: adjusted bank $11,900.00, adjusted books $11,900.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bank" label="Bank statement balance" value="12450" step="0.01" suffix="$" />
        <x-calc.field name="deposits" label="Deposits in transit" value="1800" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="checks" label="Outstanding checks" value="2350" step="0.01" suffix="$" />
        <x-calc.field name="bank_error" label="Bank errors (+/−)" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="book" label="Book balance" value="11965" step="0.01" suffix="$" />
        <x-calc.field name="interest" label="Interest earned" value="15" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="collections" label="Collections by bank" value="0" step="0.01" suffix="$" />
        <x-calc.field name="fees" label="Bank fees" value="25" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nsf" label="NSF checks" value="55" step="0.01" suffix="$" />
        <x-calc.field name="book_error" label="Book errors (+/−)" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Balances agree" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bank' => 12450, 'deposits' => 1800, 'checks' => 2350, 'bank_error' => 0, 'book' => 11965, 'interest' => 15, 'collections' => 0, 'fees' => 25, 'nsf' => 55, 'book_error' => 0],
        'Off by a transposition' => ['bank' => 12450, 'deposits' => 1800, 'checks' => 2350, 'bank_error' => 0, 'book' => 11920, 'interest' => 15, 'collections' => 0, 'fees' => 25, 'nsf' => 55, 'book_error' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bank' => ['label' => 'Adjusted bank balance'],
            'book' => ['label' => 'Adjusted book balance'],
            'entries' => ['label' => 'Book entries needed'],
            'hint' => ['label' => 'Hint'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bank + DIT − OC = book + interest − fees − NSF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
