<x-calc.page
    title="Information Ratio Calculator - SolveKit"
    description="Free Information Ratio Calculator: IR = (Rp − Rb) ÷ tracking error. The information ratio measures excess return over a benchmark per unit of active risk."
    lede="Work out the information ratio from portfolio return, benchmark return and tracking error."
    about="The information ratio measures excess return over a benchmark per unit of active risk. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'information_ratio', 'fields' => ['portfolio', 'benchmark', 'te']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Portfolio return, Benchmark return, Tracking error.'],
        ['name' => 'Read the result', 'text' => 'The information ratio appears as you type, with active return below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the information ratio?', 'answer' => 'IR = (Rp − Rb) ÷ tracking error.'],
        ['question' => 'What is the information ratio for portfolio return 12%, benchmark return 9%, tracking error 4%?', 'answer' => '0.75. Active return: 3%.'],
        ['question' => 'And for portfolio return 7.5%, benchmark return 8.2%, tracking error 2.5%?', 'answer' => '−0.28. Active return: −0.7%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 0.5 is considered good, above 1 exceptional.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="portfolio" label="Portfolio return" value="12" step="any" suffix="%" />
        <x-calc.field name="benchmark" label="Benchmark return" value="9" step="any" suffix="%" />
        <x-calc.field name="te" label="Tracking error" value="4" step="any" suffix="%" />
    </div>

    <x-calc.result label="Information ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['portfolio' => 12, 'benchmark' => 9, 'te' => 4],
        'Example B' => ['portfolio' => 7.5, 'benchmark' => 8.2, 'te' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Active return'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>IR = (Rp − Rb) ÷ tracking error</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
