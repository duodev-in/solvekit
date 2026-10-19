<x-calc.page
    title="ADR Calculator - SolveKit"
    description="Free ADR Calculator: ADR = room revenue ÷ rooms sold. Average daily rate is the average price paid per occupied room."
    lede="Work out the average daily rate from room revenue and rooms sold."
    about="Average daily rate is the average price paid per occupied room. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'adr', 'fields' => ['revenue', 'rooms']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Room revenue, Rooms sold.'],
        ['name' => 'Read the result', 'text' => 'The average daily rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the average daily rate?', 'answer' => 'ADR = room revenue ÷ rooms sold.'],
        ['question' => 'What is the average daily rate for room revenue $45,000, rooms sold 300?', 'answer' => '$150.00.'],
        ['question' => 'And for room revenue $128,000, rooms sold 820?', 'answer' => '$156.10.'],
        ['question' => 'What does the result tell me?', 'answer' => 'RevPAR = ADR × occupancy.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Room revenue" value="45000" step="0.01" suffix="$" />
        <x-calc.field name="rooms" label="Rooms sold" value="300" step="any" />
    </div>

    <x-calc.result label="Average daily rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 45000, 'rooms' => 300],
        'Example B' => ['revenue' => 128000, 'rooms' => 820],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ADR = room revenue ÷ rooms sold</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
