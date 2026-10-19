<x-calc.page
    title="Accumulated Depreciation Calculator - SolveKit"
    description="Free accumulated depreciation calculator: total depreciation and book value after a number of years by straight line, declining balance, sum-of-years'-digits, units of production or MACRS."
    lede="Find accumulated depreciation and book value."
    about="Accumulated depreciation is the sum of depreciation charged so far; book value = cost − accumulated depreciation. Straight line spreads (cost − salvage) evenly over the life. Declining balance applies a fixed rate (factor ÷ life) to the book value, switching to straight line when that is larger. Sum-of-years'-digits uses fractions (n, n − 1, … ÷ the sum of the digits). Units of production follows actual use. MACRS (US tax, IRS Publication 946) uses 200% or 150% declining balance with the half-year convention and ignores salvage. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'accumulated', 'fields' => ['method', 'cost', 'salvage', 'life', 'factor', 'units', 'total_units', 'macrs', 'elapsed']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter cost, salvage, life and years elapsed', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the accumulated depreciation after 3 years on $50,000, 5-year straight line?', 'answer' => '$27,000.00.'],
        ['question' => 'And by double declining balance?', 'answer' => '$39,200.00.'],
    ]"
>
    <x-calc.select name="method" label="Method" :options="['sl' => 'Straight line', 'db' => 'Declining balance', 'syd' => 'Sum-of-years\'-digits', 'units' => 'Units of production', 'macrs' => 'MACRS (US tax)']" selected="sl" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Cost" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="salvage" label="Salvage value" value="5000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="life" label="Useful life" value="5" min="0" step="1" suffix="years" />
        <x-calc.field name="factor" label="Declining balance factor" value="2" min="1" step="0.25" />
    </div>

    <div data-show-when="method:units" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.textarea name="units" label="Units produced each year" value="12000, 15000, 9000, 8000, 6000" rows="2" />
            <x-calc.field name="total_units" label="Total expected units" value="50000" min="1" step="1" />
        </div>
    </div>

    <div data-show-when="method:macrs" hidden>
        <x-calc.select name="macrs" label="MACRS class" :options="['3' => '3-year', '5' => '5-year (cars, computers)', '7' => '7-year (office furniture, equipment)', '10' => '10-year', '15' => '15-year', '20' => '20-year']" selected="5" />
    </div>

    <x-calc.field name="elapsed" label="Years elapsed" value="3" min="0" step="1" />

    <x-calc.result label="Accumulated depreciation" />

    <x-calc.options :decimals="false" :examples="[
        'Straight line' => ['method' => 'sl', 'cost' => 50000, 'salvage' => 5000, 'life' => 5, 'factor' => 2, 'units' => '', 'total_units' => '', 'macrs' => '5', 'elapsed' => 3],
        'Double declining' => ['method' => 'db', 'cost' => 50000, 'salvage' => 5000, 'life' => 5, 'factor' => 2, 'units' => '', 'total_units' => '', 'macrs' => '5', 'elapsed' => 3],
        'MACRS 5-year' => ['method' => 'macrs', 'cost' => 50000, 'salvage' => 0, 'life' => 5, 'factor' => 2, 'units' => '', 'total_units' => '', 'macrs' => '5', 'elapsed' => 3],
        'Units' => ['method' => 'units', 'cost' => 50000, 'salvage' => 5000, 'life' => 5, 'factor' => 2, 'units' => '12000, 15000, 9000, 8000, 6000', 'total_units' => 50000, 'macrs' => '5', 'elapsed' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'book' => ['label' => 'Book value'],
            'total' => ['label' => 'Total depreciation'],
            'method' => ['label' => 'Method'],
            'years' => ['label' => 'Schedule'],
        ]" />
        <x-calc.grid heading="Schedule" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>accumulated = Σ depreciation to date</li>
            <li>book = cost − accumulated</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
