<x-calc.page
    title="New Year's Resolutions Calculator - SolveKit"
    description="Free New Year's resolutions calculator: how many people are still keeping their resolution after a number of weeks."
    lede="Check your resolution odds."
    about="A classic study followed 200 people’s resolutions for two years."
    :calc="['engine' => 'ot-misc', 'tool' => 'resolutions', 'fields' => ['weeks'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['resolutions'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many keep their resolution for a month?', 'answer' => 'About 55%.'],
    ]"
>
    <x-calc.field name="weeks" label="Weeks since 1 January" value="4" min="0" step="any" />

    <x-calc.result label="Share still on track" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weeks' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Resolvers still keeping their resolution" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'odds' => ['label' => 'Your chance from here (if like the study)'],
            'milestones' => ['label' => 'Study milestones'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
