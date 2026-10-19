<x-calc.page
    title="Trump Tariff Calculator - SolveKit"
    description="Free Trump Tariff Calculator: landed cost = value + freight + duty + fees. Estimates the cost of imported goods with the tariff rate you enter."
    lede="Work out the landed cost from your figures."
    about="Estimates the cost of imported goods with the tariff rate you enter. US duties are on the customs value (FOB); enter freight only if your country taxes CIF. Rates change often, so check the current schedule (USITC HTS). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'tariff', 'fields' => ['value', 'tariff', 'shipping', 'fees']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Customs value of the goods, Tariff rate you face, Freight and insurance (if dutiable), Other fees (MPF, HMF, broker).'],
        ['name' => 'Read the result', 'text' => 'The landed cost appears as you type, with duty, duty as share of value below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the landed cost?', 'answer' => 'Landed cost = value + freight + duty + fees.'],
        ['question' => 'What is the landed cost for customs value of the goods $10,000, tariff rate you face 25%, freight and insurance $800, other fees $150?', 'answer' => '$13,650.00. Duty: $2,700.00.'],
        ['question' => 'And for customs value of the goods $2,500, tariff rate you face 10%, freight and insurance $0, other fees $30?', 'answer' => '$2,780.00. Duty: $250.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'This does not look up rates.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Customs value of the goods" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="tariff" label="Tariff rate you face" value="25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shipping" label="Freight and insurance (if dutiable)" value="800" step="0.01" suffix="$" />
        <x-calc.field name="fees" label="Other fees (MPF, HMF, broker)" value="150" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Landed cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['value' => 10000, 'tariff' => 25, 'shipping' => 800, 'fees' => 150],
        'Example B' => ['value' => 2500, 'tariff' => 10, 'shipping' => 0, 'fees' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Duty'],
            'r2' => ['label' => 'Duty as share of value'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>landed cost = value + freight + duty + fees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
