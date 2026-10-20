<x-calc.page
    title="Antilog Calculator – Antilogarithm - SolveKit"
    description="Free antilog calculator: the antilogarithm b^y for base 10, e, 2 or any base."
    lede="Find an antilogarithm."
    about="The antilog undoes the logarithm: if log_b(x) = y then x = antilog_b(y) = bʸ. With base 10, antilog(2.5) = 10^2.5 ≈ 316.23."
    :calc="['engine' => 'mt-explog', 'tool' => 'antilog', 'fields' => ['y', 'base']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is antilog(2.5)?', 'answer' => '316.2277660168.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="y" label="Logarithm y" value="2.5" step="any" />
        <x-calc.field name="base" label="Base b" value="10" type="text" help="Type e for the natural antilog" inputmode="decimal" />
    </div>

    <x-calc.result label="Antilog" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['y' => 2.5, 'base' => '10'],
        'Natural' => ['y' => 1, 'base' => 'e'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>antilog_b(y) = bʸ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
