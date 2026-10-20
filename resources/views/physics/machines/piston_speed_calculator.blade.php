<x-calc.page
    title="Piston Speed Calculator - SolveKit"
    description="Free piston speed calculator: mean and peak piston speed from stroke, rpm and rod length."
    lede="Find piston speed."
    about="Mean piston speed is 2 × stroke × rpm. It limits how fast an engine can safely rev. Peak speed is higher, and its crank angle depends on the rod length."
    :calc="['engine' => 'ph-mach', 'tool' => 'piston_speed', 'fields' => ['stroke', 'rpm', 'rod', 'out'], 'unitFields' => ['stroke' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rod' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the mean piston speed at 7,000 rpm with an 86 mm stroke?', 'answer' => '20.0667 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stroke" label="Stroke" value="86" placeholder="Stroke">
            <label for="calc-stroke-unit" class="sr-only">Stroke unit</label>
            <select id="calc-stroke-unit" name="stroke-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rpm" label="Engine speed (rpm)" value="7000" min="0" step="any" />
        <x-calc.field name="rod" label="Connecting rod length (optional)" value="143" placeholder="Connecting rod length (optional)">
            <label for="calc-rod-unit" class="sr-only">Connecting rod length (optional) unit</label>
            <select id="calc-rod-unit" name="rod-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Mean piston speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'stroke' => 86, 'stroke-unit' => 'mm', 'rpm' => 7000, 'rod' => 143, 'rod-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'max' => ['label' => 'Peak piston speed'],
            'at' => ['label' => 'Crank angle of the peak'],
            'limit' => ['label' => 'Typical limits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
