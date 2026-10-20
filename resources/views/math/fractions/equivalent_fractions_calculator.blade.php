<x-calc.page
    title="Equivalent Fractions Calculator - SolveKit"
    description="Free equivalent fractions calculator: list fractions equal to a given one and check whether two fractions are equivalent."
    lede="Find equivalent fractions."
    about="Equivalent fractions name the same number: multiply or divide the top and bottom by the same non-zero number (2/3 = 4/6 = 6/9). Two fractions are equivalent when they reduce to the same lowest terms, or when a × d = b × c."
    :calc="['engine' => 'mt-frac', 'tool' => 'equivalent', 'fields' => ['value', 'check']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 10/15 equivalent to 2/3?', 'answer' => '10/15 is equivalent (both equal 2/3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Fraction" value="2/3" type="text" inputmode="text" />
        <x-calc.field name="check" label="Check against (optional)" value="10/15" type="text" placeholder="Optional" inputmode="text" />
    </div>

    <x-calc.result label="Equivalent fractions" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '2/3', 'check' => '10/15'],
        'Not equal' => ['value' => '3/8', 'check' => '6/14'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lowest' => ['label' => 'Lowest terms'],
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a/b = (ak)/(bk)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
