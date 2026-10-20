<x-calc.page
    title="Risk Calculator - SolveKit"
    description="Free risk calculator: absolute risk, absolute and relative risk reduction and number needed to treat from two groups."
    lede="Compare risks."
    about="A treatment’s benefit can be stated as an absolute risk reduction (percentage points), a relative risk reduction (percent) or the number needed to treat."
    :calc="['engine' => 'st-prob', 'tool' => 'risk', 'fields' => ['e1', 'n1', 'e0', 'n0'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the absolute risk reduction in the example?', 'answer' => '6% (NNT 17 (treat to prevent one event)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="e1" label="Events in the treated group" value="12" min="0" step="any" />
        <x-calc.field name="n1" label="People in the treated group" value="200" min="1" step="any" />
        <x-calc.field name="e0" label="Events in the control group" value="24" min="0" step="any" />
        <x-calc.field name="n0" label="People in the control group" value="200" min="1" step="any" />
    </div>

    <x-calc.result label="Absolute risk reduction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['e1' => 12, 'n1' => 200, 'e0' => 24, 'n0' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r1' => ['label' => 'Risk with treatment'],
            'r0' => ['label' => 'Risk without (control)'],
            'rrr' => ['label' => 'Relative risk reduction'],
            'rr' => ['label' => 'Relative risk'],
            'nnt' => ['label' => 'Number needed to treat'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
