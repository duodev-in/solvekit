<x-calc.page
    title="Cycling Breakaway Calculator - SolveKit"
    description="Free breakaway calculator: whether a chasing group catches a breakaway before the finish."
    lede="Will the breakaway survive?"
    about="A breakaway survives if the chase cannot close the gap before the line. The closing speed is the difference between the two groups’ speeds."
    :calc="['engine' => 'sp-cycle', 'tool' => 'breakaway', 'fields' => ['gap', 'D', 'vb', 'vc'], 'unitFields' => ['gap' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'vb' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'vc' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Does a 1-minute gap survive 20 km at 42 against 46 km/h?', 'answer' => 'Yes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gap" label="Gap" value="60" placeholder="Gap">
            <label for="calc-gap-unit" class="sr-only">Gap unit</label>
            <select id="calc-gap-unit" name="gap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D" label="Distance to the finish" value="20" placeholder="Distance to the finish">
            <label for="calc-D-unit" class="sr-only">Distance to the finish unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vb" label="Breakaway speed" value="42" placeholder="Breakaway speed">
            <label for="calc-vb-unit" class="sr-only">Breakaway speed unit</label>
            <select id="calc-vb-unit" name="vb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vc" label="Chasing group speed" value="46" placeholder="Chasing group speed">
            <label for="calc-vc-unit" class="sr-only">Chasing group speed unit</label>
            <select id="calc-vc-unit" name="vc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Does the chase catch them?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['gap' => 60, 'gap-unit' => 's', 'D' => 20, 'D-unit' => 'km', 'vb' => 42, 'vb-unit' => 'kmh', 'vc' => 46, 'vc-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'where' => ['label' => 'Catch point'],
            'stay' => ['label' => 'Speed the breakaway needs to stay away'],
            'finish' => ['label' => 'Gap at the finish if not caught'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
