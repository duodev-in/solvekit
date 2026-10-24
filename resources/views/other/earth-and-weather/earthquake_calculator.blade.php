<x-calc.page
    title="Earthquake Calculator - SolveKit"
    description="Free earthquake calculator: energy released, TNT equivalent and comparison of two magnitudes."
    lede="Compare earthquake magnitudes."
    about="Each step of magnitude means about 32 times more energy."
    :calc="['engine' => 'ot-misc', 'tool' => 'earthquake', 'fields' => ['m', 'm2'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much energy does a magnitude 7.8 quake release?', 'answer' => '3.162 × 10¹⁶ J.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Magnitude (moment magnitude Mw)" value="7.8" min="0" step="any" />
        <x-calc.field name="m2" label="Compare with magnitude (optional)" value="6" min="0" step="any" />
    </div>

    <x-calc.result label="Energy released" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m' => 7.8, 'm2' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tnt' => ['label' => 'TNT equivalent'],
            'moment' => ['label' => 'Seismic moment M₀'],
            'compare' => ['label' => 'Compared with the other quake'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
