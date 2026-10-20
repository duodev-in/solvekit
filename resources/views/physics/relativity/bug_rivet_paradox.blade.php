<x-calc.page
    title="Bug-Rivet Paradox - SolveKit"
    description="Free bug-rivet paradox calculator: whether a bug at the bottom of a hole survives a relativistic rivet."
    lede="Explore the bug-rivet paradox."
    about="A rivet shorter than the hole should miss the bug, but in the rivet’s frame the hole is contracted. The resolution: nothing is perfectly rigid, so the tip keeps moving after the head stops."
    :calc="['engine' => 'ph-astro', 'tool' => 'bug_rivet', 'fields' => ['shank', 'hole', 'v'], 'unitFields' => ['shank' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'hole' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Does the bug survive the example?', 'answer' => 'No, it is squashed.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shank" label="Rivet shank length (at rest)" value="1" placeholder="Rivet shank length (at rest)">
            <label for="calc-shank-unit" class="sr-only">Rivet shank length (at rest) unit</label>
            <select id="calc-shank-unit" name="shank-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hole" label="Hole depth to the bug (at rest)" value="1.2" placeholder="Hole depth to the bug (at rest)">
            <label for="calc-hole-unit" class="sr-only">Hole depth to the bug (at rest) unit</label>
            <select id="calc-hole-unit" name="hole-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Rivet speed" value="0.8" placeholder="Rivet speed">
            <label for="calc-v-unit" class="sr-only">Rivet speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Does the bug survive?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shank' => 1, 'shank-unit' => 'cm', 'hole' => 1.2, 'hole-unit' => 'cm', 'v' => 0.8, 'v-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'holeFrame' => ['label' => 'Hole frame'],
            'rivetFrame' => ['label' => 'Rivet frame'],
            'tip' => ['label' => 'How far the tip gets'],
            'resolution' => ['label' => 'Resolution'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
