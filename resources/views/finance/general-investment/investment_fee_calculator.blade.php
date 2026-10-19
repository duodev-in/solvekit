<x-calc.page
    title="Investment Fee Calculator - SolveKit"
    description="Free investment fee calculator: how much an annual percentage fee (expense ratio or advisory fee) costs over time, compared with no fee."
    lede="See what fees cost you over the years."
    about="A yearly fee is taken from the balance, so it lowers the return every year and compounds: the balance grows at (return − fee). Over decades, a 1% fee can take a quarter of the final balance. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'fee_drag', 'fields' => ['start', 'contribution', 'rate', 'fee', 'years']]"
    :how-to="[
        ['name' => 'Enter balance and contributions', 'text' => ''],
        ['name' => 'Enter return and fee', 'text' => 'Fund expense ratio plus any advisory fee.'],
    ]"
    :faqs="[
        ['question' => 'What does a 1% fee cost on $100,000 plus $500 a month over 30 years at 7%?', 'answer' => '$317,120.20.'],
        ['question' => 'And a 0.05% index fund?', 'answer' => '$17,998.49.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting balance" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="contribution" label="Monthly contribution" value="500" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Return before fees" value="7" step="any" suffix="%" />
        <x-calc.field name="fee" label="Annual fee" value="1" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="30" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Lost to fees" />

    <x-calc.options :decimals="false" :examples="[
        '1% advisory' => ['start' => 100000, 'contribution' => 500, 'rate' => 7, 'fee' => 1, 'years' => 30],
        'Index fund' => ['start' => 100000, 'contribution' => 500, 'rate' => 7, 'fee' => 0.05, 'years' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="With and without fees" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'without' => ['label' => 'Balance with no fee'],
            'with' => ['label' => 'Balance after fees'],
            'deposits' => ['label' => 'Total deposits'],
            'first' => ['label' => 'First-year fee'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = FV(r) − FV(r − fee)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
