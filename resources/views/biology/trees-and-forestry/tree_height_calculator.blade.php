<x-calc.page
    title="Tree Height Calculator - SolveKit"
    description="Free tree height calculator: measure tree height with a clinometer angle, two angles, or the shadow method."
    lede="Measure a tree's height with an angle reading or its shadow."
    about="With a clinometer, height = distance × tan(angle to the top) + your eye height on level ground; on slopes, add the angles to the top and to the base. With shadows, the tree's height is to its shadow as a stick's height is to the stick's shadow."
    :calc="['engine' => 'forestry', 'tool' => 'height', 'fields' => ['method', 'distance', 'angle', 'eye', 'base_angle', 'shadow', 'stick', 'stick_shadow'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'eye' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'shadow' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'stick' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'stick_shadow' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Pick a method', 'text' => 'Angle with a clinometer or phone app, or shadows on a sunny day.'],
        ['name' => 'Take your measurements', 'text' => 'Stand where you can see the top clearly, about as far away as the tree is tall.'],
    ]"
    :faqs="[
        ['question' => 'How do I measure a tree with my phone?', 'answer' => 'Use a clinometer app to read the angle to the top, and pace the distance to the trunk.'],
        ['question' => 'Why add eye height?', 'answer' => 'The angle is measured from your eyes, not the ground.'],
        ['question' => 'What if the ground slopes?', 'answer' => 'Use the two-angle method: angle to the top plus angle down to the base.'],
    ]"
>
    <x-calc.segmented name="method" legend="Method" :options="['angle' => 'Angle', 'two_angles' => 'Two angles', 'shadow' => 'Shadow']" selected="angle" />

    <div data-show-when="method:angle,two_angles">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="distance" label="Distance to tree" value="50" min="0" placeholder="Distance to tree">
                <label for="calc-distance-unit" class="sr-only">Distance to tree unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="angle" label="Angle to top" value="40" min="0" max="89.9" suffix="°" />
        </div>
    </div>

    <div data-show-when="method:angle">
        <x-calc.field name="eye" label="Eye height" value="5.5" min="0" placeholder="Eye height">
            <label for="calc-eye-unit" class="sr-only">Eye height unit</label>
            <select id="calc-eye-unit" name="eye-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="method:two_angles" hidden>
        <x-calc.field name="base_angle" label="Angle to base (below eye level)" value="5" min="0" max="89.9" suffix="°" />
    </div>

    <div data-show-when="method:shadow" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="shadow" label="Tree shadow" value="60" min="0" placeholder="Tree shadow">
                <label for="calc-shadow-unit" class="sr-only">Tree shadow unit</label>
                <select id="calc-shadow-unit" name="shadow-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="stick" label="Stick height" value="3" min="0" placeholder="Stick height">
                <label for="calc-stick-unit" class="sr-only">Stick height unit</label>
                <select id="calc-stick-unit" name="stick-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="stick_shadow" label="Stick shadow" value="4" min="0" placeholder="Stick shadow">
                <label for="calc-stick_shadow-unit" class="sr-only">Stick shadow unit</label>
                <select id="calc-stick_shadow-unit" name="stick_shadow-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Tree height" />

    <x-calc.options :examples="[
        '45° at 60 ft' => ['method' => 'angle', 'distance' => 60, 'angle' => 45, 'eye' => 5.5],
        'Shadow 50 ft' => ['method' => 'shadow', 'shadow' => 50, 'stick' => 3, 'stick_shadow' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same height in" :grow="true" :rows="[
            'meters' => ['label' => 'Meters', 'unit' => 'm'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>h = d × tan(θ) + eye height</li>
            <li>slope: h = d × (tan θtop + tan θbase)</li>
            <li>shadow: h = tree shadow × stick ÷ stick shadow</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
