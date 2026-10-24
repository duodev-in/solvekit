<x-calc.page
    title="CGPA to Percentage Calculator - SolveKit"
    description="Free CGPA to percentage calculator: CBSE, VTU, Anna University, Mumbai University and HEC Pakistan formulas."
    lede="Convert CGPA to a percentage."
    about="Boards and universities publish their own CGPA-to-percentage formulas; CBSE multiplies by 9.5."
    :calc="['engine' => 'ot-edu', 'tool' => 'cgpa_percent', 'fields' => ['cgpa', 'board', 'mult'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['hec'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What percentage is CGPA 8.4 (CBSE)?', 'answer' => '79.8%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cgpa" label="CGPA (or CGPI)" value="8.4" min="0" step="any" />
        <x-calc.select name="board" label="Board or university" :options="['cbse' => 'CBSE (× 9.5)', 'vtu15' => 'VTU, 2015–2018 schemes ((CGPA − 0.75) × 10)', 'vtu22' => 'VTU, 2022 scheme onward (× 10)', 'anna' => 'Anna University, R2021 (× 10)', 'mumbai' => 'University of Mumbai, CBCS (7.25 × CGPI + 11)', 'hec' => 'HEC Pakistan (4.0 scale: band minimum)', 'custom' => 'My own multiplier']" selected="cbse" />
        <div data-show-when="board:custom">
            <x-calc.field name="mult" label="Multiplier (custom)" value="9.5" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cgpa' => 8.4, 'board' => 'cbse', 'mult' => 9.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'klass' => ['label' => 'Class / division (where defined)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
