<x-calc.page
    title="AI Water Footprint Calculator - SolveKit"
    description="Free AI water footprint calculator: water and energy used by your AI chatbot prompts per day and per year, from published measurements."
    lede="Work out the water and energy behind your AI prompts."
    about="Data centers use water mainly for cooling, and power stations use more to make the electricity. Google measured a median Gemini text prompt in May 2025 at 0.24 Wh of energy and 0.26 mL of water consumed in its data centers. Other models, prompt lengths and data centers differ a lot, so replace these with figures for the service you use; add the water used to generate electricity if you know it for your grid."
    :calc="['engine' => 'eco-footprint', 'tool' => 'ai_water', 'fields' => ['prompts', 'wh', 'ml', 'lkwh', 'grid', 'grid_custom'], 'data' => collect(config('ecology_data'))->only(['grid', 'dated'])->all()]"
    :how-to="[
        ['name' => 'Enter how many prompts you send', 'text' => 'Per day.'],
        ['name' => 'Check the per-prompt figures', 'text' => 'Use your provider\'s numbers if published.'],
    ]"
    :faqs="[
        ['question' => 'How much water does one AI prompt use?', 'answer' => 'Google reported 0.26 mL for a median Gemini text prompt (May 2025), about five drops.'],
        ['question' => 'Why do estimates differ so much?', 'answer' => 'Model size, prompt length, data-center cooling and whether power-station water is counted all change the result.'],
        ['question' => 'Does this include training the model?', 'answer' => 'No, only answering prompts.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prompts" label="Prompts per day" value="30" min="0" step="1" />
        <x-calc.field name="wh" label="Energy per prompt" value="0.24" min="0" step="0.01" suffix="Wh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ml" label="Data-center water per prompt" value="0.26" min="0" step="0.01" suffix="mL" />
        <x-calc.field name="lkwh" label="Water to make electricity (optional)" value="" min="0" step="0.1" suffix="L/kWh" placeholder="Not included" />
    </div>

    <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="OWID_WRL" />

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <x-calc.result label="Water for your AI prompts" />

    <x-calc.options :examples="[
        '30 prompts a day' => ['prompts' => 30, 'wh' => 0.24, 'ml' => 0.26, 'lkwh' => '', 'grid' => 'OWID_WRL'],
        'Heavy use, 200 a day' => ['prompts' => 200, 'wh' => 0.24, 'ml' => 0.26, 'lkwh' => 1.8, 'grid' => 'USA'],
        'Larger model, 3 Wh' => ['prompts' => 50, 'wh' => 3, 'ml' => 3.3, 'lkwh' => '', 'grid' => 'IND'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'day' => ['label' => 'Per day'],
            'energy' => ['label' => 'Energy'],
            'co2' => ['label' => 'CO₂'],
            'basis' => ['label' => 'Defaults'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water = prompts × 365 × (mL per prompt + Wh ÷ 1000 × L/kWh × 1000)</li>
            <li>CO₂ = kWh × grid intensity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
