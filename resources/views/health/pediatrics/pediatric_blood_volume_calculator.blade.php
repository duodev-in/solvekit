<x-calc.page
    title="Pediatric Blood Volume Calculator - SolveKit"
    description="Free pediatric blood volume calculator: estimated circulating blood volume from weight and age group (mL/kg)."
    lede="Estimate a child's blood volume."
    about="Estimated blood volume uses standard mL/kg values that fall with age: preterm newborns about 100 mL/kg, term newborns 85, infants 80, children 75, adult men 70 and women 65 mL/kg. It is used to judge blood loss and how large a sample is relative to the child. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'blood_volume', 'fields' => ['weight', 'group'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight', 'text' => ''],
        ['name' => 'Choose the age group', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the blood volume of a 12 kg child?', 'answer' => '900 mL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="12" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="group" label="Age group" :options="['preterm' => 'Preterm newborn', 'term' => 'Term newborn', 'infant' => 'Infant (1–12 months)', 'child' => 'Child (over 1 year)', 'man' => 'Adult man', 'woman' => 'Adult woman']" selected="child" />
    </div>

    <x-calc.result label="Estimated blood volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 12, 'weight-unit' => 'kg', 'group' => 'child'],
        'Newborn' => ['weight' => 3.4, 'weight-unit' => 'kg', 'group' => 'term'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perKg' => ['label' => 'Value used'],
            'table' => ['label' => 'Reference values'],
            'loss' => ['label' => '10% of volume'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EBV = mL/kg × kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
