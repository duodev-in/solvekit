<x-calc.page
    title="Compression Ratio to PSI Calculator - SolveKit"
    description="Free compression ratio to PSI calculator: estimated cranking compression pressure from the static or dynamic compression ratio, altitude and cam timing."
    lede="Estimate the compression gauge reading for an engine."
    about="Cranking pressure ≈ atmospheric pressure × CR^n − atmospheric pressure. The exponent n is about 1.2 for a cranking engine, which loses heat; 1.4 would apply with no heat loss. A cam that closes the intake valve late traps less air, so enter the intake closing point (degrees after bottom dead center), rod length and stroke to use the dynamic compression ratio. Treat the answer as an estimate and compare cylinders with each other."
    :calc="['engine' => 'ev-transport', 'tool' => 'cr_psi', 'fields' => ['ratio', 'altitude', 'ivc', 'stroke', 'rod', 'n'], 'unitFields' => ['altitude' => collect(config('units.length'))->only(['ft', 'm'])->all(), 'stroke' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'rod' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the compression ratio', 'text' => 'And your altitude.'],
        ['name' => 'Add cam timing', 'text' => 'For the dynamic ratio; clear it to use the static ratio.'],
    ]"
    :faqs="[
        ['question' => 'What PSI should a 10:1 engine have?', 'answer' => 'About 160–190 psi with typical cams at sea level.'],
        ['question' => 'Why is my reading lower at altitude?', 'answer' => 'Thinner air starts at a lower pressure.'],
        ['question' => 'What matters most in a compression test?', 'answer' => 'All cylinders within about 10% of each other.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ratio" label="Static compression ratio" value="10" min="1.1" step="0.1" suffix=":1" />
        <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="ivc" label="Intake closes (ABDC)" value="60" min="0" max="110" step="1" suffix="°" />
        <x-calc.field name="stroke" label="Stroke" value="3.48" min="0" placeholder="Stroke">
            <label for="calc-stroke-unit" class="sr-only">Stroke unit</label>
            <select id="calc-stroke-unit" name="stroke-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rod" label="Rod length" value="5.7" min="0" placeholder="Rod length">
            <label for="calc-rod-unit" class="sr-only">Rod length unit</label>
            <select id="calc-rod-unit" name="rod-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Exponent n" value="1.2" min="1" max="1.4" step="0.05" />
    </div>

    <x-calc.result label="Estimated cranking pressure (gauge)" />

    <x-calc.options :examples="[
        '10:1, 60° ABDC' => ['ratio' => 10, 'altitude' => 0, 'altitude-unit' => 'ft', 'ivc' => 60, 'stroke' => 3.48, 'stroke-unit' => 'in', 'rod' => 5.7, 'rod-unit' => 'in', 'n' => 1.2],
        'Static 9.5:1 only' => ['ratio' => 9.5, 'altitude' => 0, 'altitude-unit' => 'ft', 'ivc' => '', 'stroke' => '', 'stroke-unit' => 'in', 'rod' => '', 'rod-unit' => 'in', 'n' => 1.2],
        '11:1 at 5,000 ft' => ['ratio' => 11, 'altitude' => 5000, 'altitude-unit' => 'ft', 'ivc' => 70, 'stroke' => 86, 'stroke-unit' => 'mm', 'rod' => 145, 'rod-unit' => 'mm', 'n' => 1.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'dynamic' => ['label' => 'Compression ratio used'],
            'bar' => ['label' => 'In bar'],
            'adiabatic' => ['label' => 'With no heat loss'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p ≈ p atm × CR^n − p atm</li>
            <li>dynamic CR = 1 + (CR − 1) × piston travel after intake closing ÷ stroke</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
