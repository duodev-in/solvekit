<x-calc.page
    title="Percent Error Calculator - SolveKit"
    description="Free percent error calculator: the percent error of a measurement against the true or accepted value, with absolute and relative error."
    lede="Calculate percent error."
    about="Percent error = |measured − true| ÷ |true| × 100. It is used in experiments to compare a measured value with an accepted one; the sign is dropped, so the result says how far off, not in which direction (the page says which)."
    :calc="['engine' => 'mt-percent', 'tool' => 'error', 'fields' => ['measured', 'actual']]"
    :how-to="[
        ['name' => 'Enter the measured value', 'text' => ''],
        ['name' => 'Enter the accepted value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the percent error of 9.6 against 9.81?', 'answer' => '2.140672782875…%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="measured" label="Measured value" value="9.6" type="text" inputmode="decimal" />
        <x-calc.field name="actual" label="True (accepted) value" value="9.81" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Percent error" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['measured' => '9.6', 'actual' => '9.81'],
        'Too high' => ['measured' => '102', 'actual' => '100'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'absolute' => ['label' => 'Absolute error'],
            'relative' => ['label' => 'Relative error'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|measured − true| ÷ |true| × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
