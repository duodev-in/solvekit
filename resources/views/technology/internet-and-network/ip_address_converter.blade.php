<x-calc.page
    title="IP Address Converter - SolveKit"
    description="Free IP address converter: IPv4 and IPv6 in dotted, decimal, hex and binary form, with the address type."
    lede="Convert an IP address."
    about="An IP address is a number; dotted notation is just one way to write it."
    :calc="['engine' => 'tc-net', 'tool' => 'ip_converter', 'fields' => ['ip'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is 192.168.1.1 as a decimal number?', 'answer' => '3232235777.'],
    ]"
>
    <x-calc.field name="ip" label="IP address (IPv4 or IPv6, in any form)" value="192.168.1.1" type="text" inputmode="text" />

    <x-calc.result label="IP address" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ip' => '192.168.1.1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'hex' => ['label' => 'Hexadecimal'],
            'binary' => ['label' => 'Binary'],
            'ipv6' => ['label' => 'As IPv6 (mapped)'],
            'expanded' => ['label' => 'Expanded (IPv6)'],
            'type' => ['label' => 'Type'],
            'cls' => ['label' => 'Class (IPv4)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
