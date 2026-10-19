<x-calc.page
    title="NSFR Calculator - SolveKit"
    description="Free NSFR Calculator: NSFR = available ÷ required stable funding. Basel III's NSFR makes banks fund long-term assets with stable funding over one year."
    lede="Work out the net stable funding ratio from available stable funding and required stable funding."
    about="Basel III's NSFR makes banks fund long-term assets with stable funding over one year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'nsfr', 'fields' => ['asf', 'rsf']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Available stable funding, Required stable funding.'],
        ['name' => 'Read the result', 'text' => 'The net stable funding ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net stable funding ratio?', 'answer' => 'NSFR = available ÷ required stable funding.'],
        ['question' => 'What is the net stable funding ratio for available stable funding $110,000,000, required stable funding $100,000,000?', 'answer' => '110%.'],
        ['question' => 'And for available stable funding $95, required stable funding $100?', 'answer' => '95%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The minimum is 100%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="asf" label="Available stable funding" value="110000000" step="0.01" suffix="$" />
        <x-calc.field name="rsf" label="Required stable funding" value="100000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net stable funding ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['asf' => 110000000, 'rsf' => 100000000],
        'Example B' => ['asf' => 95, 'rsf' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NSFR = available ÷ required stable funding</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
