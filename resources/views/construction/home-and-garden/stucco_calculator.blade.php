<x-calc.page
    title="Stucco Calculator - SolveKit"
    description="Free stucco calculator: stucco volume and bags for walls by system thickness, with metal lath sheets."
    lede="Work out the stucco and lath for a wall."
    about="Stucco volume = net area × total thickness. Traditional three-coat portland cement stucco is about ⅞ in (scratch ⅜, brown ⅜, finish ⅛ in, per ASTM C926); one-coat systems are about ⅜–½ in. Bag yield varies by product; enter the yield printed on yours. Expanded metal lath comes in 27 × 96 in sheets (ASTM C847), lapped 1 in."
    :calc="['engine' => 'con-finish', 'tool' => 'stucco', 'fields' => ['walls', 'walls_unit', 'openings', 'openings_unit', 'thickness', 'yield', 'waste'], 'unitFields' => ['thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'yield' => collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Add doors and windows', 'text' => 'Width, height and how many.'],
        ['name' => 'Set the thickness and bag yield', 'text' => 'From the product.'],
    ]"
    :faqs="[
        ['question' => 'How thick is three-coat stucco?', 'answer' => 'About ⅞ in: ⅜ in scratch, ⅜ in brown and ⅛ in finish.'],
        ['question' => 'How much stucco for 100 ft²?', 'answer' => 'About 7.3 ft³ at ⅞ in thick.'],
        ['question' => 'What size is metal lath?', 'answer' => '27 × 96 in (18 ft²) sheets.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[40, 9], [30, 9]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 1], [3, 4, 4]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="thickness" label="Total thickness" value="0.875" min="0" placeholder="Total thickness">
            <label for="calc-thickness-unit" class="sr-only">Total thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="yield" label="Yield per bag" value="0.83" min="0" placeholder="Yield per bag">
            <label for="calc-yield-unit" class="sr-only">Yield per bag unit</label>
            <select id="calc-yield-unit" name="yield-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['yd3', 'ft3', 'm3', 'l', 'gal_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Stucco" />

    <x-calc.options :examples="[
        'Two walls, three-coat' => ['walls' => '40 9
30 9', 'walls_unit' => 'ft', 'openings' => '3 6.67 1
3 4 4', 'openings_unit' => 'ft', 'thickness' => 0.875, 'thickness-unit' => 'in', 'yield' => 0.83, 'yield-unit' => 'ft3', 'waste' => 10],
        'One-coat, metric' => ['walls' => '10 2.7
8 2.7', 'walls_unit' => 'm', 'openings' => '1.2 1.2 3', 'openings_unit' => 'm', 'thickness' => 12, 'thickness-unit' => 'mm', 'yield' => 23, 'yield-unit' => 'l', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volume' => ['label' => 'Volume'],
            'lath' => ['label' => 'Metal lath'],
            'area' => ['label' => 'Area'],
            'bags' => ['label' => 'Bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = net area × thickness × (1 + waste)</li>
            <li>bags = volume ÷ yield</li>
            <li>lath = area ÷ (26 × 95 in)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
