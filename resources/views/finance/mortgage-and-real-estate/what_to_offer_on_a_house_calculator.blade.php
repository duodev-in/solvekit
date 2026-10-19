<x-calc.page
    title="What To Offer On A House Calculator - SolveKit"
    description="Free house offer calculator: an opening offer from comparable sales per square foot, the local sale-to-list ratio and how long the home has been listed."
    lede="Decide what to offer on a house."
    about="Market value ≈ comparable price per square foot × size. Start from the lower of the list price and that value, apply the local sale-to-list ratio, and leave more room when the home has been listed longer than usual (a rule of thumb: about 1% per extra 30 days, up to 5%). Your agent's comparables matter most. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'offer', 'fields' => ['list', 'comps', 'area', 'ratio', 'dom', 'typical_dom']]"
    :how-to="[
        ['name' => 'Enter the list price and comparables', 'text' => ''],
        ['name' => 'Enter market conditions', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What to offer on a $475,000 listing when comps are $260/ft² for 1,800 ft²?', 'answer' => '$455,582.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="list" label="List price" value="475000" step="0.01" suffix="$" />
        <x-calc.field name="comps" label="Comparable sales price per ft²" value="260" step="0.01" suffix="$" />
        <x-calc.field name="area" label="Home size" value="1800" min="1" step="1" suffix="ft²" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ratio" label="Local sale-to-list ratio" value="98" step="any" suffix="%" />
        <x-calc.field name="dom" label="Days on market" value="45" min="0" step="1" />
        <x-calc.field name="typical_dom" label="Typical days on market here" value="25" min="0" step="1" />
    </div>

    <x-calc.result label="Suggested opening offer" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => 475000, 'comps' => 260, 'area' => 1800, 'ratio' => 98, 'dom' => 45, 'typical_dom' => 25],
        'Hot market' => ['list' => 475000, 'comps' => 275, 'area' => 1800, 'ratio' => 102, 'dom' => 5, 'typical_dom' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'value' => ['label' => 'Value from comparables'],
            'gap' => ['label' => 'List price above value'],
            'room' => ['label' => 'Extra room from days on market'],
            'range' => ['label' => 'Offer range'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = comps × area</li>
            <li>offer = min(list, value) × ratio × (1 − room)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
