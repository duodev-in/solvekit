<x-calc.page
    title="Plasma Volume Calculator - SolveKit"
    description="Free plasma volume calculator: plasma volume from blood volume (Nadler) and haematocrit."
    lede="Estimate plasma volume."
    about="Plasma volume = blood volume × (1 − haematocrit). With blood volume from the Nadler equation and a normal haematocrit of 40–45%, adults have about 2.5–3.5 L of plasma (roughly 40–50 mL/kg). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'plasma_volume', 'fields' => ['height', 'weight', 'sex', 'hct'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height, weight and sex', 'text' => ''],
        ['name' => 'Enter haematocrit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the plasma volume for a 170 cm, 70 kg man with Hct 42%?', 'answer' => '2.70 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.field name="hct" label="Haematocrit" value="42" min="0" max="100" step="any" suffix="%" />

    <x-calc.result label="Plasma volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 170, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'sex' => 'male', 'hct' => 42],
        'Woman' => ['height' => 160, 'height-unit' => 'cm', 'weight' => 60, 'weight-unit' => 'kg', 'sex' => 'female', 'hct' => 38],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bv' => ['label' => 'Blood volume'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = BV × (1 − Hct)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
