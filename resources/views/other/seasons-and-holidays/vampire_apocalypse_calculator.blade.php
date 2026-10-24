<x-calc.page
    title="Vampire Apocalypse Calculator - SolveKit"
    description="Free vampire apocalypse calculator: how fast vampires would wipe out humanity in a simple growth model."
    lede="Model a vampire apocalypse."
    about="If every vampire turns one human a month, vampires double every month — physicists used this to argue vampires cannot exist."
    :calc="['engine' => 'ot-play', 'tool' => 'vampire', 'fields' => ['population', 'vampires', 'bites', 'births'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long would one vampire take to end humanity?', 'answer' => 'About 36 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="population" label="Starting human population" value="8100000000" min="1" step="any" />
        <x-calc.field name="vampires" label="Starting vampires" value="1" min="1" step="any" />
        <x-calc.field name="bites" label="New vampires each vampire makes per month" value="1" min="0" step="any" />
        <x-calc.field name="births" label="Human births per month (% of population)" value="0.1" min="0" step="any" />
    </div>

    <x-calc.result label="Months until no humans are left" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['population' => 8100000000, 'vampires' => 1, 'bites' => 1, 'births' => 0.1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Humans (blue) and vampires (dashed) over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'years' => ['label' => 'In years'],
            'curve' => ['label' => 'Vampires after 12 months'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
