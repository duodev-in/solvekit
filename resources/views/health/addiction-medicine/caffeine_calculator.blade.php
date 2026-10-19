<x-calc.page
    title="Caffeine Calculator - SolveKit"
    description="Free caffeine calculator: caffeine from your coffee, tea, cola and energy drinks today, how much is left at bedtime and when it drops below 50 mg."
    lede="Count your caffeine."
    about="Caffeine values come from USDA FoodData Central; caffeine is cleared with a half-life of about 5 hours in adults (EFSA 2015), longer in pregnancy. The FDA cites 400 mg a day as generally safe for healthy adults; EFSA advises 200 mg a day in pregnancy. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'fd-drinks', 'tool' => 'caffeine_curve', 'fields' => ['drinks', 'bedtime', 'half_life', 'weight'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Add drinks with times', 'text' => ''],
        ['name' => 'Set bedtime', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much caffeine is left at bedtime after coffee, tea and a cola?', 'answer' => '38 mg (175 mg taken today; half-life 5 h).'],
    ]"
>
    <x-calc.rows-editor name="drinks" label="Drinks today (time, drink, how many)" :columns="['time' => 'Time', 'drink' => 'Drink', 'count' => 'How many']" :rows="[['07:30', 'Brewed coffee', '1'], ['13:00', 'Black tea', '1'], ['16:00', 'Cola', '1']]" add-label="Add drink" :text="['time', 'drink', 'count']" :lists="['drink' => ['Brewed coffee', 'Espresso (single shot)', 'Instant coffee (1 tsp)', 'Black tea', 'Green tea', 'Cola', 'Energy drink (Red Bull)', 'Dark chocolate (1 oz)']]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bedtime" label="Bedtime" value="22:30" type="time" />
        <x-calc.field name="half_life" label="Half-life" value="5" min="0" step="any" suffix="h" />
        <x-calc.field name="weight" label="Body weight (optional)" value="" min="0" step="any" suffix="kg" placeholder="Optional" />
    </div>

    <x-calc.result label="Caffeine left at bedtime" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['drinks' => '07:30	Brewed coffee	1
13:00	Black tea	1
16:00	Cola	1', 'bedtime' => '22:30', 'half_life' => 5, 'weight' => ''],
        'Pregnancy (slower)' => ['drinks' => '08:00	Brewed coffee	1', 'bedtime' => '22:00', 'half_life' => 10, 'weight' => ''],
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
            <li>amount = Σ dose × 0.5^(hours ÷ half-life)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
