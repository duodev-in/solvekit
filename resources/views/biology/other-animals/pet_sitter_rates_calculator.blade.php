<x-calc.page
    title="Pet Sitter Rates Calculator - SolveKit"
    description="Free pet sitter rates calculator: cost per visit, per day and in total for drop-in visits, extra pets and holidays."
    lede="Work out what pet sitting will cost, or what to charge."
    about="Pet sitters usually price a base visit of about 30 minutes, plus a fee for each extra pet and a surcharge on holidays. Enter your own local rates; the defaults are only examples."
    :calc="['engine' => 'animals', 'tool' => 'pet_sitter', 'fields' => ['rate', 'minutes', 'visits', 'days', 'pets', 'pet_fee', 'holiday']]"
    :how-to="[
        ['name' => 'Enter the rate', 'text' => 'Your sitter\'s or your own price.'],
        ['name' => 'Set visits and days', 'text' => 'How often and for how long.'],
        ['name' => 'Add extras', 'text' => 'Extra pets and holiday surcharge.'],
    ]"
    :faqs="[
        ['question' => 'How much do pet sitters charge?', 'answer' => 'Rates vary widely by area; ask locally or check sitter apps.'],
        ['question' => 'Is overnight sitting priced the same?', 'answer' => 'No, overnight stays are usually a flat nightly rate.'],
        ['question' => 'Should I tip a pet sitter?', 'answer' => 'Many people tip 15 to 20% or give a gift for long or holiday bookings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Rate per 30-minute visit" value="25" min="0" suffix="$" help="Example rate; use local prices" />
        <x-calc.field name="minutes" label="Minutes per visit" value="30" min="0" step="5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="visits" label="Visits per day" value="2" min="1" step="1" />
        <x-calc.field name="days" label="Days" value="7" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pets" label="Pets" value="2" min="1" step="1" />
        <x-calc.field name="pet_fee" label="Each extra pet" value="5" min="0" suffix="$" />
        <x-calc.field name="holiday" label="Holiday surcharge" value="0" min="0" suffix="%" />
    </div>

    <x-calc.result label="Total cost" />

    <x-calc.options :examples="[
        'Week, 2 visits a day' => ['rate' => 25, 'minutes' => 30, 'visits' => 2, 'days' => 7, 'pets' => 2, 'pet_fee' => 5, 'holiday' => 0],
        'Holiday weekend' => ['rate' => 25, 'minutes' => 30, 'visits' => 3, 'days' => 3, 'pets' => 1, 'pet_fee' => 5, 'holiday' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_visit' => ['label' => 'Per visit'],
            'per_day' => ['label' => 'Per day'],
            'per_week' => ['label' => 'Per week'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per visit = rate × minutes ÷ 30 + extra pets × fee</li>
            <li>total = per visit × visits × days × (1 + surcharge)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
