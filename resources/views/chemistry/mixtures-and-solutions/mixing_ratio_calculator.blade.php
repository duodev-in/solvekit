<x-calc.page
    title="Mixing Ratio Calculator - SolveKit"
    description="Free mixing ratio calculator: amount of each part for a ratio such as 1:4 or 2:1:1 and a total amount."
    lede="Split a total amount by a mixing ratio."
    about="Each part's share is its number divided by the sum of the ratio. Use it for epoxy, concentrates, fuel mixes or any recipe given as a ratio."
    :calc="['engine' => 'chem-mix', 'tool' => 'mixing_ratio', 'fields' => ['ratio', 'total', 'unit_label']]"
    :how-to="[
        ['name' => 'Enter the ratio', 'text' => 'Parts separated by colons.'],
        ['name' => 'Enter the total', 'text' => 'The amount you want to make.'],
    ]"
    :faqs="[
        ['question' => 'How do I mix 1:4?', 'answer' => 'One part A to four parts B: a fifth of the total is A.'],
        ['question' => 'Is 50:1 fuel mix 50 parts fuel to 1 oil?', 'answer' => 'Yes: 1 part oil in 51 parts total.'],
        ['question' => 'Can I use weights?', 'answer' => 'Yes, if the ratio is by weight.'],
    ]"
>
    <x-calc.field name="ratio" label="Ratio" value="1:4" type="text" help="e.g. 1:4, 2:1:1 or 50:1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="total" label="Total amount" value="500" min="0" />
        <x-calc.field name="unit_label" label="Unit (optional)" value="mL" type="text" />
    </div>

    <x-calc.result label="Amounts" />

    <x-calc.options :examples="[
        '1:4 in 500 mL' => ['ratio' => '1:4', 'total' => 500, 'unit_label' => 'mL'],
        '2:1:1 in 1 kg' => ['ratio' => '2:1:1', 'total' => 1000, 'unit_label' => 'g'],
        '50:1 fuel in 5 L' => ['ratio' => '50:1', 'total' => 5000, 'unit_label' => 'mL'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Each part" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>part = total × part ÷ sum of parts</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
