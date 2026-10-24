<x-calc.page
    title="KD Calculator (Kill/Death Ratio) - SolveKit"
    description="Free K/D calculator: kill/death ratio and KDA, and kills needed for a target K/D."
    lede="Find your K/D ratio."
    about="K/D compares kills with deaths; above 1 means more kills than deaths."
    :calc="['engine' => 'ot-play', 'tool' => 'kd', 'fields' => ['kills', 'deaths', 'assists', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is 145 kills and 92 deaths?', 'answer' => '1.576.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="kills" label="Kills" value="145" min="0" step="any" />
        <x-calc.field name="deaths" label="Deaths" value="92" min="0" step="any" />
        <x-calc.field name="assists" label="Assists" value="60" min="0" step="any" />
        <x-calc.field name="target" label="Target K/D (optional)" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="K/D ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kills' => 145, 'deaths' => 92, 'assists' => 60, 'target' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kda' => ['label' => 'KDA ((K + A) ÷ D)'],
            'needed' => ['label' => 'Kills in a row (no deaths) to reach the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
