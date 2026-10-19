<x-calc.page
    title="Ponderal Index Calculator - SolveKit"
    description="Free ponderal index calculator: the ponderal (Rohrer) index for adults and newborns, a height-cubed alternative to BMI."
    lede="Work out the ponderal index."
    about="Ponderal index = weight ÷ height³ (kg/m³). Because it uses height cubed it suits very tall and short people better than BMI; adults usually fall between 11 and 15. For newborns Rohrer's index (g ÷ cm³ × 100) of 2.0–3.0 is typical, and low values suggest growth restriction. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'ponderal', 'fields' => ['mode', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Choose adult or newborn', 'text' => ''],
        ['name' => 'Enter length or height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ponderal index of 175 cm and 70 kg?', 'answer' => '13.1 kg/m³ kg/m³.'],
        ['question' => 'A 50 cm, 3.4 kg newborn?', 'answer' => '2.72 g/cm³ × 100.'],
    ]"
>
    <x-calc.segmented name="mode" legend="For" :options="['adult' => 'Adult', 'newborn' => 'Newborn']" selected="adult" />

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

    <x-calc.result label="Ponderal index" />

    <x-calc.options :decimals="false" :examples="[
        'Adult' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'mode' => 'adult'],
        'Newborn' => ['height' => 50, 'height-unit' => 'cm', 'weight' => 3.4, 'weight-unit' => 'kg', 'mode' => 'newborn'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'si' => ['label' => 'kg/m³'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PI = kg ÷ m³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
