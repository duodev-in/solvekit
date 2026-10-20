<x-calc.page
    title="Equivalent Ratio Calculator - SolveKit"
    description="Free equivalent ratio calculator: scale a ratio so its first term is a chosen number, and list equivalent ratios."
    lede="Find an equivalent ratio."
    about="Equivalent ratios multiply every term by the same factor: 3 : 5 = 6 : 10 = 12 : 20. Enter the new first term and the other terms are scaled by the same factor."
    :calc="['engine' => 'mt-frac', 'tool' => 'ratio', 'fields' => ['mode', 'ratio', 'total']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What ratio equal to 3:5 starts with 12?', 'answer' => '12 : 20.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Do" :options="['simplify' => 'Simplify', 'total' => 'Share a total', 'scale' => 'Scale']" selected="scale" />

    <x-calc.field name="ratio" label="Ratio" value="3:5" type="text" help="Two or more terms separated by colons" inputmode="text" />

    <div data-show-when="mode:total,scale">
        <x-calc.field name="total" label="Total to share (or new first term)" value="12" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Simplest form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'scale', 'ratio' => '3:5', 'total' => '12'],
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
