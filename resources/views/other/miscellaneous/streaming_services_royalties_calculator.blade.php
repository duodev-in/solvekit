<x-calc.page
    title="Streaming Services‘ Royalties Calculator - SolveKit"
    description="Free streaming royalties calculator: estimated payout from Spotify, Apple Music, YouTube and Amazon streams."
    lede="Estimate streaming royalties."
    about="Streaming services pay a share of revenue; average payouts per stream differ by service."
    :calc="['engine' => 'ot-misc', 'tool' => 'royalties', 'fields' => ['spotify', 'apple', 'youtube', 'amazon', 'share'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['royalties'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What do the example streams earn?', 'answer' => 'About $639.20.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spotify" label="Spotify streams" value="100000" min="0" step="any" />
        <x-calc.field name="apple" label="Apple Music streams" value="20000" min="0" step="any" />
        <x-calc.field name="youtube" label="YouTube streams" value="50000" min="0" step="any" />
        <x-calc.field name="amazon" label="Amazon Music streams" value="10000" min="0" step="any" />
        <x-calc.field name="share" label="Your share after label or distributor (%)" value="85" min="0" step="any" />
    </div>

    <x-calc.result label="Estimated payout" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['spotify' => 100000, 'apple' => 20000, 'youtube' => 50000, 'amazon' => 10000, 'share' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gross' => ['label' => 'Before your label or distributor'],
            'perStream' => ['label' => 'Average per stream'],
            'breakdown' => ['label' => 'By platform'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
