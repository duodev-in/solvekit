@php
    $units = config('units.mass');
@endphp

<x-calc.page
    title="Decagram to Gram Converter - SolveKit"
    description="Professional decagram to gram converter for metric weight conversions. Convert decagrams (dag) to grams (g) with precise calculations."
    lede="Convert decagrams to grams, or grams to decagrams."
    about="A decagram is ten grams, so decagrams are multiplied by 10 to get grams and grams are divided by 10 to get decagrams."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['mg', 'kg', 'oz', 'lb'], 'quickRef' => ['dag:g' => [1, 2.5, 5, 10, 25, 100], 'g:dag' => [10, 50, 100, 250, 500, 1000]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Decagrams to grams, or grams to decagrams.'],
        ['name' => 'Enter the weight', 'text' => 'The result and equivalents update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many grams are in a decagram?', 'answer' => 'One decagram (dag) is exactly 10 grams.'],
        ['question' => 'Where are decagrams used?', 'answer' => 'Mainly in Central Europe, where shop prices are often given per 10 dag (100 g), sometimes written as deka.'],
        ['question' => 'Is a decagram the same as a decigram?', 'answer' => 'No. A decagram is 10 g; a decigram is 0.1 g.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['dag:g' => 'Decagrams → Grams', 'g:dag' => 'Grams → Decagrams']" selected="dag:g" />

    <x-calc.field name="value" label="Weight" value="15" min="0" suffix="dag" suffix-ref="value-suffix" placeholder="Enter a weight" />

    <x-calc.result label="Grams" />

    <x-calc.options :examples="[
        'Ham 20 dag' => ['value' => 20, 'direction' => 'dag:g'],
        'Butter 250 g' => ['value' => 250, 'direction' => 'g:dag'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['mg', 'kg', 'oz', 'lb']" heading="15 dag in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grams = decagrams × 10</li>
            <li>decagrams = grams ÷ 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
