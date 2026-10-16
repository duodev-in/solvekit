<x-calc.page
    title="Activity Coefficient Calculator - SolveKit"
    description="Free activity coefficient calculator: Debye-Hückel limiting law, extended Debye-Hückel with Kielland ion sizes, and the Davies equation."
    lede="Work out an ion's activity coefficient from its charge and the ionic strength."
    about="In real solutions ions behave as if their concentration were lower: activity = γ × concentration. The Debye–Hückel limiting law holds only below about I = 0.005; the extended form with an ion-size term to about 0.1; the Davies equation to about 0.5 mol/kg. Constants are for water at 25 °C (A = 0.5091, B = 0.3283 Å⁻¹). Ion sizes are Kielland's (1937) values."
    :calc="['engine' => 'chem-mix', 'tool' => 'activity', 'fields' => ['model', 'charge', 'ionic_strength', 'ion', 'size', 'concentration'], 'data' => ['ion_sizes' => config('chemistry_data.ion_sizes')]]"
    :how-to="[
        ['name' => 'Pick a model', 'text' => 'Extended Debye–Hückel suits most lab solutions.'],
        ['name' => 'Enter the charge and I', 'text' => 'Use the Ionic Strength Calculator for I.'],
        ['name' => 'Pick the ion size', 'text' => 'Kielland\'s groups, or your own.'],
    ]"
    :faqs="[
        ['question' => 'What is an activity coefficient?', 'answer' => 'The factor that turns concentration into effective concentration (activity).'],
        ['question' => 'Why are multiply charged ions affected more?', 'answer' => 'The effect grows with the charge squared.'],
        ['question' => 'Which model should I use?', 'answer' => 'Davies for a quick estimate up to I = 0.5; extended Debye–Hückel when you know the ion size.'],
    ]"
>
    <x-calc.segmented name="model" legend="Model" :options="['limiting' => 'Limiting law', 'extended' => 'Extended', 'davies' => 'Davies']" selected="extended" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="charge" label="Ion charge" value="2" step="1" />
        <x-calc.field name="ionic_strength" label="Ionic strength I" value="0.01" min="0" suffix="mol/kg" />
    </div>

    <div data-show-when="model:extended">
        <x-calc.select name="ion" label="Ion size (Kielland)" :options="collect(config('chemistry_data.ion_sizes'))->map(fn ($i) => $i['name'].' · '.$i['size_pm'].' pm')->put('custom', 'Custom size')->all()" selected="ca" />
    </div>

    <div data-show-when="ion:custom" hidden>
        <x-calc.field name="size" label="Ion size" value="450" min="0" suffix="pm" />
    </div>

    <x-calc.field name="concentration" label="Concentration (optional)" value="0.01" min="0" suffix="mol/L" placeholder="Optional" />

    <x-calc.result label="Activity coefficient" />

    <x-calc.options :examples="[
        'Ca²⁺ at I = 0.01' => ['model' => 'extended', 'charge' => 2, 'ionic_strength' => 0.01, 'ion' => 'ca'],
        'K⁺ at I = 0.1' => ['model' => 'extended', 'charge' => 1, 'ionic_strength' => 0.1, 'ion' => 'k'],
        'Davies, z = 3, I = 0.1' => ['model' => 'davies', 'charge' => 3, 'ionic_strength' => 0.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'log' => ['label' => 'log γ'],
            'activity' => ['label' => 'Activity'],
            'range' => ['label' => 'Valid up to'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>limiting: log γ = −A z² √I</li>
            <li>extended: log γ = −A z² √I ÷ (1 + B a √I)</li>
            <li>Davies: log γ = −A z² (√I ÷ (1 + √I) − 0.3 I)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
