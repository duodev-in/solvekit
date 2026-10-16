<x-calc.page
    title="Log Reduction Calculator - SolveKit"
    description="Free log reduction calculator: convert between log reduction and percent kill, or work it out from counts before and after."
    lede="Convert between log reduction and percent reduction, or find it from counts."
    about="Log reduction is the number of tenfold drops in live microbes: 1 log is 90%, 3 log is 99.9% and 6 log is 99.9999%. It is the usual way to express disinfection and sterilization performance."
    :calc="['engine' => 'lab', 'tool' => 'log_reduction', 'fields' => ['mode', 'start', 'end', 'percent', 'log']]"
    :how-to="[
        ['name' => 'Choose the input', 'text' => 'Counts, percent or a log value.'],
        ['name' => 'Enter the values', 'text' => 'Counts in the same unit, e.g. CFU/mL.'],
    ]"
    :faqs="[
        ['question' => 'What is a 3-log reduction?', 'answer' => 'A 99.9% reduction: 1 in 1,000 survive.'],
        ['question' => 'What is 99.99% in logs?', 'answer' => '4 log.'],
        ['question' => 'Why use logs?', 'answer' => 'Kill rates span many orders of magnitude, so logs are easier to compare.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['counts' => 'Counts', 'percent' => 'Percent', 'log' => 'Log value']" selected="counts" />

    <div data-show-when="mode:counts">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="start" label="Count before" value="1000000" min="0" />
            <x-calc.field name="end" label="Count after" value="100" min="0" />
        </div>
    </div>

    <div data-show-when="mode:percent" hidden>
        <x-calc.field name="percent" label="Percent reduction" value="99.9" min="0" max="100" suffix="%" />
    </div>

    <div data-show-when="mode:log" hidden>
        <x-calc.field name="log" label="Log reduction" value="3" min="0" />
    </div>

    <x-calc.result label="Log reduction" />

    <x-calc.options :examples="[
        '10⁶ to 100 CFU' => ['mode' => 'counts', 'start' => 1000000, 'end' => 100],
        '99.99%' => ['mode' => 'percent', 'percent' => 99.99],
        '6 log' => ['mode' => 'log', 'log' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'percent' => ['label' => 'Percent reduction'],
            'surviving' => ['label' => 'Surviving'],
        ]" />
        <x-calc.quick-ref heading="Log to percent" name="quick-ref" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>log = log₁₀(N₀ ÷ N)</li>
            <li>% = (1 − 10⁻ˡᵒᵍ) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
