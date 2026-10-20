<x-calc.page
    title="Mechanical Advantage Calculator - SolveKit"
    description="Free mechanical advantage calculator: ideal MA of levers, pulleys, wheels and axles, ramps, screws and wedges."
    lede="Find a machine’s mechanical advantage."
    about="Simple machines trade distance for force. The ideal mechanical advantage is the ratio of the distance the effort moves to the distance the load moves."
    :calc="['engine' => 'ph-mach', 'tool' => 'mech_advantage', 'fields' => ['machine', 'e', 'l', 'ropes', 'load'], 'unitFields' => ['e' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'l' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'load' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the MA of a 4-rope pulley?', 'answer' => '4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="machine" label="Machine" :options="['lever' => 'Lever', 'pulley' => 'Pulley system', 'wheel' => 'Wheel and axle', 'ramp' => 'Inclined plane (ramp)', 'screw' => 'Screw', 'wedge' => 'Wedge']" selected="pulley" />
        <div data-show-when="machine:lever,wheel,ramp,screw,wedge">
            <x-calc.field name="e" label="Effort arm or wheel radius or ramp length or handle radius or wedge length" value="100" placeholder="Effort arm or wheel radius or ramp length or handle radius or wedge length">
                <label for="calc-e-unit" class="sr-only">Effort arm or wheel radius or ramp length or handle radius or wedge length unit</label>
                <select id="calc-e-unit" name="e-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="machine:lever,wheel,ramp,screw,wedge">
            <x-calc.field name="l" label="Load arm or axle radius or ramp height or thread lead or wedge thickness" value="25" placeholder="Load arm or axle radius or ramp height or thread lead or wedge thickness">
                <label for="calc-l-unit" class="sr-only">Load arm or axle radius or ramp height or thread lead or wedge thickness unit</label>
                <select id="calc-l-unit" name="l-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="machine:pulley">
            <x-calc.field name="ropes" label="Rope segments supporting the load" value="4" min="1" step="any" />
        </div>
        <x-calc.field name="load" label="Load (optional)" value="1000" placeholder="Load (optional)">
            <label for="calc-load-unit" class="sr-only">Load (optional) unit</label>
            <select id="calc-load-unit" name="load-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Ideal mechanical advantage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['machine' => 'pulley', 'e' => 100, 'e-unit' => 'cm', 'l' => 25, 'l-unit' => 'cm', 'ropes' => 4, 'load' => 1000, 'load-unit' => 'n'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'effort' => ['label' => 'Effort needed for that load (no friction)'],
            'distance' => ['label' => 'Effort distance per unit of load movement'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
