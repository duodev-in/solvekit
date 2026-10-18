<x-calc.page
    title="Global Plastic Policy Calculator - SolveKit"
    description="Free global plastic policy calculator: plastic use, waste, mismanaged waste and leakage to the environment in 2060 under the OECD baseline, Regional Action and Global Ambition policy scenarios."
    lede="See what different plastic policies would do to plastic waste and pollution by 2060."
    about="The OECD Global Plastics Outlook (2022) modelled plastics to 2060. Under current policies (Baseline), waste almost triples from 353 Mt in 2019 to 1,014 Mt and leakage to the environment doubles to 44 Mt a year. Regional Action (taxes, recycled-content targets, better waste management, stronger in OECD countries) halves leakage; Global Ambition (the same policies everywhere) cuts it to 6 Mt. Figures are global, in million tonnes a year."
    :calc="['engine' => 'eco-living', 'tool' => 'plastic_policy', 'fields' => ['scenario'], 'data' => ['plastic_policy' => config('ecology_data.plastic_policy')]]"
    :how-to="[
        ['name' => 'Choose a scenario', 'text' => 'Or 2019 to see the starting point.'],
    ]"
    :faqs="[
        ['question' => 'How much plastic waste will there be in 2060?', 'answer' => '1,014 Mt a year under current policies, 679 Mt with Global Ambition (OECD).'],
        ['question' => 'Can policy stop plastic pollution?', 'answer' => 'The OECD found Global Ambition nearly eliminates leakage by 2060, but plastic already in rivers and oceans keeps building up.'],
        ['question' => 'What is mismanaged waste?', 'answer' => 'Waste not recycled, burned or landfilled properly, which can leak into nature.'],
    ]"
>
    <x-calc.select name="scenario" label="Scenario" :options="collect(config('ecology_data.plastic_policy'))->map(fn ($s) => $s['name'])->all()" selected="global" />

    <x-calc.result label="Plastic leakage" />

    <x-calc.options :examples="[
        'Global Ambition' => ['scenario' => 'global'],
        'Regional Action' => ['scenario' => 'regional'],
        'Baseline (no new policy)' => ['scenario' => 'baseline'],
        '2019' => ['scenario' => 'y2019'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'use' => ['label' => 'Plastic used'],
            'waste' => ['label' => 'Plastic waste'],
            'mismanaged' => ['label' => 'Mismanaged waste'],
            'recycled' => ['label' => 'Recycled content'],
        ]" />
        <x-calc.quick-ref heading="All scenarios" name="scenarios" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>OECD (2022) Global Plastics Outlook: Policy Scenarios to 2060</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
