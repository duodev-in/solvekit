<x-calc.page
    title="Watts to Lux Calculator - SolveKit"
    description="Free watts to lux calculator: illuminance from lamp power, lamp type and area lit."
    lede="Estimate lux from watts."
    about="Lamps differ hugely in how many lumens they give per watt. Lux is lumens per square metre after allowing for the light that misses the area."
    :calc="['engine' => 'ph-em', 'tool' => 'watts_lux', 'fields' => ['W', 'lamp', 'eff', 'A', 'uf', 'out'], 'unitFields' => ['W' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'illuminance', 'length', 'mass', 'power', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['lamps'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 100 W LED give over 20 m²?', 'answer' => 'About 300 lx.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="W" label="Lamp power" value="100" min="0" placeholder="Lamp power">
            <label for="calc-W-unit" class="sr-only">Lamp power unit</label>
            <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="lamp" label="Lamp type" :options="['incandescent' => 'Incandescent', 'halogen' => 'Halogen', 'cfl' => 'Compact fluorescent', 'fluorescent' => 'Fluorescent tube (T5/T8)', 'metal_halide' => 'Metal halide', 'hps' => 'High-pressure sodium', 'led' => 'LED', 'custom' => 'Other (enter the value)']" selected="led" />
        <div data-show-when="lamp:custom">
            <x-calc.field name="eff" label="Efficacy (lm/W)" value="100" min="0" step="any" />
        </div>
        <x-calc.field name="A" label="Area lit" value="20" min="0" placeholder="Area lit">
            <label for="calc-A-unit" class="sr-only">Area lit unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="uf" label="Share of light reaching the area (%)" value="60" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['lx' => 'lx', 'fc' => 'fc', 'phot' => 'ph', 'klx' => 'klx']" selected="lx" />
    </div>

    <x-calc.result label="Average illuminance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'lx', 'W' => 100, 'W-unit' => 'w', 'lamp' => 'led', 'eff' => 100, 'A' => 20, 'A-unit' => 'm2', 'uf' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lm' => ['label' => 'Light output'],
            'fc' => ['label' => 'In foot-candles'],
            'need' => ['label' => 'Typical needs'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
