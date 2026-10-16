<x-calc.page
    title="Percent Solution Calculator - SolveKit"
    description="Free percent solution calculator: grams or milliliters of solute for a % w/v or % v/v solution, with molarity."
    lede="Work out how much solute makes a percent (w/v or v/v) solution."
    about="A % w/v solution has that many grams per 100 mL, so 5% is 5 g per 100 mL. A % v/v solution has that many milliliters per 100 mL. Always make up to the final volume rather than adding solute to that volume of solvent."
    :calc="['engine' => 'lab', 'tool' => 'percent_solution', 'fields' => ['kind', 'percent', 'volume', 'weight'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Pick w/v or v/v', 'text' => 'w/v for solids, v/v for liquids.'],
        ['name' => 'Enter the percent and volume', 'text' => 'The final volume of solution.'],
    ]"
    :faqs="[
        ['question' => 'How do I make a 10% w/v solution?', 'answer' => 'Dissolve 10 g in a little solvent and make up to 100 mL.'],
        ['question' => 'How do I make 70% ethanol?', 'answer' => 'For v/v, 70 mL absolute ethanol made up to 100 mL with water. Starting from 95% ethanol, use the dilution calculator.'],
        ['question' => 'What is the molarity of 0.9% saline?', 'answer' => '9 g/L ÷ 58.44 g/mol ≈ 0.154 M.'],
    ]"
>
    <x-calc.segmented name="kind" legend="Type" :options="['wv' => 'w/v (g per 100 mL)', 'vv' => 'v/v (mL per 100 mL)']" selected="wv" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="percent" label="Percent" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="volume" label="Final volume" value="100" min="0" placeholder="Final volume">
            <label for="calc-volume-unit" class="sr-only">Final volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="kind:wv">
        <x-calc.field name="weight" label="Molar mass (optional)" value="58.44" min="0" suffix="g/mol" placeholder="Optional" />
    </div>

    <x-calc.result label="Solute needed" />

    <x-calc.options :examples="[
        '0.9% saline, 1 L' => ['kind' => 'wv', 'percent' => 0.9, 'volume' => 1, 'volume-unit' => 'l', 'weight' => 58.44],
        '2% agarose, 50 mL' => ['kind' => 'wv', 'percent' => 2, 'volume' => 50, 'volume-unit' => 'ml', 'weight' => ''],
        '10% glycerol v/v, 500 mL' => ['kind' => 'vv', 'percent' => 10, 'volume' => 500, 'volume-unit' => 'ml'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'solvent' => ['label' => 'Solvent'],
            'molar' => ['label' => 'Molarity'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>w/v: g = % × mL ÷ 100</li>
            <li>v/v: mL = % × mL ÷ 100</li>
            <li>M = g ÷ MW ÷ L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
