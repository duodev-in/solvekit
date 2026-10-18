<x-calc.page
    title="Sonotube Calculator - SolveKit"
    description="Free Sonotube calculator: concrete for round cardboard form tubes (6–48 in) for piers and footings, in cubic yards and premix bags."
    lede="Work out the concrete to fill round form tubes for piers and deck footings."
    about="Each tube holds π ÷ 4 × D² × height. Common tube sizes are 6–24 in and up to 48 in. The volume is exact for the tube; add extra for a flared footing or over-dig at the bottom. This also covers the concrete estimator for tubes."
    :calc="['engine' => 'con-concrete', 'tool' => 'sonotube', 'fields' => ['tube', 'diameter', 'height', 'count', 'waste', 'price'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Pick the tube size', 'text' => 'Or enter another diameter.'],
        ['name' => 'Enter the height and number', 'text' => 'The full depth the tube is filled.'],
    ]"
    :faqs="[
        ['question' => 'How many bags for a 12 in Sonotube 4 ft deep?', 'answer' => '3.14 ft³, about 6 bags of 80 lb.'],
        ['question' => 'How deep should deck footings be?', 'answer' => 'Below the frost line, and at least 12 in under IRC R403.1.4.'],
        ['question' => 'What size tube for a 6×6 post?', 'answer' => '10–12 in tubes are common; the footing size comes from the load and soil.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="tube" label="Tube diameter" :options="['6' => '6 in', '8' => '8 in', '10' => '10 in', '12' => '12 in', '14' => '14 in', '16' => '16 in', '18' => '18 in', '20' => '20 in', '24' => '24 in', '30' => '30 in', '36' => '36 in', '48' => '48 in', 'custom' => 'Other size']" selected="12" />
        <div data-show-when="tube:custom" hidden>
            <x-calc.field name="diameter" label="Diameter" value="300" min="0" placeholder="Diameter">
                <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height (depth)" value="4" min="0" placeholder="Height (depth)">
            <label for="calc-height-unit" class="sr-only">Height (depth) unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="Tubes" value="8" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per yd³ (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Concrete needed" />

    <x-calc.options :examples="[
        '8 tubes 12 in × 4 ft' => ['tube' => '12', 'height' => 4, 'height-unit' => 'ft', 'count' => 8, 'waste' => 5],
        '4 tubes 10 in × 3 ft' => ['tube' => '10', 'height' => 3, 'height-unit' => 'ft', 'count' => 4, 'waste' => 5],
        '300 mm × 1.2 m' => ['tube' => 'custom', 'diameter' => 300, 'diameter-unit' => 'mm', 'height' => 1.2, 'height-unit' => 'm', 'count' => 6, 'waste' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm3' => ['label' => 'Cubic meters'],
            'ft3' => ['label' => 'Cubic feet'],
            'bags_80' => ['label' => '80 lb bags'],
            'bags_60' => ['label' => '60 lb bags'],
            'bags_50' => ['label' => '50 lb bags'],
            'bags_40' => ['label' => '40 lb bags'],
            'weight' => ['label' => 'Weight'],
            'cost' => ['label' => 'Cost'],
            'each' => ['label' => 'Per tube'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = π ÷ 4 × D² × H × tubes</li>
            <li>1 yd³ = 27 ft³ = 0.7646 m³</li>
            <li>premix yields: 80 lb = 0.60 ft³, 60 lb = 0.45 ft³, 40 lb = 0.30 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
