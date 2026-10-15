@php
    $units = config('units.count');
@endphp

<x-calc.page
    title="Quantity Converter - SolveKit"
    description="Professional quantity converter for count and bulk measurements. Convert between different quantity units including dozens, gross, reams, cases, and bulk packaging for business and inventory management."
    lede="Convert between pieces, dozens, gross, scores, reams and other counting units."
    about="Every unit converts through single items. A dozen is 12, a gross is 144 (12 dozen) and a great gross is 1,728. Paper counts use quires of 25 sheets and reams of 500."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a quantity', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many are in a gross?', 'answer' => '144, which is 12 dozen.'],
        ['question' => 'What is a baker\'s dozen?', 'answer' => '13.'],
        ['question' => 'How many sheets are in a ream?', 'answer' => '500. A quire is 25 sheets.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="dozen" to="each" value="12" min="0" label="Quantity" />

    <x-calc.result label="Single items">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Eggs 30 dozen' => ['value' => 30, 'from' => 'dozen'],
        'Pencils 3 gross' => ['value' => 3, 'from' => 'gross'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="12 doz in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 dozen = 12</li>
            <li>1 gross = 12 dozen = 144</li>
            <li>1 ream = 500 sheets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
