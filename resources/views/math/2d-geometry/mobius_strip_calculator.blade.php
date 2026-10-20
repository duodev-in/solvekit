<x-calc.page
    title="Möbius Strip Calculator - SolveKit"
    description="Free Möbius strip calculator: the paper strip needed, the true surface area and the length of the single edge of a Möbius band."
    lede="Make a Möbius strip."
    about="A Möbius strip is a band with one half-twist: it has only one side and one edge. To make one, glue a strip of length 2πR with a half-twist. The smooth band's surface area and edge length are computed by numerical integration of its standard parametrisation."
    :calc="['engine' => 'mt-shape', 'tool' => 'mobius', 'fields' => ['r', 'w', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How much paper does a Möbius strip with R = 10 cm and width 4 cm need?', 'answer' => '251.3274123 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r" label="Radius of the centre circle R" value="10" min="0" step="any" />
        <x-calc.field name="w" label="Strip width w" value="4" min="0" step="any" />
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Paper needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['r' => 10, 'w' => 4, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'length' => ['label' => 'Strip length'],
            'area' => ['label' => 'Surface area of the smooth band'],
            'edge' => ['label' => 'Edge length'],
            'sides' => ['label' => 'Sides and edges'],
            'cut' => ['label' => 'Cutting it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = 2πR</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
