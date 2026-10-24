<x-calc.page
    title="CIDR Calculator - SolveKit"
    description="Free CIDR calculator: address range, netmask and size of a CIDR block, and the fewest blocks covering a range."
    lede="Work with CIDR blocks."
    about="CIDR notation writes a network as an address and a prefix length: 10.0.0.0/8 covers every address starting with 10."
    :calc="['engine' => 'tc-net', 'tool' => 'cidr', 'fields' => ['mode', 'cidr', 'start', 'end'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many addresses are in 10.20.0.0/14?', 'answer' => '262,144.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Calculate" :options="['block' => 'A CIDR block', 'range' => 'CIDR blocks covering a range']" selected="block" />
        <div data-show-when="mode:block">
            <x-calc.field name="cidr" label="CIDR (address/prefix)" value="10.20.0.0/14" type="text" inputmode="text" />
        </div>
        <div data-show-when="mode:range">
            <x-calc.field name="start" label="First address" value="192.168.1.10" type="text" inputmode="text" />
        </div>
        <div data-show-when="mode:range">
            <x-calc.field name="end" label="Last address" value="192.168.1.100" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'block', 'cidr' => '10.20.0.0/14', 'start' => '192.168.1.10', 'end' => '192.168.1.100'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'First address'],
            'last' => ['label' => 'Last address'],
            'count' => ['label' => 'Addresses'],
            'mask' => ['label' => 'Netmask'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="CIDR blocks" name="blocks" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
