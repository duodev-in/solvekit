<x-calc.page
    title="Triangle Proportionality Theorem Calculator - SolveKit"
    description="Free triangle proportionality theorem calculator: a line parallel to one side divides the other two proportionally, AD/DB = AE/EC."
    lede="Use the side-splitter theorem."
    about="If a line parallel to BC cuts AB at D and AC at E, then AD/DB = AE/EC (the side-splitter or triangle proportionality theorem), and triangle ADE is similar to ABC. Leave the unknown length blank."
    :calc="['engine' => 'mt-tri', 'tool' => 'similar', 'fields' => ['ad', 'db', 'ae', 'ec', 'unit'], 'mode' => 'proportion']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'AD = 4, DB = 6 and AE = 5. How long is EC?', 'answer' => '7.5 cm.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="ad" label="AD" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="db" label="DB" value="6" type="text" inputmode="decimal" />
        <x-calc.field name="ae" label="AE" value="5" type="text" inputmode="decimal" />
        <x-calc.field name="ec" label="EC" value="" type="text" inputmode="decimal" />
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Missing length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ad' => '4', 'db' => '6', 'ae' => '5', 'ec' => '', 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Ratio'],
            'sides' => ['label' => 'Lengths'],
            'area' => ['label' => 'Small triangle'],
            'k' => ['label' => 'Scale factor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AD/DB = AE/EC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
