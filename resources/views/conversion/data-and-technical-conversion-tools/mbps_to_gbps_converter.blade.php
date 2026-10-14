@php
    $units = config('units.data_rate');
@endphp

<x-calc.page
    title="Mbps to Gbps Converter - SolveKit"
    description="Professional Mbps to Gbps converter for network speeds. Convert between megabits and gigabits per second with detailed analysis and network performance insights."
    lede="Convert megabits per second to gigabits per second, or Gbps to Mbps."
    about="Network speeds use decimal prefixes, so 1 Gbps = 1,000 Mbps. Speeds are in bits; divide by 8 for bytes per second, which is what download progress bars usually show."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['kbps', 'tbps', 'MBps', 'GBps'], 'quickRef' => ['mbps:gbps' => [10, 100, 500, 1000, 2500, 10000], 'gbps:mbps' => [0.1, 1, 2.5, 10, 40, 100]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Mbps to Gbps, or Gbps to Mbps.'],
        ['name' => 'Enter the speed', 'text' => 'Byte rates (MB/s) are listed too.'],
    ]"
    :faqs="[
        ['question' => 'How many Mbps are in 1 Gbps?', 'answer' => 'Exactly 1,000 Mbps.'],
        ['question' => 'Is Mbps the same as MB/s?', 'answer' => 'No. Mbps is megabits; MB/s is megabytes. 100 Mbps is 12.5 MB/s.'],
        ['question' => 'How fast is gigabit internet in MB/s?', 'answer' => '1 Gbps is 125 MB/s before overhead; real downloads are usually 110 to 118 MB/s.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['mbps:gbps' => 'Mbps → Gbps', 'gbps:mbps' => 'Gbps → Mbps']" selected="mbps:gbps" />

    <x-calc.field name="value" label="Speed" value="500" min="0" suffix="Mbit/s" suffix-ref="value-suffix" placeholder="Enter a speed" />

    <x-calc.result label="Gigabits per second" />

    <x-calc.options :examples="[
        'Home fibre 940 Mbps' => ['value' => 940, 'direction' => 'mbps:gbps'],
        'Data centre 25 Gbps' => ['value' => 25, 'direction' => 'gbps:mbps'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['kbps', 'tbps', 'MBps', 'GBps']" heading="500 Mbit/s in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Gbps = Mbps ÷ 1,000</li>
            <li>MB/s = Mbps ÷ 8</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
