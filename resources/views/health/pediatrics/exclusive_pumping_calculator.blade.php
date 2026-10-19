<x-calc.page
    title="Exclusive Pumping Calculator - SolveKit"
    description="Free exclusive pumping calculator: total milk pumped a day compared with what babies typically need at each age, with per-session targets."
    lede="Check your daily pumping output."
    about="Milk supply builds over the first weeks: often 300–600 mL a day in week 2 and about 750–1,035 mL (25–35 oz) a day from around a month, when it levels off. Exclusively pumping parents are usually advised 8–12 sessions a day at first, including one overnight, then 6–8 once supply is established. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pumping', 'fields' => ['weeks', 'sessions', 'output', 'unit']]"
    :how-to="[
        ['name' => 'Enter baby\'s age and sessions', 'text' => ''],
        ['name' => 'Enter the amount per session', 'text' => 'Both sides together.'],
    ]"
    :faqs="[
        ['question' => 'Is 8 sessions of 100 mL enough at 6 weeks?', 'answer' => '800 mL (27.1 oz): Within the typical 750–1,035 mL a day.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weeks" label="Baby's age" value="6" min="0" max="60" step="1" suffix="weeks" />
        <x-calc.field name="sessions" label="Sessions a day" value="8" min="1" max="16" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="output" label="Amount per session" value="100" min="0" step="any" />
        <x-calc.segmented name="unit" legend="Unit" :options="['ml' => 'mL', 'oz' => 'oz']" selected="ml" />
    </div>

    <x-calc.result label="Milk pumped a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weeks' => 6, 'sessions' => 8, 'output' => 100, 'unit' => 'ml'],
        'In ounces' => ['weeks' => 3, 'sessions' => 10, 'output' => 2.5, 'unit' => 'oz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'target' => ['label' => 'Typical at this age'],
            'perSession' => ['label' => 'Per session'],
            'sessions' => ['label' => 'Sessions'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>daily = sessions × amount</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
