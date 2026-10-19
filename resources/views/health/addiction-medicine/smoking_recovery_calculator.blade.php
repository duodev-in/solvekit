<x-calc.page
    title="Smoking Recovery Calculator - SolveKit"
    description="Free smoking recovery calculator: how your body recovers after quitting, milestone by milestone, with cigarettes avoided and money saved."
    lede="See how your body recovers after quitting."
    about="Benefits start within minutes of quitting and build over years: blood pressure and heart rate fall within 20 minutes, carbon monoxide clears within a day, lung function improves over months, and after 10–15 years risks of lung cancer and heart disease approach those of non-smokers (US Surgeon General 2020, CDC). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'recovery', 'fields' => ['quit', 'today', 'per_day', 'price']]"
    :how-to="[
        ['name' => 'Enter your quit date', 'text' => ''],
        ['name' => 'Add how much you smoked', 'text' => 'To see the savings.'],
    ]"
    :faqs="[
        ['question' => 'What has changed 140 days after quitting?', 'answer' => '4 of 8 recovery milestones reached; next on Jun 1, 2027.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="quit" label="Quit date" value="2026-06-01" type="date" />
        <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="per_day" label="Cigarettes a day before" value="15" min="0" step="1" />
        <x-calc.field name="price" label="Price per pack" value="10" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Smoke-free" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['quit' => '2026-06-01', 'today' => '2026-10-19', 'per_day' => 15, 'price' => 10],
        'Two years' => ['quit' => '2024-09-01', 'today' => '2026-10-19', 'per_day' => 20, 'price' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'next' => ['label' => 'Next milestone'],
            'saved' => ['label' => 'Money saved'],
            'avoided' => ['label' => 'Cigarettes avoided'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Milestones" name="milestones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = today − quit date</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
