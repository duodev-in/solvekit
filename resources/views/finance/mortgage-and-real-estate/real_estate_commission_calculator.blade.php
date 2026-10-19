<x-calc.page
    title="Real Estate Commission Calculator - SolveKit"
    description="Free Real Estate Commission Calculator: commission = price × rate. Commission is negotiable; since August 2024 US buyer-agent pay is agreed separately (NAR settlement)."
    lede="Work out the total commission from sale price, commission rate and listing side share."
    about="Commission is negotiable; since August 2024 US buyer-agent pay is agreed separately (NAR settlement). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'real_estate_commission', 'fields' => ['price', 'rate', 'split']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Sale price, Commission rate, Listing side share.'],
        ['name' => 'Read the result', 'text' => 'The total commission appears as you type, with listing side, buyer side, seller nets before other costs below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the total commission?', 'answer' => 'Commission = price × rate.'],
        ['question' => 'What is the total commission for sale price $400,000, commission rate 5%, listing side share 50%?', 'answer' => '$20,000.00. Listing side: $10,000.00.'],
        ['question' => 'And for sale price $750,000, commission rate 4.5%, listing side share 55%?', 'answer' => '$33,750.00. Listing side: $18,562.50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Each agent\'s brokerage usually takes part of their share.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Sale price" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Commission rate" value="5" step="any" suffix="%" />
        <x-calc.field name="split" label="Listing side share" value="50" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total commission" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 400000, 'rate' => 5, 'split' => 50],
        'Example B' => ['price' => 750000, 'rate' => 4.5, 'split' => 55],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Listing side'],
            'r2' => ['label' => 'Buyer side'],
            'r3' => ['label' => 'Seller nets before other costs'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>commission = price × rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
