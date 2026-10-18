<x-calc.page
    title="Hammock Hang Calculator - SolveKit"
    description="Free hammock hang calculator: how high to hang a hammock and how long the straps must be for a 30° hang, with the tension on each anchor."
    lede="Work out where to hang a hammock and the load on the trees."
    about="Each suspension line runs from its anchor down at the hang angle to the hammock end; the ends are held apart by the ridgeline (often 83% of the hammock's length). Hang height = sit height + the hammock's sag below its ends + the drop of the suspension. Tension on each anchor = weight ÷ (2 × sin angle): at 30° it equals your weight, and flatter hangs pull much harder."
    :calc="['engine' => 'ev-fun', 'tool' => 'hammock', 'fields' => ['distance', 'ridgeline', 'angle', 'sit', 'sag', 'weight'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'ridgeline' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'sit' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'sag' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Measure the anchor distance', 'text' => 'Tree to tree.'],
        ['name' => 'Enter the hammock and your weight', 'text' => 'Ridgeline, sag and sit height.'],
    ]"
    :faqs="[
        ['question' => 'How high should I hang my hammock?', 'answer' => 'With trees 15 ft apart, a 9 ft ridgeline, 18 in of sag and an 18 in sit height, about 57 in (4.7 ft) up each tree at 30°.'],
        ['question' => 'Why a 30° angle?', 'answer' => 'It balances comfort with low strain: each anchor carries about your weight.'],
        ['question' => 'What if I hang it tight?', 'answer' => 'At 10° the pull on each tree is nearly three times your weight.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="distance" label="Distance between anchors" value="15" min="0" placeholder="Distance between anchors">
            <label for="calc-distance-unit" class="sr-only">Distance between anchors unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ridgeline" label="Ridgeline length" value="108" min="0" placeholder="Ridgeline length">
            <label for="calc-ridgeline-unit" class="sr-only">Ridgeline length unit</label>
            <select id="calc-ridgeline-unit" name="ridgeline-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="angle" label="Hang angle" value="30" min="5" max="60" step="1" suffix="°" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sit" label="Sit height" value="18" min="0" placeholder="Sit height">
            <label for="calc-sit-unit" class="sr-only">Sit height unit</label>
            <select id="calc-sit-unit" name="sit-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sag" label="Hammock sag below its ends" value="18" min="0" placeholder="Hammock sag below its ends">
            <label for="calc-sag-unit" class="sr-only">Hammock sag below its ends unit</label>
            <select id="calc-sag-unit" name="sag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Your weight" value="180" min="0" placeholder="Your weight">
            <label for="calc-weight-unit" class="sr-only">Your weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Hang point height" />

    <x-calc.options :decimals="false" :examples="[
        '15 ft apart, 30°' => ['distance' => 15, 'distance-unit' => 'ft', 'ridgeline' => 108, 'ridgeline-unit' => 'in', 'angle' => 30, 'sit' => 18, 'sit-unit' => 'in', 'sag' => 18, 'sag-unit' => 'in', 'weight' => 180, 'weight-unit' => 'lb'],
        'Tight hang, 15°' => ['distance' => 14, 'distance-unit' => 'ft', 'ridgeline' => 108, 'ridgeline-unit' => 'in', 'angle' => 15, 'sit' => 18, 'sit-unit' => 'in', 'sag' => 16, 'sag-unit' => 'in', 'weight' => 180, 'weight-unit' => 'lb'],
        'Metric' => ['distance' => 5, 'distance-unit' => 'm', 'ridgeline' => 270, 'ridgeline-unit' => 'cm', 'angle' => 30, 'sit' => 45, 'sit-unit' => 'cm', 'sag' => 45, 'sag-unit' => 'cm', 'weight' => 75, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'strap' => ['label' => 'Suspension length'],
            'tension' => ['label' => 'Tension'],
            'angle' => ['label' => 'Angle'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>height = sit + sag + (D − RL)/2 × tan θ</li>
            <li>tension = W ÷ (2 sin θ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
