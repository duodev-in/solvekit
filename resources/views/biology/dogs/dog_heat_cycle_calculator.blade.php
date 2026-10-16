<x-calc.page
    title="Dog Heat Cycle Calculator - SolveKit"
    description="Free dog heat cycle calculator: next heat dates, proestrus and fertile window from the start of the last heat."
    lede="Predict your dog's next heat and fertile days."
    about="Most dogs come into heat about every 6 months, small breeds more often and giant breeds as rarely as once a year. A heat lasts about 2 to 3 weeks: proestrus (swelling and bleeding) for about 9 days, then estrus, when she is fertile, usually around days 9 to 14. Cycles are often irregular in young dogs; use progesterone tests for breeding."
    :calc="['engine' => 'pets', 'tool' => 'heat_cycle', 'fields' => ['size', 'date']]"
    :how-to="[
        ['name' => 'Pick the size', 'text' => 'It sets the typical interval.'],
        ['name' => 'Enter the first day', 'text' => 'When you first saw swelling or bleeding.'],
    ]"
    :faqs="[
        ['question' => 'How often do dogs go into heat?', 'answer' => 'About twice a year; small breeds up to 3 times, giant breeds about once.'],
        ['question' => 'How long does a heat last?', 'answer' => 'About 2 to 3 weeks.'],
        ['question' => 'When is a dog most fertile?', 'answer' => 'Usually around days 9 to 14, but it varies; progesterone tests pinpoint ovulation.'],
    ]"
>
    <x-calc.select name="size" label="Size" :options="['small' => 'Small (under 20 lb)', 'medium' => 'Medium (21–50 lb)', 'large' => 'Large (51–100 lb)', 'giant' => 'Giant (over 100 lb)']" selected="medium" />

    <x-calc.field name="date" label="First day of the last heat" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Next heat expected" />

    <x-calc.options :decimals="false" :examples="[
        'Started 30 days ago' => ['date' => now()->subDays(30)->toDateString(), 'size' => 'medium'],
        'Small dog, 4 months ago' => ['date' => now()->subDays(120)->toDateString(), 'size' => 'small'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'proestrus' => ['label' => 'Proestrus (last heat)'],
            'fertile' => ['label' => 'Likely fertile days'],
            'end' => ['label' => 'Heat ends'],
            'window' => ['label' => 'Next heat window'],
        ]" />
        <x-calc.quick-ref heading="Next three heats" name="cycles" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>next heat = start + 5 / 6 / 7 / 12 months (small / medium / large / giant)</li>
            <li>fertile ≈ days 9 to 14</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
