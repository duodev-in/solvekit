<x-calc.page
    title="Commercial Lease Calculator - SolveKit"
    description="Free commercial lease calculator: monthly and yearly rent for gross, modified gross and triple-net (NNN) leases, with yearly escalation."
    lede="Work out commercial rent per month and over the lease."
    about="Commercial rent is quoted per square foot per year. In a gross lease the landlord pays operating costs; in a modified gross lease the tenant pays some (here CAM); in a triple-net lease the tenant pays CAM, property tax and insurance on top of base rent. Escalations raise rent each year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'commercial_lease', 'fields' => ['area', 'base', 'type', 'cam', 'taxes', 'insurance', 'term', 'escalation']]"
    :how-to="[
        ['name' => 'Enter area and base rent', 'text' => ''],
        ['name' => 'Choose the lease type and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the monthly rent on 2,500 ft² at $28 NNN with $8 of costs?', 'answer' => '$7,500.00.'],
        ['question' => 'And as a gross lease?', 'answer' => '$7,083.33.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Area" value="2500" min="1" step="1" suffix="ft²" />
        <x-calc.field name="base" label="Base rent per ft² a year" value="28" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Lease type" :options="['nnn' => 'Triple net (NNN)', 'modified' => 'Modified gross', 'gross' => 'Gross']" selected="nnn" />
        <x-calc.field name="cam" label="CAM per ft² a year" value="4" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="taxes" label="Property tax per ft² a year" value="3" step="0.01" suffix="$" />
        <x-calc.field name="insurance" label="Insurance per ft² a year" value="1" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="term" label="Lease term" value="5" min="0" step="1" suffix="years" />
        <x-calc.field name="escalation" label="Yearly escalation" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly rent" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['area' => 2500, 'base' => 28, 'type' => 'nnn', 'cam' => 4, 'taxes' => 3, 'insurance' => 1, 'term' => 5, 'escalation' => 3],
        'Gross' => ['area' => 2500, 'base' => 34, 'type' => 'gross', 'cam' => 4, 'taxes' => 3, 'insurance' => 1, 'term' => 5, 'escalation' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yearly' => ['label' => 'First-year rent'],
            'extras' => ['label' => 'Operating costs a year'],
            'total' => ['label' => 'Total over the term'],
            'monthlyFt' => ['label' => 'Per ft² a month'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>monthly = (base + costs) × area ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
