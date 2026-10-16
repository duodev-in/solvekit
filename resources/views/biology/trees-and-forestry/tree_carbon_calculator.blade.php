<x-calc.page
    title="Tree Carbon Sequestration Calculator - SolveKit"
    description="Free tree carbon calculator: estimate the CO₂ stored in a tree from its diameter and height."
    lede="Estimate how much CO₂ a tree has stored."
    about="Green weight is estimated from DBH and height (0.25 D²H below 11 in, 0.15 D²H above), plus 20% for roots. About 72.5% is dry matter and half of that is carbon; carbon × 3.67 gives the CO₂ it represents. This is a rough estimate."
    :calc="['engine' => 'forestry', 'tool' => 'carbon', 'fields' => ['dbh', 'height'], 'unitFields' => ['dbh' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the trunk', 'text' => 'Diameter at breast height.'],
        ['name' => 'Estimate the height', 'text' => 'Use the tree height calculator if needed.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ does a tree absorb a year?', 'answer' => 'A mature tree typically absorbs tens of pounds a year, depending on species and growth.'],
        ['question' => 'Why multiply carbon by 3.67?', 'answer' => 'CO₂ weighs 44/12 as much as the carbon in it.'],
        ['question' => 'How accurate is this?', 'answer' => 'Roughly ±30%; species-specific equations are more precise.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dbh" label="Trunk diameter" value="18" min="0" placeholder="Trunk diameter">
            <label for="calc-dbh-unit" class="sr-only">Trunk diameter unit</label>
            <select id="calc-dbh-unit" name="dbh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Tree height" value="60" min="0" placeholder="Tree height">
            <label for="calc-height-unit" class="sr-only">Tree height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="CO₂ stored (estimate)" />

    <x-calc.options :examples="[
        'Oak 24 in × 70 ft' => ['dbh' => 24, 'height' => 70],
        'Young tree 8 in × 25 ft' => ['dbh' => 8, 'height' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms of CO₂', 'unit' => 'kg'],
            'green' => ['label' => 'Green weight'],
            'dry' => ['label' => 'Dry weight'],
            'carbon' => ['label' => 'Carbon'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>green = 0.25 D²H (D < 11 in) or 0.15 D²H, × 1.2 for roots</li>
            <li>CO₂ = green × 0.725 × 0.5 × 3.6663</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
