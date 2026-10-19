<x-calc.page
    title="Parking Ratio Calculator - SolveKit"
    description="Free Parking Ratio Calculator: parking ratio = spaces ÷ (area ÷ 1,000 ft²). Parking ratio is the number of spaces per 1,000 square feet of rentable area."
    lede="Work out the parking ratio from parking spaces and building area."
    about="Parking ratio is the number of spaces per 1,000 square feet of rentable area. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'parking_ratio', 'fields' => ['spaces', 'area']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Parking spaces, Building area.'],
        ['name' => 'Read the result', 'text' => 'The parking ratio appears as you type, with square feet per space below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the parking ratio?', 'answer' => 'Parking ratio = spaces ÷ (area ÷ 1,000 ft²).'],
        ['question' => 'What is the parking ratio for parking spaces 120, building area 30,000?', 'answer' => '4. Square feet per space: 250.'],
        ['question' => 'And for parking spaces 40, building area 12,500?', 'answer' => '3.2. Square feet per space: 312.5.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Suburban offices often need 3–5 spaces per 1,000 ft²; zoning sets minimums or maximums.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spaces" label="Parking spaces" value="120" min="0" step="1" />
        <x-calc.field name="area" label="Building area" value="30000" step="any" />
    </div>

    <x-calc.result label="Parking ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['spaces' => 120, 'area' => 30000],
        'Example B' => ['spaces' => 40, 'area' => 12500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Square feet per space'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>parking ratio = spaces ÷ (area ÷ 1,000 ft²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
