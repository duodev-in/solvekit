<x-calc.page
    title="Car Depreciation Calculator - SolveKit"
    description="Free car depreciation calculator: a car's value after each year from the first-year loss and the yearly rate after that, with cost per mile."
    lede="Estimate what your car will be worth."
    about="New cars commonly lose 15–25% in the first year and about 10–15% a year after that, depending on make and model. Value after n years = price × (1 − first) × (1 − later)^(n − 1). Enter rates from pricing guides for your model. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'car_depreciation', 'fields' => ['price', 'first', 'later', 'years', 'miles']]"
    :how-to="[
        ['name' => 'Enter the price', 'text' => ''],
        ['name' => 'Enter depreciation rates', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a $40,000 car worth after 5 years?', 'answer' => '$19,190.25.'],
        ['question' => 'What does depreciation cost per mile?', 'answer' => '$0.35.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Purchase price" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="first" label="First-year loss" value="20" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="later" label="Yearly loss after that" value="12" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="5" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="miles" label="Miles a year (optional)" value="12000" min="0" step="1" />
    </div>

    <x-calc.result label="Value after the years" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 40000, 'first' => 20, 'later' => 12, 'years' => 5, 'miles' => 12000],
        'Used car' => ['price' => 22000, 'first' => 12, 'later' => 10, 'years' => 4, 'miles' => 10000],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Value" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'lost' => ['label' => 'Total depreciation'],
            'yearly' => ['label' => 'Per year'],
            'first' => ['label' => 'First year'],
            'per_mile' => ['label' => 'Per mile'],
        ]" />
        <x-calc.grid heading="By year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = P(1 − f)(1 − r)^(n − 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
