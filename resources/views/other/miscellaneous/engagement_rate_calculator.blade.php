<x-calc.page
    title="Engagement Rate Calculator - SolveKit"
    description="Free engagement rate calculator: social-media engagement by followers, reach or impressions."
    lede="Find an engagement rate."
    about="Engagement rate shows how many people interact with a post compared with the audience."
    :calc="['engine' => 'ot-misc', 'tool' => 'engagement', 'fields' => ['likes', 'comments', 'shares', 'saves', 'followers', 'reach', 'impressions'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the engagement rate in the example?', 'answer' => '3.84%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="likes" label="Likes" value="820" min="0" step="any" />
        <x-calc.field name="comments" label="Comments" value="64" min="0" step="any" />
        <x-calc.field name="shares" label="Shares" value="31" min="0" step="any" />
        <x-calc.field name="saves" label="Saves" value="45" min="0" step="any" />
        <x-calc.field name="followers" label="Followers" value="25000" min="1" step="any" />
        <x-calc.field name="reach" label="Reach (optional)" value="12000" min="0" step="any" />
        <x-calc.field name="impressions" label="Impressions (optional)" value="18000" min="0" step="any" />
    </div>

    <x-calc.result label="Engagement rate (by followers)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['likes' => 820, 'comments' => 64, 'shares' => 31, 'saves' => 45, 'followers' => 25000, 'reach' => 12000, 'impressions' => 18000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'byReach' => ['label' => 'By reach'],
            'byImpressions' => ['label' => 'By impressions'],
            'total' => ['label' => 'Total engagements'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
