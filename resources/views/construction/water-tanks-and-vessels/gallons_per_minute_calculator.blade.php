<x-calc.page
    title="Gallons Per Minute Calculator (GPM) - SolveKit"
    description="Free gallons per minute calculator: flow rate in GPM and liters per minute from a bucket test or from pipe size and water velocity."
    lede="Work out a flow rate in gallons or liters per minute."
    about="A bucket test divides the volume collected by the time. In a full pipe, flow = cross-section area × velocity (Q = A v). Results are given in US gal/min, liters per minute and more; this also covers liters per minute."
    :calc="['engine' => 'con-water', 'tool' => 'gpm', 'fields' => ['mode', 'volume', 'time', 'id', 'velocity'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all(), 'id' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'velocity' => collect(config('units.speed'))->only(['fts', 'ms', 'ftmin'])->all()]]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Bucket test or pipe.'],
        ['name' => 'Enter the values', 'text' => 'In any units.'],
    ]"
    :faqs="[
        ['question' => 'How do I measure GPM?', 'answer' => 'Time how long a bucket of known size takes to fill: GPM = gallons ÷ minutes.'],
        ['question' => 'What is 10 GPM in liters per minute?', 'answer' => '37.85 L/min.'],
        ['question' => 'What velocity is normal in water pipe?', 'answer' => 'Often 4–8 ft/s; higher speeds are noisy and wear fittings.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['bucket' => 'Bucket test', 'pipe' => 'Pipe and velocity']" selected="bucket" />

    <div data-show-when="mode:bucket">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="volume" label="Volume collected" value="5" min="0" placeholder="Volume collected">
                <label for="calc-volume-unit" class="sr-only">Volume collected unit</label>
                <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="time" label="Time" value="30" min="0" suffix="s" />
        </div>
    </div>

    <div data-show-when="mode:pipe" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="id" label="Pipe inside diameter" value="1" min="0" placeholder="Pipe inside diameter">
                <label for="calc-id-unit" class="sr-only">Pipe inside diameter unit</label>
                <select id="calc-id-unit" name="id-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="velocity" label="Water velocity" value="5" min="0" placeholder="Water velocity">
                <label for="calc-velocity-unit" class="sr-only">Water velocity unit</label>
                <select id="calc-velocity-unit" name="velocity-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['fts', 'ms', 'ftmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :examples="[
        '5 gal in 30 s' => ['mode' => 'bucket', 'volume' => 5, 'volume-unit' => 'gal_us', 'time' => 30],
        '10 L in 12 s' => ['mode' => 'bucket', 'volume' => 10, 'volume-unit' => 'l', 'time' => 12],
        '1 in pipe at 5 ft/s' => ['mode' => 'pipe', 'id' => 1, 'id-unit' => 'in', 'velocity' => 5, 'velocity-unit' => 'fts'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lpm' => ['label' => 'Liters per minute'],
            'm3h' => ['label' => 'Cubic meters per hour'],
            'gph' => ['label' => 'Gallons per hour'],
            'cfs' => ['label' => 'Cubic feet per second'],
            'uk' => ['label' => 'UK gallons per minute'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GPM = gallons ÷ minutes</li>
            <li>Q = π ÷ 4 × D² × v</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
