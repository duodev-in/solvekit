<x-calc.page
    title="Plant Population Calculator - SolveKit"
    description="Free plant population calculator: plants per acre and per hectare from row width and in-row spacing."
    lede="Work out plants per acre from row width and in-row spacing."
    about="Each plant occupies row width × in-row spacing. Dividing an acre (43,560 ft²) or a hectare (10,000 m²) by that area gives the population."
    :calc="['engine' => 'garden', 'tool' => 'plant_population', 'fields' => ['row', 'spacing'], 'unitFields' => ['row' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the row width', 'text' => 'Distance between rows.'],
        ['name' => 'Enter the in-row spacing', 'text' => 'Distance between plants in a row.'],
    ]"
    :faqs="[
        ['question' => 'What is a typical corn population?', 'answer' => 'Often 30,000 to 36,000 plants per acre in 30-inch rows.'],
        ['question' => 'How do I convert to plants per hectare?', 'answer' => 'Multiply plants per acre by 2.471.'],
        ['question' => 'Should I plant extra seed?', 'answer' => 'Yes: divide the target by germination and survival rates.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="row" label="Row width" value="30" min="0" placeholder="Row width">
            <label for="calc-row-unit" class="sr-only">Row width unit</label>
            <select id="calc-row-unit" name="row-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="spacing" label="In-row spacing" value="6" min="0" placeholder="In-row spacing">
            <label for="calc-spacing-unit" class="sr-only">In-row spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Plant population" />

    <x-calc.options :examples="[
        'Corn 30 in rows' => ['row' => 30, 'spacing' => 6],
        'Soybeans 15 in rows' => ['row' => 15, 'spacing' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hectare' => ['label' => 'Plants per hectare'],
            'm2' => ['label' => 'Plants per m²'],
            'per_row_ft' => ['label' => 'Plants per foot of row'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>plants/acre = 43,560 ÷ (row ft × spacing ft)</li>
            <li>plants/ha = 10,000 ÷ (row m × spacing m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
