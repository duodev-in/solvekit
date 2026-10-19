<x-calc.page
    title="Allowable Blood Loss Calculator - SolveKit"
    description="Free allowable blood loss calculator: the blood loss before reaching a chosen lowest haematocrit, from weight, age group and starting haematocrit (Gross formula)."
    lede="Estimate allowable blood loss."
    about="Gross (1983): allowable blood loss = estimated blood volume × (starting Hct − lowest acceptable Hct) ÷ average Hct. Estimated blood volume uses mL/kg by age: preterm 100, term newborn 85, infant 80, child 75, adult man 70 and woman 65. Anaesthetists use it to plan; transfusion decisions depend on the clinical situation. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'abl', 'fields' => ['weight', 'group', 'hi', 'hf'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and age group', 'text' => ''],
        ['name' => 'Enter starting and lowest haematocrit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the allowable loss for a 70 kg man from Hct 42% to 27%?', 'answer' => '2,130 mL (Estimated blood volume 4,900 mL (70 mL/kg)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="group" label="Age group" :options="['preterm' => 'Preterm newborn', 'term' => 'Term newborn', 'infant' => 'Infant', 'child' => 'Child', 'man' => 'Adult man', 'woman' => 'Adult woman']" selected="man" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hi" label="Starting haematocrit" value="42" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="hf" label="Lowest acceptable haematocrit" value="27" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Allowable blood loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 70, 'weight-unit' => 'kg', 'group' => 'man', 'hi' => 42, 'hf' => 27],
        'Child' => ['weight' => 20, 'weight-unit' => 'kg', 'group' => 'child', 'hi' => 36, 'hf' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'simple' => ['label' => 'Simple formula'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ABL = EBV × (Hi − Hf) ÷ Hav</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
