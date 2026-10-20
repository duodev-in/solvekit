<x-calc.page
    title="Percentage Change Calculator - SolveKit"
    description="Free percentage change calculator: the percent increase or decrease from an old value to a new one, with the absolute change and the working."
    lede="Find the percentage change between two values."
    about="Percentage change = (new − old) ÷ |old| × 100. A positive result is an increase and a negative one a decrease. It is measured relative to the starting value, so going from 50 to 75 is +50% but from 75 back to 50 is −33.3%."
    :calc="['engine' => 'mt-percent', 'tool' => 'change', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the original value', 'text' => ''],
        ['name' => 'Enter the new value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the change from 50 to 75?', 'answer' => '50%.'],
        ['question' => 'And from 75 back to 50?', 'answer' => '−33.(3)%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Original value" value="50" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="New value" value="75" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Percentage change" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '50', 'b' => '75'],
        'Back' => ['a' => '75', 'b' => '50'],
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
            <li>(new − old) ÷ |old| × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
