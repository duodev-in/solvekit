<x-calc.page
    title="Ratio Calculator - SolveKit"
    description="Free ratio calculator: simplify a ratio of two or more numbers, share a total in a ratio, or scale it to an equivalent ratio."
    lede="Simplify, share or scale a ratio."
    about="A ratio compares quantities: 12 : 18 simplifies to 2 : 3 by dividing by the greatest common factor 6. To share 250 in the ratio 2 : 3, split it into 5 parts of 50: 100 and 150. Equivalent ratios multiply every term by the same number."
    :calc="['engine' => 'mt-frac', 'tool' => 'ratio', 'fields' => ['mode', 'ratio', 'total']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 12:18 in simplest form?', 'answer' => '2 : 3.'],
        ['question' => 'How is 250 shared in the ratio 2:3?', 'answer' => '100 : 150.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Do" :options="['simplify' => 'Simplify', 'total' => 'Share a total', 'scale' => 'Scale']" selected="simplify" />

    <x-calc.field name="ratio" label="Ratio" value="12:18" type="text" help="Two or more terms separated by colons" inputmode="text" />

    <div data-show-when="mode:total,scale" hidden>
        <x-calc.field name="total" label="Total to share (or new first term)" value="250" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'simplify', 'ratio' => '12:18', 'total' => '250'],
        'Share' => ['mode' => 'total', 'ratio' => '2:3', 'total' => '250'],
        'Scale' => ['mode' => 'scale', 'ratio' => '3:5', 'total' => '12'],
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
