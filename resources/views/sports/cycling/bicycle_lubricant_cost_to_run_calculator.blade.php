<x-calc.page
    title="Bicycle Lubricant Cost-to-Run Calculator - SolveKit"
    description="Free bicycle lubricant cost calculator: chain lube cost per year and per 1,000 km."
    lede="Find your chain-lube cost."
    about="The cost of lubricating a chain depends on the bottle price, how much you use and how often."
    :calc="['engine' => 'sp-cycle', 'tool' => 'lube_cost', 'fields' => ['price', 'ml', 'per', 'km', 'year'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does the example rider spend a year?', 'answer' => '$7.50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price of a bottle" value="12" min="0" step="any" suffix="$" />
        <x-calc.field name="ml" label="Bottle size (ml)" value="120" min="1" step="any" />
        <x-calc.field name="per" label="Lube per application (ml)" value="3" min="0" step="any" />
        <x-calc.field name="km" label="Kilometres between applications" value="200" min="1" step="any" />
        <x-calc.field name="year" label="Kilometres ridden a year" value="5000" min="0" step="any" />
    </div>

    <x-calc.result label="Cost per year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 12, 'ml' => 120, 'per' => 3, 'km' => 200, 'year' => 5000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'per1000' => ['label' => 'Cost per 1,000 km'],
            'bottles' => ['label' => 'Bottles a year'],
            'apps' => ['label' => 'Applications a year'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
