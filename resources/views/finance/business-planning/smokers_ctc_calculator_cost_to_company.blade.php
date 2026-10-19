<x-calc.page
    title="Smoker's CTC Calculator – Cost to Company - SolveKit"
    description="Free smoker's cost to company calculator: yearly cost of smoke breaks in paid time plus extra health costs, with your own figures."
    lede="Estimate what smoking breaks cost an employer."
    about="Lost time = breaks a day × minutes × working days, valued at the hourly wage plus payroll burden. Studies have estimated extra costs per smoking employee of several thousand dollars a year (Ohio State University, 2013, about $5,800); enter your own figures. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'smoking', 'fields' => ['breaks', 'minutes', 'wage', 'burden', 'days', 'health', 'smokers']]"
    :how-to="[
        ['name' => 'Enter breaks and wage', 'text' => ''],
        ['name' => 'Add health costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do four 10-minute breaks a day cost at $28 an hour?', 'answer' => '$7,366.67 a year per smoker.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="breaks" label="Smoke breaks a day" value="4" min="0" step="any" />
        <x-calc.field name="minutes" label="Minutes each" value="10" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wage" label="Hourly wage" value="28" step="0.01" suffix="$" />
        <x-calc.field name="burden" label="Payroll burden" value="25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Working days a year" value="230" min="0" step="any" />
        <x-calc.field name="health" label="Extra health costs a year" value="2000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="smokers" label="Smokers on staff" value="12" min="0" step="1" />
    </div>

    <x-calc.result label="Yearly cost to the employer" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['breaks' => 4, 'minutes' => 10, 'wage' => 28, 'burden' => 25, 'days' => 230, 'health' => 2000, 'smokers' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'time' => ['label' => 'Paid time on breaks'],
            'health' => ['label' => 'Health costs'],
            'days' => ['label' => 'Days of work'],
            'staff' => ['label' => 'Across all smokers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = breaks × minutes × days ÷ 60 × wage × (1 + burden) + health</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
