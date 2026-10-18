<x-calc.page
    title="Paint Calculator - SolveKit"
    description="Free paint calculator: gallons of paint for walls and ceilings, less doors and windows, by coats and the coverage on the label."
    lede="Work out how much paint you need for a room."
    about="Paint = net area × coats ÷ coverage. Most interior wall paints list 250–400 ft² per gallon; use the figure on your can, since rough or porous surfaces take more. New drywall or a strong colour change usually needs a coat of primer."
    :calc="['engine' => 'con-finish', 'tool' => 'paint', 'fields' => ['walls', 'walls_unit', 'openings', 'openings_unit', 'ceiling', 'coverage', 'coats', 'primer', 'price'], 'unitFields' => ['ceiling' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Add doors and windows', 'text' => 'Width, height and how many.'],
        ['name' => 'Enter the coverage and coats', 'text' => 'From the paint label.'],
    ]"
    :faqs="[
        ['question' => 'How much paint for a 12 × 14 room?', 'answer' => 'About 2 gallons for two coats on 8 ft walls.'],
        ['question' => 'How much does a gallon cover?', 'answer' => 'Usually 250–400 ft²; check the label.'],
        ['question' => 'Do I need primer?', 'answer' => 'On new drywall, bare wood, stains or a big colour change.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[12, 8], [14, 8], [12, 8], [14, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 1], [3, 4, 2]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ceiling" label="Ceiling area (optional)" value="" min="0" placeholder="Not painting">
            <label for="calc-ceiling-unit" class="sr-only">Ceiling area (optional) unit</label>
            <select id="calc-ceiling-unit" name="ceiling-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="coverage" label="Coverage from the label" value="350" min="1" suffix="ft²/gal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coats" label="Coats" value="2" min="1" step="1" />
        <x-calc.checkbox name="primer" label="Add a primer coat" :checked="false" />
        <x-calc.field name="price" label="Price per gallon (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Paint needed" />

    <x-calc.options :examples="[
        '12 × 14 room, 2 coats' => ['walls' => '12 8
14 8
12 8
14 8', 'walls_unit' => 'ft', 'openings' => '3 6.67 1
3 4 2', 'openings_unit' => 'ft', 'coverage' => 350, 'coats' => 2, 'primer' => false],
        'With ceiling and primer' => ['walls' => '12 8
14 8
12 8
14 8', 'walls_unit' => 'ft', 'openings' => '3 6.67 1
3 4 2', 'openings_unit' => 'ft', 'ceiling' => 168, 'ceiling-unit' => 'ft2', 'coverage' => 350, 'coats' => 2, 'primer' => true],
        'Metric room' => ['walls' => '4 2.5
3.5 2.5
4 2.5
3.5 2.5', 'walls_unit' => 'm', 'openings' => '0.9 2.1 1
1.2 1.2 1', 'openings_unit' => 'm', 'coverage' => 400, 'coats' => 2, 'primer' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters'],
            'buy' => ['label' => 'To buy'],
            'area' => ['label' => 'Area'],
            'primer' => ['label' => 'Primer'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>paint = (walls − openings + ceiling) × coats ÷ coverage</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
