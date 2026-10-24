<x-calc.page
    title="Rounds per Minute Calculator - SolveKit"
    description="Free rounds per minute calculator: rate of fire from rounds and time."
    lede="Find the rate of fire."
    about="Rate of fire is rounds per minute."
    :calc="['engine' => 'ot-misc', 'tool' => 'rpm_rounds', 'fields' => ['rounds', 'seconds'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What rate is 30 rounds in 3 seconds?', 'answer' => '600 rounds/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rounds" label="Rounds fired" value="30" min="1" step="any" />
        <x-calc.field name="seconds" label="In seconds" value="3" min="0" step="any" />
    </div>

    <x-calc.result label="Rate of fire" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rounds' => 30, 'seconds' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rps' => ['label' => 'Rounds per second'],
            'gap' => ['label' => 'Time between rounds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
