<x-calc.page
    title="Coffee Kick Calculator - SolveKit"
    description="Free caffeine calculator: how much caffeine is in your body now and at bedtime from the drinks you had today, with a curve over the day and when it falls below 100 mg and 50 mg."
    lede="Track caffeine through your day."
    about="Caffeine is absorbed within about an hour and then cleared at a steady rate: half of it is gone every half-life, about 5 hours on average for adults (EFSA 2015), though it ranges from 2 to 10 hours (shorter for smokers, longer in pregnancy or with some medicines). Caffeine per drink comes from USDA FoodData Central. The FDA cites 400 mg a day as an amount not generally linked with negative effects in healthy adults. This is an estimate. General information, not medical advice."
    :calc="['engine' => 'fd-drinks', 'tool' => 'caffeine_curve', 'fields' => ['drinks', 'bedtime', 'half_life', 'weight'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Add each drink with its time', 'text' => 'Pick a drink from the list.'],
        ['name' => 'Set bedtime and half-life', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much caffeine is left at bedtime after coffee, two espressos, a cola and tea?', 'answer' => '65 mg at 22:30 (301 mg taken today; half-life 5 h).'],
        ['question' => 'What if my half-life is 8 hours?', 'answer' => '113 mg.'],
    ]"
>
    <x-calc.rows-editor name="drinks" label="Drinks today (time, drink, how many)" :columns="['time' => 'Time', 'drink' => 'Drink', 'count' => 'How many']" :rows="[['07:30', 'Brewed coffee', '1'], ['10:30', 'Espresso (single shot)', '2'], ['14:00', 'Cola', '1'], ['16:00', 'Black tea', '1']]" add-label="Add drink" :text="['time', 'drink', 'count']" :lists="['drink' => ['Brewed coffee', 'Espresso (single shot)', 'Instant coffee (1 tsp)', 'Black tea', 'Green tea', 'Cola', 'Energy drink (Red Bull)', 'Dark chocolate (1 oz)']]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bedtime" label="Bedtime" value="22:30" type="time" />
        <x-calc.field name="half_life" label="Half-life" value="5" min="0" step="any" suffix="h" />
        <x-calc.field name="weight" label="Body weight (optional)" value="" min="0" step="any" suffix="kg" placeholder="Optional" />
    </div>

    <x-calc.result label="Caffeine left at bedtime" />

    <x-calc.options :decimals="false" :examples="[
        'Workday' => ['drinks' => '07:30	Brewed coffee	1
10:30	Espresso (single shot)	2
14:00	Cola	1
16:00	Black tea	1', 'bedtime' => '22:30', 'half_life' => 5, 'weight' => ''],
        'Slow clearance' => ['drinks' => '07:30	Brewed coffee	1
10:30	Espresso (single shot)	2
14:00	Cola	1
16:00	Black tea	1', 'bedtime' => '22:30', 'half_life' => 8, 'weight' => ''],
        'One morning coffee' => ['drinks' => '08:00	Brewed coffee	1', 'bedtime' => '22:00', 'half_life' => 5, 'weight' => 70],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Caffeine through the day" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Taken today'],
            'peak' => ['label' => 'Peak'],
            'below100' => ['label' => 'Below 100 mg'],
            'below50' => ['label' => 'Below 50 mg'],
        ]" />
        <x-calc.grid heading="Drinks" name="drinks" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>amount(t) = Σ dose × 0.5^((t − t₀) ÷ half-life)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
