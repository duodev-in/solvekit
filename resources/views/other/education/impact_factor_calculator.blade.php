<x-calc.page
    title="Impact Factor Calculator - SolveKit"
    description="Free impact factor calculator: a journal’s two-year and five-year impact factor from citations and articles."
    lede="Find a journal impact factor."
    about="The impact factor is the average number of citations a journal’s recent articles receive in a year."
    :calc="['engine' => 'ot-edu', 'tool' => 'impact_factor', 'fields' => ['cites', 'items', 'cites5', 'items5'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the impact factor in the example?', 'answer' => '3.707.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cites" label="Citations this year to items published in the previous two years" value="1520" min="0" step="any" />
        <x-calc.field name="items" label="Citable items published in those two years" value="410" min="1" step="any" />
        <x-calc.field name="cites5" label="Citations to the previous five years (optional)" value="3200" min="0" step="any" />
        <x-calc.field name="items5" label="Citable items in those five years (optional)" value="1050" min="0" step="any" />
    </div>

    <x-calc.result label="Impact factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cites' => 1520, 'items' => 410, 'cites5' => 3200, 'items5' => 1050],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'five' => ['label' => 'Five-year impact factor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
