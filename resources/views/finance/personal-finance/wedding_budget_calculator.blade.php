<x-calc.page
    title="Wedding Budget Calculator - SolveKit"
    description="Free wedding budget calculator: split your total budget across venue and catering, photography, attire, flowers, music and more, with cost per guest."
    lede="Plan your wedding budget."
    about="A common starting split puts about 45% into venue and catering, then photography and video (~12%), attire, flowers and music (~8% each) and a 5% contingency. Adjust to your priorities; guest count drives most costs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'wedding', 'fields' => ['budget', 'guests'], 'data' => ['wedding' => config('finance_data.wedding')]]"
    :how-to="[
        ['name' => 'Enter your budget', 'text' => ''],
        ['name' => 'Enter guests', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How does a $30,000 budget split for 100 guests?', 'answer' => '$300 per guest; venue and catering $13,500.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="budget" label="Total budget" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="guests" label="Guests" value="100" min="1" step="1" />
    </div>

    <x-calc.result label="Budget per guest" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['budget' => 30000, 'guests' => 100],
        'Small wedding' => ['budget' => 12000, 'guests' => 40],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'venue' => ['label' => 'Venue and catering'],
            'contingency' => ['label' => 'Contingency'],
            'guests' => ['label' => 'Guests'],
            'source' => ['label' => 'Basis'],
        ]" />
        <x-calc.quick-ref heading="Budget split" name="split" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>category = budget × share</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
