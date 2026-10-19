<x-calc.page
    title="Depreciation Calculator - SolveKit"
    description="Free depreciation calculator: yearly depreciation schedule by straight line, declining balance, sum-of-years'-digits, units of production or MACRS (IRS Publication 946)."
    lede="Build a depreciation schedule."
    about="Straight line spreads (cost − salvage) evenly over the life. Declining balance applies a fixed rate (factor ÷ life) to the book value, switching to straight line when that is larger. Sum-of-years'-digits uses fractions (n, n − 1, … ÷ the sum of the digits). Units of production follows actual use. MACRS (US tax, IRS Publication 946) uses 200% or 150% declining balance with the half-year convention and ignores salvage. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'depreciation', 'fields' => ['method', 'cost', 'salvage', 'life', 'factor', 'units', 'total_units', 'macrs']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter cost, salvage and life', 'text' => 'Or the MACRS class for US tax.'],
    ]"
    :faqs="[
        ['question' => 'What is the first-year depreciation on $50,000 over 5 years, straight line?', 'answer' => '$9,000.00.'],
        ['question' => 'And by double declining balance?', 'answer' => '$20,000.00.'],
        ['question' => 'And MACRS 5-year?', 'answer' => '$10,000.00 (20%, half-year convention).'],
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

    <x-calc.result label="First-year depreciation" />

    <x-calc.options :decimals="false" :examples="[
        'Straight line' => ['method' => 'sl', 'cost' => 50000, 'salvage' => 5000, 'life' => 5, 'factor' => 2, 'units' => '', 'total_units' => '', 'macrs' => '5'],
        'Double declining' => ['method' => 'db', 'cost' => 50000, 'salvage' => 5000, 'life' => 5, 'factor' => 2, 'units' => '', 'total_units' => '', 'macrs' => '5'],
        'MACRS 5-year' => ['method' => 'macrs', 'cost' => 50000, 'salvage' => 0, 'life' => 5, 'factor' => 2, 'units' => '', 'total_units' => '', 'macrs' => '5'],
        'Units' => ['method' => 'units', 'cost' => 50000, 'salvage' => 5000, 'life' => 5, 'factor' => 2, 'units' => '12000, 15000, 9000, 8000, 6000', 'total_units' => 50000, 'macrs' => '5'],
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
            <li>SL = (cost − salvage) ÷ life</li>
            <li>DB = book × factor ÷ life</li>
            <li>SYD = (cost − salvage) × remaining ÷ Σ years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
