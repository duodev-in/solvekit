<x-calc.page
    title="Concrete Column Calculator - SolveKit"
    description="Free concrete column calculator: concrete volume and bags for round and square or rectangular columns."
    lede="Work out the concrete for round or square columns."
    about="A round column holds π ÷ 4 × D² × H and a rectangular one A × B × H. Multiply by the number of columns and add a little for waste."
    :calc="['engine' => 'con-concrete', 'tool' => 'column', 'fields' => ['section', 'diameter', 'side', 'other', 'height', 'count', 'waste', 'price'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'side' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'other' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Choose round or square', 'text' => 'Enter the section size.'],
        ['name' => 'Enter the height and count', 'text' => 'And add waste.'],
    ]"
    :faqs="[
        ['question' => 'How much concrete in a 16 in round column 10 ft tall?', 'answer' => '13.96 ft³, or 0.52 yd³.'],
        ['question' => 'How much in a 12 × 12 in column 10 ft tall?', 'answer' => '10 ft³, or 0.37 yd³.'],
    ]"
>
    <x-calc.segmented name="section" legend="Column" :options="['round' => 'Round', 'square' => 'Square or rectangular']" selected="round" />

    <div data-show-when="section:round">
        <x-calc.field name="diameter" label="Diameter" value="16" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="section:square" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="side" label="Side A" value="12" min="0" placeholder="Side A">
                <label for="calc-side-unit" class="sr-only">Side A unit</label>
                <select id="calc-side-unit" name="side-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="other" label="Side B" value="12" min="0" placeholder="Side B">
                <label for="calc-other-unit" class="sr-only">Side B unit</label>
                <select id="calc-other-unit" name="other-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="10" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="Columns" value="4" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per yd³ (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Concrete needed" />

    <x-calc.options :examples="[
        '4 round 16 in × 10 ft' => ['section' => 'round', 'diameter' => 16, 'diameter-unit' => 'in', 'height' => 10, 'height-unit' => 'ft', 'count' => 4, 'waste' => 5],
        '6 square 300 mm × 3 m' => ['section' => 'square', 'side' => 300, 'side-unit' => 'mm', 'other' => 300, 'other-unit' => 'mm', 'height' => 3, 'height-unit' => 'm', 'count' => 6, 'waste' => 5],
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
            'each' => ['label' => 'Per column'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>round: π ÷ 4 × D² × H</li>
            <li>square: A × B × H</li>
            <li>1 yd³ = 27 ft³ = 0.7646 m³</li>
            <li>premix yields: 80 lb = 0.60 ft³, 60 lb = 0.45 ft³, 40 lb = 0.30 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
