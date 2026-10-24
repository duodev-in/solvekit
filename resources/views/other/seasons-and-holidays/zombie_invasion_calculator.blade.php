<x-calc.page
    title="Zombie Invasion Calculator - SolveKit"
    description="Free zombie invasion calculator: the classic SZR model of a zombie outbreak, solved day by day."
    lede="Model a zombie outbreak."
    about="Mathematicians modelled a zombie outbreak like an epidemic: humans are bitten, zombies destroyed, and the dead may rise."
    :calc="['engine' => 'ot-play', 'tool' => 'zombie', 'fields' => ['population', 'zombies', 'beta', 'alpha', 'zeta', 'days'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Who wins in the example?', 'answer' => 'The zombies win.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="population" label="Starting humans" value="1000000" min="1" step="any" />
        <x-calc.field name="zombies" label="Starting zombies" value="10" min="1" step="any" />
        <x-calc.field name="beta" label="Bite rate β (per day)" value="0.6" min="0" step="any" />
        <x-calc.field name="alpha" label="Zombie kill rate α (per day)" value="0.4" min="0" step="any" />
        <x-calc.field name="zeta" label="Resurrection rate ζ (per day)" value="0.05" min="0" step="any" />
        <x-calc.field name="days" label="Days to simulate" value="60" min="1" step="any" />
    </div>

    <x-calc.result label="Outcome" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['population' => 1000000, 'zombies' => 10, 'beta' => 0.6, 'alpha' => 0.4, 'zeta' => 0.05, 'days' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Humans (blue), zombies (dashed)" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'day' => ['label' => 'Day humans fall below 1%'],
            'end' => ['label' => 'At the end: humans, zombies, removed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
