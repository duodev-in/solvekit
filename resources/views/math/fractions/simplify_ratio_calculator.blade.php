<x-calc.page
    title="Simplify Ratio Calculator - SolveKit"
    description="Free simplify ratio calculator: reduce a ratio to its simplest whole-number form, including ratios with decimals and fractions."
    lede="Simplify a ratio."
    about="Divide every term by the greatest common factor; clear decimals or fractions first by multiplying by a power of ten or the common denominator. 1.5 : 2.25 → 150 : 225 → 2 : 3."
    :calc="['engine' => 'mt-frac', 'tool' => 'ratio', 'fields' => ['mode', 'ratio', 'total']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 1.5 : 2.25 in simplest form?', 'answer' => '2 : 3.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Do" :options="['simplify' => 'Simplify', 'total' => 'Share a total', 'scale' => 'Scale']" selected="simplify" />

    <x-calc.field name="ratio" label="Ratio" value="1.5:2.25" type="text" help="Two or more terms separated by colons" inputmode="text" />

    <div data-show-when="mode:total,scale" hidden>
        <x-calc.field name="total" label="Total to share (or new first term)" value="250" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'simplify', 'ratio' => '1.5:2.25', 'total' => '250'],
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
