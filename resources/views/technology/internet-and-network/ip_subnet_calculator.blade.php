<x-calc.page
    title="IP Subnet Calculator - SolveKit"
    description="Free IP subnet calculator: network, broadcast, host range, mask and wildcard, and splitting into subnets."
    lede="Calculate a subnet."
    about="A subnet mask divides an address into a network part and a host part."
    :calc="['engine' => 'tc-net', 'tool' => 'ip_subnet', 'fields' => ['ip', 'split'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What network is 192.168.10.77/26 in?', 'answer' => '192.168.10.64/26, hosts 192.168.10.65 – 192.168.10.126.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ip" label="IP address with prefix or mask" value="192.168.10.77/26" type="text" inputmode="text" />
        <x-calc.field name="split" label="Split into how many subnets (optional)" value="4" min="0" step="any" />
    </div>

    <x-calc.result label="Network" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ip' => '192.168.10.77/26', 'split' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Usable host range'],
            'broadcast' => ['label' => 'Broadcast address'],
            'hosts' => ['label' => 'Usable hosts'],
            'mask' => ['label' => 'Subnet mask'],
            'wildcard' => ['label' => 'Wildcard mask'],
            'binary' => ['label' => 'Mask in binary'],
            'type' => ['label' => 'Address type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Subnets after splitting" name="subnets" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
