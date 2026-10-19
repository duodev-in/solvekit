<x-calc.page
    title="Student Loan Forgiveness Calculator - SolveKit"
    description="Free student loan forgiveness calculator: when you reach Public Service Loan Forgiveness (120 payments) or income-driven forgiveness (20, 25 or 30 years, including RAP from July 2026)."
    lede="Find when your federal student loans could be forgiven."
    about="The 2022 one-time debt relief plan was struck down by the Supreme Court in 2023, so this tracks the forgiveness that remains. PSLF forgives the balance after 120 qualifying payments while working for government or a non-profit. Income-driven plans forgive after 20 or 25 years; the Repayment Assistance Plan (from July 1, 2026) after 30 years. Count your qualifying payments on StudentAid.gov. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'forgiveness', 'fields' => ['plan', 'made', 'start', 'balance']]"
    :how-to="[
        ['name' => 'Choose the program', 'text' => ''],
        ['name' => 'Enter qualifying payments', 'text' => 'From StudentAid.gov.'],
    ]"
    :faqs="[
        ['question' => 'When is PSLF reached with 48 payments made by October 2026?', 'answer' => 'October 2032.'],
        ['question' => 'And on IBR with 120 payments?', 'answer' => 'October 2036.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="plan" label="Program" :options="['pslf' => 'PSLF (120 payments)', 'ibr_new' => 'IBR, new borrowers (20 years)', 'ibr_old' => 'IBR, earlier borrowers (25 years)', 'paye' => 'PAYE (20 years)', 'icr' => 'ICR (25 years)', 'rap' => 'RAP (30 years)']" selected="pslf" />
        <x-calc.field name="made" label="Qualifying payments so far" value="48" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Month counting from" value="2026-10" type="month" />
        <x-calc.field name="balance" label="Balance (optional)" value="60000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Forgiveness from about" />

    <x-calc.options :decimals="false" :examples="[
        'PSLF' => ['plan' => 'pslf', 'made' => 48, 'start' => '2026-10', 'balance' => 60000],
        'IBR' => ['plan' => 'ibr_new', 'made' => 120, 'start' => '2026-10', 'balance' => 45000],
        'RAP' => ['plan' => 'rap', 'made' => 0, 'start' => '2026-10', 'balance' => 30000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'plan' => ['label' => 'Program'],
            'left' => ['label' => 'Payments left'],
            'progress' => ['label' => 'Progress'],
            'tax' => ['label' => 'Tax'],
            'amount' => ['label' => 'Balance'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>date = this month + (required − made) months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
