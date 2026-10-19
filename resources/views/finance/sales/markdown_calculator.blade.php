<x-calc.page
    title="Markdown Calculator - SolveKit"
    description="Free Markdown Calculator: markdown = (original − sale) ÷ original. A markdown is a permanent price reduction, usually to clear stock."
    lede="Work out the markdown from original price and marked-down price."
    about="A markdown is a permanent price reduction, usually to clear stock. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'markdown', 'fields' => ['original', 'sale']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Original price, Marked-down price.'],
        ['name' => 'Read the result', 'text' => 'The markdown appears as you type, with amount below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the markdown?', 'answer' => 'Markdown = (original − sale) ÷ original.'],
        ['question' => 'What is the markdown for original price $120, marked-down price $90?', 'answer' => '25%. Amount: $30.00.'],
        ['question' => 'And for original price $59.99, marked-down price $39.99?', 'answer' => '33.34%. Amount: $20.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Markdowns reduce gross margin.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="original" label="Original price" value="120" step="0.01" suffix="$" />
        <x-calc.field name="sale" label="Marked-down price" value="90" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Markdown" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['original' => 120, 'sale' => 90],
        'Example B' => ['original' => 59.99, 'sale' => 39.99],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Amount'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>markdown = (original − sale) ÷ original</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
