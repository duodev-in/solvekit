<x-calc.page
    title="Angle of Repose Calculator - SolveKit"
    description="Free angle of repose calculator: the steepest stable slope of a pile from its height and radius or friction coefficient."
    lede="Find the angle of repose of a pile."
    about="Loose granular material settles into a cone whose sides slope at the angle of repose: the steepest angle at which it stays put. tan θ equals the effective internal friction, so it can be measured from a pile’s height and radius."
    :calc="['engine' => 'ph-mat', 'tool' => 'angle_repose', 'fields' => ['mode', 'h', 'r', 'mu', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the angle of a pile 2 m high and 3 m in radius?', 'answer' => '33.6901 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['pile' => 'Pile height and radius', 'mu' => 'The friction coefficient']" selected="pile" />
        <div data-show-when="mode:pile">
            <x-calc.field name="h" label="Pile height" value="2" placeholder="Pile height">
                <label for="calc-h-unit" class="sr-only">Pile height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:pile">
            <x-calc.field name="r" label="Pile base radius" value="3" placeholder="Pile base radius">
                <label for="calc-r-unit" class="sr-only">Pile base radius unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:mu">
            <x-calc.field name="mu" label="Coefficient of friction" value="0.7" min="0" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Angle of repose" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'mode' => 'pile', 'h' => 2, 'h-unit' => 'm', 'r' => 3, 'r-unit' => 'm', 'mu' => 0.7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mu' => ['label' => 'Equivalent friction coefficient tan θ'],
            'vol' => ['label' => 'Volume of a conical pile'],
            'typical' => ['label' => 'Typical angles'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
