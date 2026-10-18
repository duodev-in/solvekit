<x-calc.page
    title="Concrete Driveway Cost Calculator - SolveKit"
    description="Free concrete driveway cost calculator: concrete volume and total cost from your prices for concrete, reinforcement, labor, removal and base."
    lede="Work out the cost of a concrete driveway from your local prices."
    about="The concrete volume is exact for the size and thickness; the cost uses the prices you enter, so get local quotes. Driveways for cars are usually 4–5 in thick, 6 in for heavier vehicles."
    :calc="['engine' => 'con-concrete', 'tool' => 'driveway_cost', 'fields' => ['length', 'width', 'thickness', 'concrete_price', 'waste', 'reinforcement', 'labor', 'removal', 'base'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the size and thickness', 'text' => 'Of the finished slab.'],
        ['name' => 'Enter your local prices', 'text' => 'The example prices are only placeholders.'],
    ]"
    :faqs="[
        ['question' => 'How much concrete for a 12 × 50 ft driveway?', 'answer' => 'About 9.3 yd³ at 5 in thick, before waste.'],
        ['question' => 'How thick should a concrete driveway be?', 'answer' => '4 in minimum for cars, 5–6 in for trucks or heavy loads.'],
        ['question' => 'Are the default prices real?', 'answer' => 'They are example figures only; enter quotes from local suppliers.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="50" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="12" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="thickness" label="Thickness" value="5" min="0" placeholder="Thickness">
            <label for="calc-thickness-unit" class="sr-only">Thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="concrete_price" label="Concrete price per yd³" value="165" min="0" step="0.01" suffix="$" />
        <x-calc.field name="waste" label="Extra concrete" value="5" min="0" max="100" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="reinforcement" label="Reinforcement per ft² (optional)" value="0.5" min="0" step="0.01" suffix="$" />
        <x-calc.field name="labor" label="Labor and finishing per ft² (optional)" value="4" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="removal" label="Old surface removal per ft² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="0" />
        <x-calc.field name="base" label="Base preparation per ft² (optional)" value="1" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Driveway cost" />

    <x-calc.options :examples="[
        '12 × 50 ft, 5 in' => ['length' => 50, 'length-unit' => 'ft', 'width' => 12, 'width-unit' => 'ft', 'thickness' => 5, 'thickness-unit' => 'in', 'concrete_price' => 165, 'waste' => 5, 'reinforcement' => 0.5, 'labor' => 4, 'base' => 1],
        'Two-car 24 × 24 ft, 6 in' => ['length' => 24, 'length-unit' => 'ft', 'width' => 24, 'width-unit' => 'ft', 'thickness' => 6, 'thickness-unit' => 'in', 'concrete_price' => 165, 'waste' => 5, 'reinforcement' => 0.75, 'labor' => 4.5, 'removal' => 2, 'base' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'yd3' => ['label' => 'Concrete'],
            'per_ft2' => ['label' => 'Per square foot'],
            'area' => ['label' => 'Area'],
            'trucks' => ['label' => 'Truckloads'],
        ]" />
        <x-calc.quick-ref heading="Cost breakdown" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>concrete = L × W × t × (1 + waste)</li>
            <li>cost = concrete × price + area × (reinforcement + labor + removal + base)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
