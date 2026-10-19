<x-calc.page
    title="Sodium Correction Rate Calculator for Hypo- and Hypernatremia - SolveKit"
    description="Free sodium correction rate calculator: the expected change in serum sodium from one litre of an infusate (Adrogué–Madias), and the safe daily limits."
    lede="Estimate the change in sodium per litre of fluid."
    about="The Adrogué–Madias formula estimates how much one litre of a fluid changes serum sodium: ΔNa = (infusate Na + infusate K − serum Na) ÷ (TBW + 1). It often under-predicts the change, so sodium must be re-measured every few hours. In chronic hyponatraemia the rise should be kept to 8–10 mmol/L in 24 hours. This is an estimate for teaching, not an order. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'na_rate', 'fields' => ['na', 'infusate', 'weight', 'age', 'sex', 'group'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter sodium', 'text' => ''],
        ['name' => 'Choose the fluid', 'text' => ''],
        ['name' => 'Enter weight, age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much does 1 L of 3% saline raise Na 120 in a 70 kg man?', 'answer' => '+9.1 mmol/L (TBW 42.0 L; about 0.9 L would change sodium by 8 mmol/L).'],
    ]"
>
    <x-calc.field name="na" label="Serum sodium" value="120" min="0" step="any" suffix="mmol/L" />

    <x-calc.select name="infusate" label="Infusate" :options="['hypertonic' => '3% saline (Na 513)', 'normal' => '0.9% saline (Na 154)', 'ringer' => 'Lactated Ringer\'s (Na 130)', 'half' => '0.45% saline (Na 77)', 'quarter' => '0.2% saline in 5% dextrose (Na 34)', 'd5w' => '5% dextrose in water (Na 0)']" selected="hypertonic" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="60" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.select name="group" label="Patient" :options="['adult' => 'Adult', 'child' => 'Child']" selected="adult" />

    <x-calc.result label="Expected change per litre" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 120, 'infusate' => 'hypertonic', 'weight' => 70, 'weight-unit' => 'kg', 'age' => 60, 'sex' => 'male', 'group' => 'adult'],
        'Hypernatraemia' => ['na' => 158, 'infusate' => 'd5w', 'weight' => 70, 'weight-unit' => 'kg', 'age' => 75, 'sex' => 'female', 'group' => 'adult'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'limit' => ['label' => 'Safe limit'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔNa = (Na_inf + K_inf − Na) ÷ (TBW + 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
