<x-calc.page
    title="Credit Spread Calculator - SolveKit"
    description="Free Credit Spread Calculator: spread = bond yield − benchmark yield. The credit spread is the extra yield investors demand for default risk, quoted in basis points."
    lede="Work out the credit spread from bond yield and benchmark (Treasury) yield."
    about="The credit spread is the extra yield investors demand for default risk, quoted in basis points. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'credit_spread', 'fields' => ['bond', 'benchmark']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Bond yield, Benchmark (Treasury) yield.'],
        ['name' => 'Read the result', 'text' => 'The credit spread appears as you type, with as a percentage below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the credit spread?', 'answer' => 'Spread = bond yield − benchmark yield.'],
        ['question' => 'What is the credit spread for bond yield 6.2%, benchmark yield 4.3%?', 'answer' => '190 bp. As a percentage: 1.9%.'],
        ['question' => 'And for bond yield 9.1%, benchmark yield 4.1%?', 'answer' => '500 bp. As a percentage: 5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Investment-grade spreads are often 100–200 bp; high-yield several hundred.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bond" label="Bond yield" value="6.2" step="any" suffix="%" />
        <x-calc.field name="benchmark" label="Benchmark (Treasury) yield" value="4.3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Credit spread" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['bond' => 6.2, 'benchmark' => 4.3],
        'Example B' => ['bond' => 9.1, 'benchmark' => 4.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'As a percentage'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>spread = bond yield − benchmark yield</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
