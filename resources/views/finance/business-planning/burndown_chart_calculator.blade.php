<x-calc.page
    title="Burndown Chart Calculator - SolveKit"
    description="Free burndown chart calculator: remaining work against the ideal line, velocity and the projected finish day of a sprint."
    lede="Track a sprint with a burndown chart."
    about="The ideal line falls evenly from the total to zero over the sprint. Velocity = work done ÷ days elapsed; projected finish = days elapsed + remaining ÷ velocity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'burndown', 'fields' => ['total', 'days', 'done']]"
    :how-to="[
        ['name' => 'Enter scope and sprint length', 'text' => ''],
        ['name' => 'Enter daily progress', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'After 6 days with 44 of 80 points done, will the 10-day sprint finish?', 'answer' => 'Behind schedule: at 7.333 points a day the work finishes on day 11 of 10.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="total" label="Total story points" value="80" min="1" step="any" />
        <x-calc.field name="days" label="Sprint days" value="10" min="1" step="1" />
    </div>

    <x-calc.textarea name="done" label="Points completed each day so far" value="6, 9, 7, 4, 10, 8" rows="2" />

    <x-calc.result label="Points left" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['total' => 80, 'days' => 10, 'done' => '6, 9, 7, 4, 10, 8'],
        'Behind' => ['total' => 80, 'days' => 10, 'done' => '4, 5, 3, 6, 5'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Burndown" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'ideal' => ['label' => 'Ideal remaining'],
            'velocity' => ['label' => 'Velocity'],
            'needed' => ['label' => 'Needed per day'],
            'status' => ['label' => 'Status'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ideal = total × (1 − day ÷ days)</li>
            <li>finish = elapsed + remaining ÷ velocity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
