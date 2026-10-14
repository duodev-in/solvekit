@php
    $units = config('units.length');
@endphp

<x-calc.page
    title="Decimeter to Meter Converter - SolveKit"
    description="Professional decimeter to meter converter for simple metric conversions. Fast and accurate bidirectional conversion between decimeters and meters."
    lede="Convert decimeters to meters, or meters to decimeters."
    about="A decimeter is one tenth of a meter, so decimeters are divided by 10 to get meters and meters are multiplied by 10 to get decimeters."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['cm', 'mm', 'ft', 'in'], 'quickRef' => [1, 5, 10, 25, 50, 100], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Pick decimeters to meters or meters to decimeters.'],
        ['name' => 'Enter the length', 'text' => 'The result and equivalents update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many decimeters are in a meter?', 'answer' => 'One meter is exactly 10 decimeters.'],
        ['question' => 'How many centimeters are in a decimeter?', 'answer' => 'One decimeter is 10 centimeters.'],
        ['question' => 'Where is the decimeter used?', 'answer' => 'Mostly in schools and some European measurements. One liter is exactly one cubic decimeter.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['dm:m' => 'Decimeters → Meters', 'm:dm' => 'Meters → Decimeters']" selected="dm:m" />

    <x-calc.field name="value" label="Length" value="35" min="0" suffix="dm" suffix-ref="value-suffix" placeholder="Enter a length" />

    <x-calc.result label="Meters" />

    <x-calc.options :examples="[
        'A4 sheet 2.97 dm' => ['value' => 2.97, 'direction' => 'dm:m'],
        'Door 2.1 m' => ['value' => 2.1, 'direction' => 'm:dm'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['cm', 'mm', 'ft', 'in']" heading="35 dm in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>meters = decimeters ÷ 10</li>
            <li>decimeters = meters × 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
