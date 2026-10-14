@php
    $units = config('units.data');
@endphp

<x-calc.page
    title="Byte Conversion Calculator - SolveKit"
    description="Professional byte conversion calculator for digital storage units. Convert between bytes, kilobytes, megabytes, gigabytes, terabytes, and more with detailed calculations."
    lede="Convert between bits, bytes and decimal (kB, MB, GB) or binary (KiB, MiB, GiB) storage units."
    about="Decimal units use powers of 1,000: 1 MB = 1,000,000 bytes, as drive makers and network speeds use. Binary units use powers of 1,024: 1 MiB = 1,048,576 bytes, which is what many operating systems show even when they label it MB. Both families are listed so you can compare."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a size', 'text' => 'Type the amount of data.'],
        ['name' => 'Choose the units', 'text' => 'Pick a decimal unit (kB, MB, GB) or a binary one (KiB, MiB, GiB).'],
        ['name' => 'Compare', 'text' => 'Every unit in both systems is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'Is a kilobyte 1,000 or 1,024 bytes?', 'answer' => 'Officially 1,000 bytes. 1,024 bytes is a kibibyte (KiB). Many programs still say KB when they mean KiB.'],
        ['question' => 'Why does my 1 TB drive show about 931 GB?', 'answer' => 'The drive holds 10¹² bytes. The computer divides by 1,024³ and shows 931 GiB, but labels it GB.'],
        ['question' => 'How many bits are in a byte?', 'answer' => 'Eight.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="tb" to="gib" value="1" min="0" label="Data size" />

    <x-calc.result label="Gibibytes">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Photo 4.5 MB' => ['value' => 4.5, 'from' => 'mb'],
        'Film 8 GiB' => ['value' => 8, 'from' => 'gib'],
        'Drive 2 TB' => ['value' => 2, 'from' => 'tb'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1 TB in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 kB = 1,000 B · 1 MB = 1,000 kB</li>
            <li>1 KiB = 1,024 B · 1 MiB = 1,024 KiB</li>
            <li>1 byte = 8 bits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
