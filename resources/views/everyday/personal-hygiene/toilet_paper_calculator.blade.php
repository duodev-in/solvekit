<x-calc.page
    title="Toilet Paper Calculator - SolveKit"
    description="Free toilet paper calculator: rolls of toilet paper a household uses a week, month and year, and how long a pack lasts."
    lede="Work out how much toilet paper you use and how long a pack lasts."
    about="Sheets a day = people × bathroom uses a day × sheets per use; rolls = sheets ÷ sheets per roll (printed on the pack, often 200–400 for a “double roll”). Habits vary a lot, so count your own sheets per use for a better answer."
    :calc="['engine' => 'ev-care', 'tool' => 'toilet_paper', 'fields' => ['people', 'uses', 'sheets', 'per_roll', 'pack']]"
    :how-to="[
        ['name' => 'Enter the household', 'text' => 'People, uses a day and sheets each time.'],
        ['name' => 'Enter the roll and pack', 'text' => 'From the packaging.'],
    ]"
    :faqs="[
        ['question' => 'How many rolls does a family of 4 use a week?', 'answer' => 'About 3.2 rolls of 264 sheets at these settings.'],
        ['question' => 'How long does a 12-pack last?', 'answer' => 'About 26 days for 4 people at these settings.'],
        ['question' => 'How many sheets are on a roll?', 'answer' => 'Check the pack: commonly 200–400.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="people" label="People" value="4" min="1" step="1" />
        <x-calc.field name="uses" label="Uses a day each" value="5" min="1" step="1" />
        <x-calc.field name="sheets" label="Sheets per use" value="6" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="per_roll" label="Sheets per roll" value="264" min="10" step="1" />
        <x-calc.field name="pack" label="Rolls per pack" value="12" min="1" step="1" />
    </div>

    <x-calc.result label="Toilet paper used" />

    <x-calc.options :examples="[
        'Family of 4' => ['people' => 4, 'uses' => 5, 'sheets' => 6, 'per_roll' => 264, 'pack' => 12],
        'Single person' => ['people' => 1, 'uses' => 5, 'sheets' => 8, 'per_roll' => 312, 'pack' => 6],
        'Shared house of 6' => ['people' => 6, 'uses' => 4, 'sheets' => 7, 'per_roll' => 200, 'pack' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'month' => ['label' => 'Per month'],
            'year' => ['label' => 'Per year'],
            'pack' => ['label' => 'A pack lasts'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rolls = people × uses × sheets ÷ sheets per roll</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
