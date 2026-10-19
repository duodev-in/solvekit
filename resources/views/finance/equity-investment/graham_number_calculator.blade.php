<x-calc.page
    title="Graham Number Calculator - SolveKit"
    description="Free Graham Number Calculator: Graham number = √(22.5 × EPS × BVPS). Benjamin Graham suggested a defensive investor pay at most 15 times earnings and 1.5 times book value; 15 × 1.5 = 22.5."
    lede="Work out the Graham number from earnings per share and book value per share."
    about="Benjamin Graham suggested a defensive investor pay at most 15 times earnings and 1.5 times book value; 15 × 1.5 = 22.5. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'graham_number', 'fields' => ['eps', 'bvps']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Earnings per share, Book value per share.'],
        ['name' => 'Read the result', 'text' => 'The Graham number appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Graham number?', 'answer' => 'Graham number = √(22.5 × EPS × BVPS).'],
        ['question' => 'What is the Graham number for earnings per share $4, book value per share $30?', 'answer' => '$51.96.'],
        ['question' => 'And for earnings per share $2.20, book value per share $18?', 'answer' => '$29.85.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Only meaningful for positive earnings and book value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="eps" label="Earnings per share" value="4" step="0.01" suffix="$" />
        <x-calc.field name="bvps" label="Book value per share" value="30" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Graham number" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['eps' => 4, 'bvps' => 30],
        'Example B' => ['eps' => 2.2, 'bvps' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Graham number = √(22.5 × EPS × BVPS)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
