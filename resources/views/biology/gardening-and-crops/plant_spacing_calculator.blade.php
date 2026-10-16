<x-calc.page
    title="Plant Spacing Calculator - SolveKit"
    description="Free plant spacing calculator: how many plants fit an area at a given spacing, in square or triangular patterns."
    lede="Work out how many plants fit an area at a given spacing."
    about="In a square grid each plant uses spacing × spacing. In a triangular (offset) pattern each plant uses spacing² × 0.866, so about 15% more plants fit in the same area with the same gap between them."
    :calc="['engine' => 'garden', 'tool' => 'plant_spacing', 'fields' => ['area', 'spacing', 'pattern'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the bed area', 'text' => 'Any shape, as long as you know its area.'],
        ['name' => 'Enter the spacing', 'text' => 'The recommended distance between plants, from the plant label.'],
    ]"
    :faqs="[
        ['question' => 'How many plants at 12-inch spacing in 100 ft²?', 'answer' => '100 in a square grid, about 115 in a triangular pattern.'],
        ['question' => 'Is triangular spacing better?', 'answer' => 'It fits more plants with even gaps and gives faster ground cover.'],
        ['question' => 'Do I include the bed edges?', 'answer' => 'Plant half the spacing in from the edge for best results.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Bed area" value="100" min="0" placeholder="Bed area">
            <label for="calc-area-unit" class="sr-only">Bed area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="spacing" label="Spacing" value="12" min="0" placeholder="Spacing">
            <label for="calc-spacing-unit" class="sr-only">Spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="pattern" legend="Pattern" :options="['square' => 'Square grid', 'triangular' => 'Triangular (offset)']" selected="square" />

    <x-calc.result label="Plants needed" />

    <x-calc.options :examples="[
        'Ground cover 8 in' => ['area' => 50, 'area-unit' => 'ft2', 'spacing' => 8, 'pattern' => 'triangular'],
        'Shrubs 3 ft' => ['area' => 300, 'area-unit' => 'ft2', 'spacing' => 36, 'pattern' => 'square'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'square' => ['label' => 'Square grid', 'unit' => 'plants'],
            'triangular' => ['label' => 'Triangular pattern', 'unit' => 'plants'],
            'per_m2' => ['label' => 'Plants per m²'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>square: plants = area ÷ spacing²</li>
            <li>triangular: plants = area ÷ (spacing² × 0.866)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
