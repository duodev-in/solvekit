<x-calc.page
    title="CO₂ Breathing Emission Calculator - SolveKit"
    description="Free CO₂ breathing calculator: how much carbon dioxide you breathe out each day from your body weight and activity, using oxygen use per MET."
    lede="Work out how much CO₂ you breathe out in a day."
    about="At rest you use about 3.5 mL of oxygen per kg per minute (1 MET); activity multiplies it. CO₂ breathed out = oxygen used × the respiratory exchange ratio (about 0.85 on a mixed diet), at 1.977 g per liter. MET values here are representative for each intensity (2024 Compendium of Physical Activities). This carbon came from food, which plants recently took from the air, so breathing is not a net emission."
    :calc="['engine' => 'eco-science', 'tool' => 'breathing', 'fields' => ['mass', 'sleep', 'sit', 'light', 'moderate', 'vigorous', 'rer'], 'unitFields' => ['mass' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter your weight', 'text' => 'And your hours at each activity level.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ does a person breathe out?', 'answer' => 'About 1 kg a day for a 70 kg adult with a mostly seated day and some activity.'],
        ['question' => 'Does breathing cause climate change?', 'answer' => 'No: the carbon comes from food grown from CO₂ already in the air.'],
        ['question' => 'What is a MET?', 'answer' => 'The energy used sitting at rest; walking briskly is about 3.5 MET.'],
    ]"
>
    <x-calc.field name="mass" label="Body weight" value="70" min="0" placeholder="Body weight">
        <label for="calc-mass-unit" class="sr-only">Body weight unit</label>
        <select id="calc-mass-unit" name="mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sleep" label="Hours sleeping" value="8" min="0" max="24" step="0.5" />
        <x-calc.field name="sit" label="Hours sitting" value="9" min="0" max="24" step="0.5" />
        <x-calc.field name="light" label="Hours of light activity" value="5" min="0" max="24" step="0.5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="moderate" label="Hours of moderate activity" value="1.5" min="0" max="24" step="0.5" />
        <x-calc.field name="vigorous" label="Hours of vigorous activity" value="0.5" min="0" max="24" step="0.5" />
        <x-calc.field name="rer" label="Respiratory exchange ratio" value="0.85" min="0.7" max="1.1" step="0.01" />
    </div>

    <x-calc.result label="CO₂ you breathe out" />

    <x-calc.options :examples="[
        'Office worker, 70 kg' => ['mass' => 70, 'mass-unit' => 'kg', 'sleep' => 8, 'sit' => 9, 'light' => 5, 'moderate' => 1.5, 'vigorous' => 0.5, 'rer' => 0.85],
        'Active, 180 lb' => ['mass' => 180, 'mass-unit' => 'lb', 'sleep' => 7, 'sit' => 6, 'light' => 6, 'moderate' => 3, 'vigorous' => 2, 'rer' => 0.85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'year' => ['label' => 'Per year'],
            'hour' => ['label' => 'Per hour'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="By activity" name="blocks" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VO₂ = MET × 3.5 mL/kg/min</li>
            <li>CO₂ = VO₂ × RER × 1.977 g/L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
