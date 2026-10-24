<x-calc.page
    title="Bandwidth Delay Product Calculator - SolveKit"
    description="Free bandwidth-delay product calculator: data in flight, TCP window needed and throughput for a window."
    lede="Find the bandwidth-delay product."
    about="The bandwidth-delay product is how much data is travelling on a link at once. TCP needs a window at least that big to fill the link."
    :calc="['engine' => 'tc-net', 'tool' => 'bdp', 'fields' => ['bw', 'rtt', 'window'], 'unitFields' => ['bw' => collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps'])->all(), 'rtt' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'window' => collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit'])->all()], 'data' => ['units' => collect(config('units'))->only(['data', 'data_rate', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the BDP of 1 Gbit/s at 80 ms?', 'answer' => '10 MB (9.5367 MiB).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bw" label="Bandwidth" value="1" min="0" placeholder="Bandwidth">
            <label for="calc-bw-unit" class="sr-only">Bandwidth unit</label>
            <select id="calc-bw-unit" name="bw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gbps')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rtt" label="Round-trip time (ping)" value="80" placeholder="Round-trip time (ping)">
            <label for="calc-rtt-unit" class="sr-only">Round-trip time (ping) unit</label>
            <select id="calc-rtt-unit" name="rtt-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="window" label="TCP window (optional)" value="64" min="0" placeholder="TCP window (optional)">
            <label for="calc-window-unit" class="sr-only">TCP window (optional) unit</label>
            <select id="calc-window-unit" name="window-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kib')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Bandwidth-delay product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bw' => 1, 'bw-unit' => 'gbps', 'rtt' => 80, 'rtt-unit' => 'ms', 'window' => 64, 'window-unit' => 'kib'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bits' => ['label' => 'In bits'],
            'maxThroughput' => ['label' => 'Throughput with the given window'],
            'needed' => ['label' => 'Window needed for full speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
