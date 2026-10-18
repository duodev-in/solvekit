<x-calc.page
    title="Bag Footprint Calculator - SolveKit"
    description="Free bag footprint calculator: how many times paper, bag-for-life, polypropylene and cotton bags must be reused to beat a plastic carrier bag, from the Environment Agency study."
    lede="Work out how many times a reusable bag must be used to beat a plastic carrier bag."
    about="The UK Environment Agency life cycle study of carrier bags compared the bags needed to carry a month of shopping. A paper bag must be used 3 times, a heavier LDPE bag-for-life 4, a non-woven polypropylene bag 11 and a cotton bag 131 times before its carbon footprint is lower than single-use plastic bags that are not reused; more if the plastic bags are reused as bin liners."
    :calc="['engine' => 'eco-footprint', 'tool' => 'bag', 'fields' => ['bag', 'uses', 'scenario'], 'data' => ['bags' => config('ecology_data.bags')]]"
    :how-to="[
        ['name' => 'Choose the bag', 'text' => 'And how many times you use it.'],
        ['name' => 'Choose how plastic bags would be used', 'text' => 'Reusing them raises the bar.'],
    ]"
    :faqs="[
        ['question' => 'How many times must a cotton bag be used?', 'answer' => '131 times to beat single-use plastic bags, 173 if 40% of plastic bags are reused as bin liners.'],
        ['question' => 'Is a paper bag better than plastic?', 'answer' => 'Only if it is used at least 3 times.'],
        ['question' => 'What about litter?', 'answer' => 'The study measured life cycle impacts, not litter or harm to wildlife, where plastic bags do worse.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bag" label="Bag" :options="collect(config('ecology_data.bags'))->except('hdpe')->map(fn ($b) => $b['name'])->all()" selected="cotton" />
        <x-calc.field name="uses" label="Times you use it" value="52" min="1" step="1" />
    </div>

    <x-calc.select name="scenario" label="Plastic bags it replaces" :options="['0' => 'Thrown away after one use', '1' => '40% reused as bin liners (UK average)', '2' => 'All reused as bin liners', '3' => 'Reused 3 times for shopping']" selected="0" />

    <x-calc.result label="Uses to beat a plastic carrier bag" />

    <x-calc.options :examples="[
        'Cotton bag, used weekly for a year' => ['bag' => 'cotton', 'uses' => 52, 'scenario' => '0'],
        'Bag for life, 10 uses' => ['bag' => 'ldpe', 'uses' => 10, 'scenario' => '1'],
        'Paper bag, used twice' => ['bag' => 'paper', 'uses' => 2, 'scenario' => '0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'month' => ['label' => 'Per month of shopping'],
            'bags' => ['label' => 'Bags needed'],
            'material' => ['label' => 'Material a year'],
            'table' => ['label' => 'All bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>footprint per use = bag footprint ÷ uses</li>
            <li>break-even uses: Environment Agency (2011)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
