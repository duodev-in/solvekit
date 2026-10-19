<x-calc.page
    title="Remote vs. On-Location Workers Calculator - SolveKit"
    description="Free remote vs office worker cost calculator: yearly cost per worker of office space, utilities and equipment against remote stipends, equipment and coworking."
    lede="Compare remote and on-site costs per worker."
    about="On-site cost = rent per square foot × space per worker + utilities and services + equipment spread over 3 years. Remote cost = home office stipend × 12 + equipment spread over 3 years + coworking. Typical office space is about 150–200 ft² per worker. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'workplace_costs', 'fields' => ['rent', 'space', 'utilities', 'office_equipment', 'stipend', 'remote_equipment', 'coworking', 'people']]"
    :how-to="[
        ['name' => 'Enter office costs', 'text' => ''],
        ['name' => 'Enter remote costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a remote worker save versus 175 ft² at $38?', 'answer' => '$8,583 a year per worker.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rent" label="Office rent per ft² a year" value="38" step="0.01" suffix="$" />
        <x-calc.field name="space" label="Space per worker" value="175" min="0" step="any" suffix="ft²" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="utilities" label="Utilities and services per worker a year" value="2500" step="0.01" suffix="$" />
        <x-calc.field name="office_equipment" label="Office equipment per worker" value="3000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stipend" label="Remote stipend a month" value="75" step="0.01" suffix="$" />
        <x-calc.field name="remote_equipment" label="Remote equipment per worker" value="2000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coworking" label="Coworking a month" value="0" step="0.01" suffix="$" />
        <x-calc.field name="people" label="Workers" value="25" min="0" step="1" />
    </div>

    <x-calc.result label="Remote saves per worker a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rent' => 38, 'space' => 175, 'utilities' => 2500, 'office_equipment' => 3000, 'stipend' => 75, 'remote_equipment' => 2000, 'coworking' => 0, 'people' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'office' => ['label' => 'On-site per worker'],
            'remote' => ['label' => 'Remote per worker'],
            'team' => ['label' => 'For the team'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>office = rent × space + utilities + equipment ÷ 3</li>
            <li>remote = stipend × 12 + equipment ÷ 3 + coworking × 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
