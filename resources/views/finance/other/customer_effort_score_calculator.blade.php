<x-calc.page
    title="Customer Effort Score Calculator - SolveKit"
    description="Free customer effort score calculator: average CES and the share of customers who found it easy, from survey response counts on a 1–7 or 1–5 scale."
    lede="Work out your Customer Effort Score."
    about="CES asks how easy it was to get an issue handled. The score is the average response; many teams also report the share answering 5–7 on a 7-point scale (easy) minus the share answering 1–3 (difficult). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'ces', 'fields' => ['scale', 'counts']]"
    :how-to="[
        ['name' => 'Choose the scale', 'text' => ''],
        ['name' => 'Enter response counts', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the CES of 4, 6, 10, 25, 60, 90, 55 responses?', 'answer' => '5.484; 82% found it easy (5–7).'],
    ]"
>
    <x-calc.select name="scale" label="Scale" :options="['7' => '1 to 7', '5' => '1 to 5']" selected="7" />

    <x-calc.textarea name="counts" label="Responses for each score, lowest first (e.g. how many answered 1, 2, … 7)" value="4, 6, 10, 25, 60, 90, 55" rows="2" />

    <x-calc.result label="Customer Effort Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['scale' => '7', 'counts' => '4, 6, 10, 25, 60, 90, 55'],
        'Five-point' => ['scale' => '5', 'counts' => '5, 10, 30, 80, 75'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'easy' => ['label' => 'Found it easy'],
            'hard' => ['label' => 'Found it hard'],
            'net' => ['label' => 'Net easy'],
            'responses' => ['label' => 'Responses'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CES = Σ score × count ÷ responses</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
