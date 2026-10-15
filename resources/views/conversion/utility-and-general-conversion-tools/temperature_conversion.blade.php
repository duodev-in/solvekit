@php
    $units = config('units.temperature');
@endphp

<x-calc.page
    title="Temperature Conversion - SolveKit"
    description="Professional temperature conversion calculator for Celsius, Fahrenheit, Kelvin, and Rankine. Convert temperatures with weather applications, cooking conversions, and scientific calculations."
    lede="Convert between Celsius, Fahrenheit, Kelvin, Rankine and historical temperature scales."
    about="Temperature scales have different zero points, so they need an offset as well as a factor: °F = °C × 9/5 + 32 and K = °C + 273.15. Nothing can be colder than absolute zero (0 K, −273.15 °C, −459.67 °F), so lower values are rejected."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'minBase' => -273.15, 'minBaseMessage' => 'That is below absolute zero (−273.15 °C), the lowest possible temperature.']"
    :how-to="[
        ['name' => 'Enter a temperature', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert Celsius to Fahrenheit?', 'answer' => 'Multiply by 9/5 and add 32. 25 °C is 77 °F.'],
        ['question' => 'At what temperature are Celsius and Fahrenheit equal?', 'answer' => '−40.'],
        ['question' => 'What is absolute zero?', 'answer' => '0 K, which is −273.15 °C or −459.67 °F.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="c" to="f" value="25" label="Temperature" />

    <x-calc.result label="Fahrenheit">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Body 37 °C' => ['value' => 37, 'from' => 'c'],
        'Oven 350 °F' => ['value' => 350, 'from' => 'f'],
        'Boiling 373.15 K' => ['value' => 373.15, 'from' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="25 °C on other scales" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>°F = °C × 9/5 + 32</li>
            <li>K = °C + 273.15</li>
            <li>°R = °F + 459.67</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
