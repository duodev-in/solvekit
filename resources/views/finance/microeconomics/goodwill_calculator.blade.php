<x-calc.page
    title="Goodwill Calculator - SolveKit"
    description="Free Goodwill Calculator: goodwill = price − fair value of net identifiable assets. Goodwill is the premium paid in an acquisition above the fair value of net assets."
    lede="Work out the goodwill from purchase price, fair value of identifiable assets and fair value of liabilities."
    about="Goodwill is the premium paid in an acquisition above the fair value of net assets. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'goodwill', 'fields' => ['price', 'assets', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Purchase price, Fair value of identifiable assets, Fair value of liabilities.'],
        ['name' => 'Read the result', 'text' => 'The goodwill appears as you type, with net identifiable assets below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the goodwill?', 'answer' => 'Goodwill = price − fair value of net identifiable assets.'],
        ['question' => 'What is the goodwill for purchase price $10,000,000, fair value of identifiable assets $12,000,000, fair value of liabilities $4,000,000?', 'answer' => '$2,000,000.00. Net identifiable assets: $8,000,000.00.'],
        ['question' => 'And for purchase price $2,500,000, fair value of identifiable assets $3,000,000, fair value of liabilities $900,000?', 'answer' => '$400,000.00. Net identifiable assets: $2,100,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative goodwill is a bargain purchase gain.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Purchase price" value="10000000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Fair value of identifiable assets" value="12000000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Fair value of liabilities" value="4000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Goodwill" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 10000000, 'assets' => 12000000, 'liabilities' => 4000000],
        'Example B' => ['price' => 2500000, 'assets' => 3000000, 'liabilities' => 900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Net identifiable assets'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>goodwill = price − fair value of net identifiable assets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
