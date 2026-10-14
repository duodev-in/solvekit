@php
    $data = config('units.data');
    $dataUnits = ['mb' => $data['mb'], 'gb' => $data['gb'], 'tb' => $data['tb'], 'mib' => $data['mib'], 'gib' => $data['gib']];
    $rateUnits = collect(config('units.data_rate'))->only(['kbps', 'mbps', 'gbps', 'MBps'])->all();
    $unitSelect = 'h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40';
@endphp

<x-calc.page
    title="Mbps Calculator - SolveKit"
    description="Professional Mbps calculator for network speeds and data transfer rates. Calculate download times, bandwidth requirements, and network performance with detailed analysis."
    lede="Work out download time, the speed you need, or total bandwidth for several users."
    about="Download time is the file size in bits divided by the connection speed in bits per second. Real connections lose some capacity to protocol overhead and conditions, so the efficiency setting reduces the usable speed; about 90% suits a good wired link, lower for busy Wi-Fi."
    :calc="['engine' => 'mbps-calculator', 'dataUnits' => $dataUnits, 'rateUnits' => $rateUnits]"
    :how-to="[
        ['name' => 'Choose what to calculate', 'text' => 'Download time, speed needed, or bandwidth for several users.'],
        ['name' => 'Enter the values', 'text' => 'Sizes use decimal units like network speeds; binary units are also available.'],
        ['name' => 'Adjust efficiency', 'text' => 'Use about 90% for wired connections and 60 to 80% for Wi-Fi.'],
    ]"
    :faqs="[
        ['question' => 'How long does 1 GB take at 100 Mbps?', 'answer' => 'About 80 seconds at full speed (8,000 megabits ÷ 100), or about 89 seconds at 90% efficiency.'],
        ['question' => 'Why is my download slower than my plan speed?', 'answer' => 'Protocol overhead, Wi-Fi conditions and the server all reduce real throughput below the advertised line speed.'],
        ['question' => 'How much bandwidth does 4K streaming need?', 'answer' => 'Streaming services recommend about 15 to 25 Mbps per 4K stream.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['time' => 'Download time', 'speed' => 'Speed needed', 'bandwidth' => 'Bandwidth']" selected="time" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:time,speed">
            <x-calc.field name="size" label="File size" value="5" min="0" placeholder="Size">
                <label for="calc-size-unit" class="sr-only">Size unit</label>
                <select id="calc-size-unit" name="size-unit" class="{{ $unitSelect }}">
                    @foreach($dataUnits as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gb')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:time">
            <x-calc.field name="speed" label="Connection speed" value="100" min="0" placeholder="Speed">
                <label for="calc-speed-unit" class="sr-only">Speed unit</label>
                <select id="calc-speed-unit" name="speed-unit" class="{{ $unitSelect }}">
                    @foreach($rateUnits as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mbps')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:speed" hidden><x-calc.field name="minutes" label="Time allowed" value="10" min="0" suffix="min" placeholder="Minutes" /></div>
        <div data-show-when="mode:bandwidth" hidden><x-calc.field name="users" label="Users" value="10" min="0" step="1" placeholder="Users" /></div>
        <div data-show-when="mode:bandwidth" hidden><x-calc.field name="per-user" label="Speed per user" value="25" min="0" suffix="Mbit/s" placeholder="Mbit/s" /></div>
        <x-calc.field name="efficiency" label="Efficiency" value="90" min="1" max="100" suffix="%" placeholder="90" />
    </div>

    <x-calc.result label="Download time" />

    <x-calc.options :examples="[
        'Game 80 GB at 300 Mbps' => ['mode' => 'time', 'size' => 80, 'size-unit' => 'gb', 'speed' => 300, 'speed-unit' => 'mbps'],
        '4K streams for 6 users' => ['mode' => 'bandwidth', 'users' => 6, 'per-user' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'seconds' => ['label' => 'Seconds', 'unit' => 's'],
            'minutes' => ['label' => 'Minutes', 'unit' => 'min'],
            'hours' => ['label' => 'Hours', 'unit' => 'h'],
            'throughput' => ['label' => 'Throughput', 'unit' => 'MB/s'],
        ]" />
        <x-calc.steps />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = size (bits) ÷ (speed × efficiency)</li>
            <li>speed = size (bits) ÷ time ÷ efficiency</li>
            <li>1 byte = 8 bits · 1 MB = 8 Mbit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
