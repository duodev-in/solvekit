<x-calc.page
    title="Quarantine Silver Lining Calculator - SolveKit"
    description="Free quarantine silver lining calculator: the hours and money gained by not commuting or traveling while staying home."
    lede="Count the time and money you gain by staying home."
    about="Time gained = (commute minutes + other travel saved) a day × days at home; money saved = daily travel costs × days. Made for lockdowns, it works for remote work or any stay at home."
    :calc="['engine' => 'ev-fun', 'tool' => 'silver_lining', 'fields' => ['commute', 'other', 'days', 'cost']]"
    :how-to="[
        ['name' => 'Enter the time saved', 'text' => 'Commute and other travel.'],
        ['name' => 'Enter days and costs', 'text' => 'Fuel, fares or parking.'],
    ]"
    :faqs="[
        ['question' => 'How much time does working from home save?', 'answer' => '65 minutes a day for 60 days is 65 hours.'],
        ['question' => 'What could I do with it?', 'answer' => 'About 10 novels at average reading speed.'],
        ['question' => 'Does it count lost social time?', 'answer' => 'No, just the travel you avoid.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="commute" label="Commute saved a day" value="50" min="0" step="5" suffix="min" />
        <x-calc.field name="other" label="Other time saved a day" value="15" min="0" step="5" suffix="min" />
        <x-calc.field name="days" label="Days" value="60" min="1" step="1" />
    </div>

    <x-calc.field name="cost" label="Travel cost saved a day" value="9" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Time won back" />

    <x-calc.options :decimals="false" :examples="[
        '60 days at home' => ['commute' => 50, 'other' => 15, 'days' => 60, 'cost' => 9],
        'A year remote' => ['commute' => 60, 'other' => 0, 'days' => 230, 'cost' => 12],
        'Two weeks' => ['commute' => 30, 'other' => 20, 'days' => 14, 'cost' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'days' => ['label' => 'In days'],
            'money' => ['label' => 'Money'],
            'books' => ['label' => 'Books'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = minutes a day × days ÷ 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
