@php
    $liquids = collect(config('substances.liquids.items'))->only(['water', 'milk', 'vegetable_oil', 'honey', 'maple_syrup', 'ethanol'])->all();
    $groups = [
        'solutions' => ['label' => 'Solutions (% w/v)', 'items' => [
            'pct1' => ['name' => '1% solution (10 mg/mL)', 'density' => 0.01],
            'pct5' => ['name' => '5% solution (50 mg/mL)', 'density' => 0.05],
            'pct10' => ['name' => '10% solution (100 mg/mL)', 'density' => 0.1],
            'pct25' => ['name' => '25% solution (250 mg/mL)', 'density' => 0.25],
            'pct50' => ['name' => '50% solution (500 mg/mL)', 'density' => 0.5],
        ]],
        'liquids' => ['label' => 'Pure liquids', 'items' => $liquids],
    ];
    $substances = collect($groups)->flatMap(fn ($group) => $group['items'])->all();
@endphp

<x-calc.page
    title="mg to mL Converter - SolveKit"
    description="Professional mg to mL converter for concentration-based calculations. Convert between weight and volume using substance concentration values."
    lede="Convert milligrams to milliliters, or back, using a concentration in mg/mL."
    about="Milliliters = milligrams ÷ concentration (mg/mL). For a solution, use the strength on the label: a 10% w/v solution has 10 g per 100 mL, which is 100 mg/mL. For a pure liquid, the concentration is its density. Always confirm medicine doses with a pharmacist."
    :calc="['engine' => 'substance', 'volumeUnits' => config('units.volume'), 'massUnits' => config('units.mass'), 'volume' => 'ml', 'mass' => 'mg', 'substances' => $substances, 'densityScale' => 1000, 'densityLabel' => 'mg/mL', 'rows' => ['volume' => ['l', 'tsp_us', 'floz_us'], 'mass' => ['g', 'ug']]]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Milligrams to milliliters, or milliliters to milligrams.'],
        ['name' => 'Set the concentration', 'text' => 'Pick a solution strength or liquid, or type the mg/mL from the label.'],
        ['name' => 'Enter the amount', 'text' => 'The result updates as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many mL is 500 mg?', 'answer' => 'It depends on the concentration. At 100 mg/mL it is 5 mL; for water (998 mg/mL) it is about 0.5 mL.'],
        ['question' => 'What does 10% w/v mean?', 'answer' => '10 grams of substance in 100 mL of solution, which is 100 mg/mL.'],
        ['question' => 'Can I use this for medicine doses?', 'answer' => 'It does the arithmetic, but always check doses with a pharmacist or the product label.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['m2v' => 'mg → mL', 'v2m' => 'mL → mg']" selected="m2v" />

    <x-calc.substance :groups="$groups" selected="pct10" label="Concentration" density-label="mg/mL" :scale="1000" />

    <x-calc.field name="value" label="Amount" value="500" min="0" suffix="mg" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="Milliliters" />

    <x-calc.options :examples="[
        '250 mg at 50 mg/mL' => ['value' => 250, 'substance' => 'pct5', 'direction' => 'm2v'],
        '5 mL at 100 mg/mL' => ['value' => 5, 'substance' => 'pct10', 'direction' => 'v2m'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Same amount in" name="also" :generated="true" />
        <x-calc.steps />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mL = mg ÷ concentration (mg/mL)</li>
            <li>mg = mL × concentration (mg/mL)</li>
            <li>x% w/v = 10x mg/mL</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
