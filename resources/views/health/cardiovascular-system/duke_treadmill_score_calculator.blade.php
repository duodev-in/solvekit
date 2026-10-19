<x-calc.page
    title="Duke Treadmill Score Calculator - SolveKit"
    description="Free Duke treadmill score calculator: exercise time, ST deviation and angina index on a Bruce protocol stress test, with the risk group and 5-year survival."
    lede="Calculate the Duke treadmill score."
    about="Duke treadmill score = exercise time (minutes, Bruce protocol) − 5 × maximum ST deviation (mm) − 4 × angina index (0 none, 1 non-limiting, 2 exercise-limiting). Scores of +5 or more are low risk, −10 to +4 moderate and −11 or less high (Mark et al. 1991). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'duke', 'fields' => ['minutes', 'st', 'angina']]"
    :how-to="[
        ['name' => 'Enter the Bruce protocol time', 'text' => ''],
        ['name' => 'Enter ST deviation and angina', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the score for 9 minutes, 1 mm ST depression and no angina?', 'answer' => '4.0: Moderate risk (−10 to +4): about 90% 5-year survival in the original cohort.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="minutes" label="Exercise time" value="9" min="0" step="any" suffix="min" />
        <x-calc.field name="st" label="Maximum ST deviation" value="1" min="0" step="any" suffix="mm" />
        <x-calc.select name="angina" label="Angina during the test" :options="['none' => 'None (0)', 'nonlimiting' => 'Non-limiting (1)', 'limiting' => 'Exercise-limiting (2)']" selected="none" />
    </div>

    <x-calc.result label="Duke treadmill score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['minutes' => 9, 'st' => 1, 'angina' => 'none'],
        'High risk' => ['minutes' => 4, 'st' => 3, 'angina' => 'limiting'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Working'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DTS = time − 5 × ST − 4 × angina</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
