<x-calc.page
    title="Crickets Chirping Thermometer - SolveKit"
    description="Free cricket chirp thermometer: estimate air temperature from cricket chirps using Dolbear's law."
    lede="Estimate the temperature by counting cricket chirps."
    about="Crickets chirp faster when it is warmer. Dolbear's law (1897) for the snowy tree cricket is T(°F) = 50 + (N − 40) ÷ 4, with N chirps per minute. For common field crickets a rough rule is chirps in 14 seconds plus 40."
    :calc="['engine' => 'animals', 'tool' => 'cricket', 'fields' => ['species', 'chirps', 'seconds']]"
    :how-to="[
        ['name' => 'Count the chirps', 'text' => 'Of one insect, for 15 seconds or a minute.'],
        ['name' => 'Pick the insect', 'text' => 'Snowy tree crickets fit best.'],
    ]"
    :faqs="[
        ['question' => 'What is Dolbear\'s law?', 'answer' => 'T(°F) = 50 + (chirps per minute − 40) ÷ 4, published by Amos Dolbear in 1897.'],
        ['question' => 'How accurate is it?', 'answer' => 'Within a few degrees for snowy tree crickets; less so for other species.'],
        ['question' => 'Why do crickets chirp faster when it is warm?', 'answer' => 'They are cold-blooded, so their muscles work faster at higher temperatures.'],
    ]"
>
    <x-calc.select name="species" label="Insect" :options="['snowy' => 'Snowy tree cricket (Dolbear)', 'field' => 'Field cricket', 'katydid' => 'True katydid']" selected="snowy" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="chirps" label="Chirps counted" value="30" min="0" step="1" />
        <x-calc.field name="seconds" label="Counting time" value="15" min="0" suffix="s" />
    </div>

    <x-calc.result label="Air temperature" />

    <x-calc.options :examples="[
        '30 in 15 s' => ['species' => 'snowy', 'chirps' => 30, 'seconds' => 15],
        '160 a minute' => ['species' => 'snowy', 'chirps' => 160, 'seconds' => 60],
        'Field cricket 35 in 14 s' => ['species' => 'field', 'chirps' => 35, 'seconds' => 14],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'celsius' => ['label' => 'In Celsius'],
            'rate' => ['label' => 'Chirp rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>snowy tree cricket: T(°F) = 50 + (N − 40) ÷ 4</li>
            <li>field cricket: T(°F) ≈ chirps in 14 s + 40</li>
            <li>katydid: T(°F) = 60 + (N − 19) ÷ 3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
