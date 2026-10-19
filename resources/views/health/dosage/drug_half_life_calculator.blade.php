<x-calc.page
    title="Drug Half-Life Calculator - SolveKit"
    description="Free drug half-life calculator: how much of a medicine is left after a given time, how long it takes to clear, and build-up with repeated doses."
    lede="See how a medicine clears from the body."
    about="Most medicines are cleared by first-order kinetics: the amount left = starting amount × 0.5^(time ÷ half-life). After 5 half-lives about 97% is gone, and with regular dosing steady state is reached after about 5 half-lives. The half-life is on the medicine's leaflet; this tool does not tell you when or how much to take. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'half_life', 'fields' => ['mode', 'amount', 'unit', 'half', 'time', 'interval', 'doses']]"
    :how-to="[
        ['name' => 'Enter the amount and half-life', 'text' => ''],
        ['name' => 'Enter the time', 'text' => 'And the schedule for repeated doses.'],
    ]"
    :faqs="[
        ['question' => 'How much of 500 mg with a 6-hour half-life is left after 12 hours?', 'answer' => '125 mg (25.0% of the total given; about 30.0 hours (5 half-lives) to clear 97%).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Doses" :options="['single' => 'Single dose', 'repeat' => 'Repeated doses']" selected="single" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Dose amount" value="500" min="0" step="any" />
        <x-calc.field name="unit" label="Unit" value="mg" type="text" />
        <x-calc.field name="half" label="Half-life" value="6" min="0" step="any" suffix="h" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="time" label="Hours since the (first) dose" value="12" min="0" step="any" suffix="h" />
    </div>

    <div data-show-when="mode:repeat" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="interval" label="Hours between doses" value="8" min="0" step="any" suffix="h" />
            <x-calc.field name="doses" label="Number of doses" value="3" min="0" step="1" />
        </div>
    </div>

    <x-calc.result label="Amount left" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'single', 'amount' => 500, 'unit' => 'mg', 'half' => 6, 'time' => 12, 'interval' => 8, 'doses' => 3],
        'Repeated' => ['mode' => 'repeat', 'amount' => 500, 'unit' => 'mg', 'half' => 6, 'time' => 20, 'interval' => 8, 'doses' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Amount over time" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'five' => ['label' => 'Under 5%'],
            'steady' => ['label' => 'Repeated dosing'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="By half-life" name="halves" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = A₀ × 0.5^(t ÷ t½)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
