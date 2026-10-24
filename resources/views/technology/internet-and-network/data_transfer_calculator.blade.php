<x-calc.page
    title="Data Transfer Calculator - SolveKit"
    description="Free data transfer calculator: time to transfer data at any speed, with overhead."
    lede="Find a transfer time."
    about="Transfer time is the data size in bits divided by the speed in bits per second."
    :calc="['engine' => 'tc-net', 'tool' => 'data_transfer', 'fields' => ['size', 'speed', 'overhead'], 'unitFields' => ['size' => collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit'])->all(), 'speed' => collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps'])->all()], 'data' => ['units' => collect(config('units'))->only(['data', 'data_rate'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long to move 500 GB at 1 Gbit/s?', 'answer' => '1 h 14 min 04 s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="size" label="Data size" value="500" min="0" placeholder="Data size">
            <label for="calc-size-unit" class="sr-only">Data size unit</label>
            <select id="calc-size-unit" name="size-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="speed" label="Connection speed" value="1" min="0" placeholder="Connection speed">
            <label for="calc-speed-unit" class="sr-only">Connection speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data_rate'))->only(['bps', 'kbps', 'mbps', 'gbps', 'kBps', 'MBps', 'GBps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gbps')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="overhead" label="Protocol overhead and slowdown (%)" value="10" min="0" step="any" />
    </div>

    <x-calc.result label="Transfer time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['size' => 500, 'size-unit' => 'gb', 'speed' => 1, 'speed-unit' => 'gbps', 'overhead' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Seconds'],
            'effective' => ['label' => 'Effective speed'],
            'bits' => ['label' => 'Data in bits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="At other speeds" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
