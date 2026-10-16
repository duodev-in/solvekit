<x-calc.page
    title="Fertilizer Calculator - SolveKit"
    description="Free fertilizer calculator: how much fertilizer to apply for a target nitrogen rate from its N-P-K numbers."
    lede="Work out how much fertilizer gives a target amount of nitrogen."
    about="The first N-P-K number is the percent nitrogen by weight. To apply a target amount of nitrogen, divide it by that percent. Lawns typically get about 1 lb of nitrogen per 1,000 ft² per feeding."
    :calc="['engine' => 'garden', 'tool' => 'fertilizer', 'fields' => ['n', 'p', 'k', 'area', 'target'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the N-P-K', 'text' => 'The three numbers on the bag, e.g. 20-5-10.'],
        ['name' => 'Enter the area and target', 'text' => 'Use your soil test or 1 lb N per 1,000 ft² for lawns.'],
    ]"
    :faqs="[
        ['question' => 'What does 10-10-10 mean?', 'answer' => '10% nitrogen, 10% phosphate (P₂O₅) and 10% potash (K₂O) by weight.'],
        ['question' => 'How much fertilizer for 1 lb of nitrogen?', 'answer' => 'Divide 1 by the N fraction: 5 lb of a 20-5-10 fertilizer.'],
        ['question' => 'How often should I fertilize a lawn?', 'answer' => 'Typically 2 to 4 times a year, depending on grass type and climate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="n" label="N (%)" value="20" min="0" />
        <x-calc.field name="p" label="P (%)" value="5" min="0" />
        <x-calc.field name="k" label="K (%)" value="10" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Area" value="5000" min="0" placeholder="Area">
            <label for="calc-area-unit" class="sr-only">Area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="target" label="Nitrogen per 1,000 ft²" value="1" min="0" step="0.1" suffix="lb" />
    </div>

    <x-calc.result label="Fertilizer needed" />

    <x-calc.options :examples="[
        'Lawn 29-0-4' => ['n' => 29, 'p' => 0, 'k' => 4, 'area' => 5000, 'target' => 1],
        'Garden 10-10-10' => ['n' => 10, 'p' => 10, 'k' => 10, 'area' => 500, 'target' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms', 'unit' => 'kg'],
            'per1000' => ['label' => 'Per 1,000 ft²', 'unit' => 'lb'],
            'p' => ['label' => 'Phosphate applied'],
            'k' => ['label' => 'Potash applied'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>product per 1,000 ft² = N target ÷ (N% ÷ 100)</li>
            <li>total = per 1,000 ft² × area ÷ 1,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
