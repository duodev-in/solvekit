<x-calc.page
    title="PEG Ratio Calculator - SolveKit"
    description="Free PEG Ratio Calculator: PEG = P/E ÷ EPS growth (%). The PEG ratio adjusts the P/E for growth (Peter Lynch)."
    lede="Work out the PEG ratio from P/E ratio and annual EPS growth."
    about="The PEG ratio adjusts the P/E for growth (Peter Lynch). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'peg_ratio', 'fields' => ['pe', 'growth']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'P/E ratio, Annual EPS growth.'],
        ['name' => 'Read the result', 'text' => 'The PEG ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the PEG ratio?', 'answer' => 'PEG = P/E ÷ EPS growth (%).'],
        ['question' => 'What is the PEG ratio for P/E ratio 25, annual EPS growth 15%?', 'answer' => '1.667.'],
        ['question' => 'And for P/E ratio 14, annual EPS growth 20%?', 'answer' => '0.7.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Around 1 is often called fairly valued; it depends on the growth estimate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pe" label="P/E ratio" value="25" step="any" />
        <x-calc.field name="growth" label="Annual EPS growth" value="15" step="any" suffix="%" />
    </div>

    <x-calc.result label="PEG ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['pe' => 25, 'growth' => 15],
        'Example B' => ['pe' => 14, 'growth' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PEG = P/E ÷ EPS growth (%)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
