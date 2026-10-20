<x-calc.page
    title="Perimeter of a Triangle with Fractions Calculator - SolveKit"
    description="Free perimeter of a triangle with fractions calculator: add three sides given as fractions or mixed numbers exactly."
    lede="Add fractional sides."
    about="Add the sides with a common denominator: 1 1/2 + 2 3/4 + 3 1/3 = 18/12 + 33/12 + 40/12 = 91/12 = 7 7/12. Type the sides separated by commas."
    :calc="['engine' => 'mt-shape', 'tool' => 'polygon_perimeter', 'fields' => ['sides', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is 1 1/2 + 2 3/4 + 3 1/3?', 'answer' => '91/12 = 7.583333333 in.'],
    ]"
>
    <x-calc.textarea name="sides" label="Three sides (fractions allowed)" value="1 1/2, 2 3/4, 3 1/3" rows="2" />

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="in" />

    <x-calc.result label="Perimeter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sides' => '1 1/2, 2 3/4, 3 1/3', 'unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sides' => ['label' => 'Sides'],
            'count' => ['label' => 'Number of sides'],
            'area' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = a + b + c</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
