<x-calc.page
    title="Relative Change Calculator - SolveKit"
    description="Free relative change calculator: the change between a reference value and a new value as a fraction of the reference, and in percent."
    lede="Calculate relative change."
    about="Relative change = (new − reference) ÷ |reference|. As a decimal, 0.25 means a 25% increase. It is the same quantity as percentage change, without the factor of 100, and is used in science and statistics."
    :calc="['engine' => 'mt-percent', 'tool' => 'change', 'fields' => ['a', 'b'], 'relative' => true]"
    :how-to="[
        ['name' => 'Enter the reference value', 'text' => ''],
        ['name' => 'Enter the new value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the relative change from 80 to 100?', 'answer' => '0.25.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Reference value" value="80" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="New value" value="100" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Relative change" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '80', 'b' => '100'],
        'Fall' => ['a' => '2.5', 'b' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'diff' => ['label' => 'Absolute change'],
            'percent' => ['label' => 'Percentage'],
            'relative' => ['label' => 'As a decimal'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(new − ref) ÷ |ref|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
