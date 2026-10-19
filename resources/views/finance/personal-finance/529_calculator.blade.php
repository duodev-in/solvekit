<x-calc.page
    title="529 Calculator - SolveKit"
    description="Free 529 plan calculator: college savings at the start of college against the projected cost of tuition and living, with the extra monthly saving needed."
    lede="Check whether your 529 plan will cover college."
    about="Savings grow monthly until college starts. Costs rise with college inflation: each year of study costs today's price × (1 + inflation)^years. For reference, the College Board put 2025–26 average published tuition and fees at about $11,950 at public four-year in-state colleges and $45,000 at private non-profits, before aid. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'college', 'fields' => ['years', 'savings', 'monthly', 'rate', 'cost', 'inflation', 'length']]"
    :how-to="[
        ['name' => 'Enter years and savings', 'text' => ''],
        ['name' => 'Enter today\'s cost and inflation', 'text' => 'Tuition plus room and board.'],
    ]"
    :faqs="[
        ['question' => 'Will $10,000 plus $250 a month for 12 years cover four years at $30,000 a year today?', 'answer' => '$73,045.05 against $203,961.77: $130,916.72 short.'],
        ['question' => 'How much more each month?', 'answer' => '$622.97 more a month.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years until college" value="12" min="0" step="1" />
        <x-calc.field name="savings" label="Saved now" value="10000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="monthly" label="Monthly saving" value="250" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual return" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Yearly cost today" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="inflation" label="College cost inflation" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Years of college" value="4" min="1" step="1" />
    </div>

    <x-calc.result label="Saved by the first year of college" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['years' => 12, 'savings' => 10000, 'monthly' => 250, 'rate' => 6, 'cost' => 30000, 'inflation' => 4, 'length' => 4],
        'Public in-state' => ['years' => 15, 'savings' => 0, 'monthly' => 200, 'rate' => 6, 'cost' => 25000, 'inflation' => 3.5, 'length' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Projected total cost'],
            'gap' => ['label' => 'Gap'],
            'extra' => ['label' => 'Extra monthly saving'],
            'first' => ['label' => 'First-year cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>saved = growth of savings and deposits</li>
            <li>cost = Σ C(1 + π)^(t + k), k = 0…length − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
