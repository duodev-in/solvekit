<x-calc.page
    title="Tree Spacing Calculator - SolveKit"
    description="Free tree spacing calculator: trees needed for an area and trees per acre from spacing."
    lede="Work out how many trees fit an area at a given spacing."
    about="Each tree uses spacing in the row × spacing between rows. Dividing the area by that gives the number of trees."
    :calc="['engine' => 'forestry', 'tool' => 'spacing', 'fields' => ['area', 'spacing', 'row'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'spacing' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'row' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the area', 'text' => 'The planting site.'],
        ['name' => 'Enter the spacing', 'text' => 'In the row and between rows.'],
    ]"
    :faqs="[
        ['question' => 'How many trees per acre at 10 × 10 ft?', 'answer' => '435.'],
        ['question' => 'How far apart should fruit trees be?', 'answer' => 'Standard trees about 20 to 30 ft, dwarf trees about 8 to 12 ft.'],
        ['question' => 'What spacing for a windbreak?', 'answer' => 'Often 6 to 10 ft in the row, depending on species.'],
    ]"
>
    <x-calc.field name="area" label="Area" value="1" min="0" placeholder="Area">
        <label for="calc-area-unit" class="sr-only">Area unit</label>
        <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'acre')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spacing" label="Spacing in the row" value="10" min="0" placeholder="Spacing in the row">
            <label for="calc-spacing-unit" class="sr-only">Spacing in the row unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="row" label="Spacing between rows" value="10" min="0" placeholder="Spacing between rows">
            <label for="calc-row-unit" class="sr-only">Spacing between rows unit</label>
            <select id="calc-row-unit" name="row-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Trees needed" />

    <x-calc.options :examples="[
        'Woodlot 8 × 8 ft' => ['area' => 5, 'area-unit' => 'acre', 'spacing' => 8, 'row' => 8],
        'Orchard 20 × 20 ft' => ['area' => 2, 'area-unit' => 'acre', 'spacing' => 20, 'row' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_acre' => ['label' => 'Trees per acre'],
            'per_ha' => ['label' => 'Trees per hectare'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>trees = area ÷ (in-row spacing × row spacing)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
