<x-calc.page
    title="Polish Notation Converter - SolveKit"
    description="Free Polish notation converter: convert between infix, prefix (Polish) and postfix (reverse Polish) notation and evaluate."
    lede="Convert to and from Polish notation."
    about="Prefix notation puts the operator first (+ 3 4), postfix after (3 4 +). Neither needs brackets: (3 + 4) × 2 is × + 3 4 2 in prefix and 3 4 + 2 × in postfix. Stack-based calculators and compilers use postfix."
    :calc="['engine' => 'mt-arith', 'tool' => 'polish', 'fields' => ['expr', 'from']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is (3 + 4) × 2 − 5 in postfix?', 'answer' => '3 4 + 2 × 5 −.'],
    ]"
>
    <x-calc.field name="expr" label="Expression" value="(3 + 4) * 2 - 5" type="text" inputmode="text" />

    <x-calc.select name="from" label="Written in" :options="['infix' => 'Infix (normal)', 'prefix' => 'Prefix (Polish)', 'postfix' => 'Postfix (reverse Polish)']" selected="infix" />

    <x-calc.result label="Converted" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => '(3 + 4) * 2 - 5', 'from' => 'infix'],
        'From postfix' => ['expr' => '5 1 2 + 4 * + 3 -', 'from' => 'postfix'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'infix' => ['label' => 'Infix'],
            'prefix' => ['label' => 'Prefix'],
            'postfix' => ['label' => 'Postfix'],
            'value' => ['label' => 'Value'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>shunting-yard</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
