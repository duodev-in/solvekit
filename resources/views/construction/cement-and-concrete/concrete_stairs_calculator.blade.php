<x-calc.page
    title="Concrete Stairs Calculator - SolveKit"
    description="Free concrete stairs calculator: concrete for solid steps on grade, with an optional top landing, in cubic yards and bags."
    lede="Work out the concrete for a flight of solid concrete steps."
    about="Solid steps on grade are a stack of blocks: step k (counting from the bottom) is k risers tall, so the volume is W × R × T × n(n + 1) ÷ 2. A top landing adds W × landing depth × the full height. Residential stairs need risers of at most 7¾ in and treads of at least 10 in (IRC R311.7.5)."
    :calc="['engine' => 'con-concrete', 'tool' => 'stairs', 'fields' => ['steps', 'stair_width', 'rise', 'run_depth', 'landing', 'waste', 'price'], 'unitFields' => ['stair_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rise' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'run_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'landing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Enter the steps', 'text' => 'Number, rise, run and width.'],
        ['name' => 'Add a landing', 'text' => 'If the top step is a platform.'],
    ]"
    :faqs="[
        ['question' => 'How much concrete for 3 steps?', 'answer' => 'For 4 ft wide with 7 in risers and 11 in treads: about 0.48 yd³ (12.8 ft³).'],
        ['question' => 'What is a comfortable step?', 'answer' => 'Twice the rise plus the run close to 25 in, for example 7 in risers with 11 in treads.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Number of steps" value="3" min="1" step="1" />
        <x-calc.field name="stair_width" label="Width" value="48" min="0" placeholder="Width">
            <label for="calc-stair_width-unit" class="sr-only">Width unit</label>
            <select id="calc-stair_width-unit" name="stair_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rise" label="Rise per step" value="7" min="0" placeholder="Rise per step">
            <label for="calc-rise-unit" class="sr-only">Rise per step unit</label>
            <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="run_depth" label="Run per step" value="11" min="0" placeholder="Run per step">
            <label for="calc-run_depth-unit" class="sr-only">Run per step unit</label>
            <select id="calc-run_depth-unit" name="run_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="landing" label="Top landing depth (optional)" value="" min="0" placeholder="Top landing depth (optional)">
            <label for="calc-landing-unit" class="sr-only">Top landing depth (optional) unit</label>
            <select id="calc-landing-unit" name="landing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per yd³ (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Concrete needed" />

    <x-calc.options :examples="[
        '3 steps, 4 ft wide' => ['steps' => 3, 'stair_width' => 48, 'stair_width-unit' => 'in', 'rise' => 7, 'rise-unit' => 'in', 'run_depth' => 11, 'run_depth-unit' => 'in', 'waste' => 5],
        '4 steps with a 4 ft landing' => ['steps' => 4, 'stair_width' => 60, 'stair_width-unit' => 'in', 'rise' => 7, 'rise-unit' => 'in', 'run_depth' => 11, 'run_depth-unit' => 'in', 'landing' => 48, 'landing-unit' => 'in', 'waste' => 5],
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
            'rise' => ['label' => 'Total rise and run'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = W × R × T × n(n + 1) ÷ 2 + W × landing × n × R</li>
            <li>1 yd³ = 27 ft³ = 0.7646 m³</li>
            <li>premix yields: 80 lb = 0.60 ft³, 60 lb = 0.45 ft³, 40 lb = 0.30 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
