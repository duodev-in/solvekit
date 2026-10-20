<x-calc.page
    title="Olber's Paradox - SolveKit"
    description="Free Olbers' paradox calculator: why the night sky is dark, from star density, star size and the age of the universe."
    lede="Explore why the night is dark."
    about="If the universe were infinite, eternal and full of stars, every line of sight would end on a star and the sky would be as bright as the Sun. A finite age (and expansion) means we see only a tiny fraction of the stars needed."
    :calc="['engine' => 'ph-astro', 'tool' => 'olbers', 'fields' => ['n', 'Rs', 'age'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much of the sky do stars cover?', 'answer' => '0.0000676%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Star density (stars per cubic parsec)" value="0.1" min="0" step="any" />
        <x-calc.field name="Rs" label="Typical star radius (solar radii)" value="1" min="0" step="any" />
        <x-calc.field name="age" label="Age of the universe (billion years)" value="13.8" min="0" step="any" />
    </div>

    <x-calc.result label="Share of the sky covered by stars" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 0.1, 'Rs' => 1, 'age' => 13.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mfp' => ['label' => 'Distance a sightline travels before hitting a star'],
            'reach' => ['label' => 'How far we can see (light travel distance)'],
            'verdict' => ['label' => 'Why the sky is dark'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
