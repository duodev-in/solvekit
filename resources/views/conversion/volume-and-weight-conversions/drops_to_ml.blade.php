<x-calc.page
    title="Drops to mL Converter - SolveKit"
    description="Professional drops to milliliters converter for medical dosages and small volume measurements. Convert drops to mL with precision."
    lede="Convert drops to milliliters, or milliliters to drops, for a given drop size."
    about="A drop has no fixed size, so the conversion uses a drop factor: how many drops make one milliliter. 20 drops/mL is the common standard for droppers and many IV sets; macro sets use 10 or 15 and micro sets 60. Always check the factor printed on your dropper or giving set."
    :calc="['engine' => 'drops']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Drops to milliliters, or milliliters to drops.'],
        ['name' => 'Pick the drop factor', 'text' => 'Use the drops per mL printed on your dropper or IV set.'],
        ['name' => 'Enter the amount', 'text' => 'The result updates as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many drops are in 1 mL?', 'answer' => 'About 20 with a standard dropper. IV giving sets are labelled 10, 15, 20 or 60 drops per mL.'],
        ['question' => 'How many drops are in a teaspoon?', 'answer' => 'About 99 at 20 drops/mL, since a US teaspoon is 4.93 mL.'],
        ['question' => 'Can I use this for medicine?', 'answer' => 'It does the arithmetic only. Follow the dosing instructions from your doctor, pharmacist or the product label.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['drops:ml' => 'Drops → mL', 'ml:drops' => 'mL → Drops']" selected="drops:ml" />

    <x-calc.segmented name="factor" legend="Drop factor (drops per mL)" :options="['10' => '10', '15' => '15', '20' => '20', '60' => '60 (micro)']" selected="20" />

    <x-calc.field name="value" label="Amount" value="30" min="0" suffix="drops" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="Milliliters" />

    <x-calc.options :examples="[
        'Eye drops 2 drops' => ['value' => 2, 'direction' => 'drops:ml'],
        'Dropper 1 mL' => ['value' => 1, 'direction' => 'ml:drops'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same volume in" :rows="[
            'tsp' => ['label' => 'US teaspoons', 'unit' => 'tsp'],
            'floz' => ['label' => 'US fluid ounces', 'unit' => 'fl oz'],
            'l' => ['label' => 'Liters', 'unit' => 'L'],
        ]" />
        <x-calc.quick-ref heading="At each drop factor" name="factors" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mL = drops ÷ drop factor</li>
            <li>drops = mL × drop factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
