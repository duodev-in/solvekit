<x-calc.page
    title="Cardiac Index Calculator - SolveKit"
    description="Free cardiac index calculator: cardiac output divided by body surface area (Mosteller), with the normal 2.5–4.0 L/min/m² range."
    lede="Calculate the cardiac index."
    about="Cardiac index = cardiac output ÷ body surface area, so it compares heart performance across body sizes. Normal is about 2.5–4.0 L/min/m²; under 2.2 with low blood pressure suggests cardiogenic shock. BSA uses the Mosteller formula, √(height cm × weight kg ÷ 3600). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'cardiac_index', 'fields' => ['mode', 'co', 'hr', 'sv', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter the cardiac output', 'text' => 'Or heart rate and stroke volume.'],
        ['name' => 'Enter height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the cardiac index for 5 L/min at 175 cm and 80 kg?', 'answer' => '2.54 L/min/m².'],
    ]"
>
    <x-calc.segmented name="mode" legend="Cardiac output from" :options="['co' => 'Measured output', 'hrsv' => 'Heart rate × stroke volume']" selected="co" />

    <div data-show-when="mode:co">
        <x-calc.field name="co" label="Cardiac output" value="5" min="0" step="any" suffix="L/min" />
    </div>

    <div data-show-when="mode:hrsv" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hr" label="Heart rate" value="75" min="0" max="300" step="1" suffix="bpm" />
            <x-calc.field name="sv" label="Stroke volume" value="70" min="0" step="any" suffix="mL" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
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
    </div>

    <x-calc.result label="Cardiac index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'co', 'co' => 5, 'hr' => 75, 'sv' => 70, 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
        'From HR and SV' => ['mode' => 'hrsv', 'co' => 5, 'hr' => 90, 'sv' => 45, 'height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bsa' => ['label' => 'Body surface area'],
            'co' => ['label' => 'Cardiac output'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CI = CO ÷ BSA</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
