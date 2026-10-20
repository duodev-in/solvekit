<x-calc.page
    title="Ratio of 3 Numbers Calculator - SolveKit"
    description="Free ratio of three numbers calculator: simplify a three-term ratio or share a total in the ratio a : b : c."
    lede="Work with a three-part ratio."
    about="A three-term ratio is simplified by the greatest common factor of all three: 12 : 18 : 30 = 2 : 3 : 5. Sharing 400 in 2 : 3 : 5 gives 10 parts of 40: 80, 120 and 200."
    :calc="['engine' => 'mt-frac', 'tool' => 'ratio', 'fields' => ['mode', 'ratio', 'total']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'How is 400 shared in the ratio 2:3:5?', 'answer' => '80 : 120 : 200.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Do" :options="['simplify' => 'Simplify', 'total' => 'Share a total', 'scale' => 'Scale']" selected="total" />

    <x-calc.field name="ratio" label="Ratio" value="2:3:5" type="text" help="Two or more terms separated by colons" inputmode="text" />

    <div data-show-when="mode:total,scale">
        <x-calc.field name="total" label="Total to share (or new first term)" value="400" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'total', 'ratio' => '2:3:5', 'total' => '400'],
        'Simplify' => ['mode' => 'simplify', 'ratio' => '12:18:30', 'total' => '400'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'simplest' => ['label' => 'Simplest form'],
            'fractions' => ['label' => 'As fractions of the whole'],
            'unit' => ['label' => 'Unit ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a : b = a/g : b/g with g = GCF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
