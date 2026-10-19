<x-calc.page
    title="Blood Donor Calculator - SolveKit"
    description="Free blood donor calculator: whether you meet the basic age and weight rules to give blood, your blood volume and how much a donation takes."
    lede="Check if you can give blood."
    about="The American Red Cross asks whole blood donors to be at least 17 (16 with parental consent in some states) and weigh at least 110 lb (50 kg); Power Red has higher height and weight minimums. A 500 mL donation is about 10% of an adult's blood volume (Nadler equation). Health, travel and medicines are checked on the day. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'donor', 'fields' => ['age', 'sex', 'height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
        ['name' => 'Enter height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Can a 30-year-old man, 170 cm and 65 kg, give blood?', 'answer' => 'Likely eligible: A 500 mL donation is 11% of your blood (limit 10.5 mL/kg: 683 mL).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="30" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
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
        <x-calc.field name="weight" label="Weight" value="65" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Basic donor check" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 30, 'sex' => 'male', 'height' => 170, 'height-unit' => 'cm', 'weight' => 65, 'weight-unit' => 'kg'],
        'Too light' => ['age' => 19, 'sex' => 'female', 'height' => 155, 'height-unit' => 'cm', 'weight' => 46, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volume' => ['label' => 'Blood volume'],
            'share' => ['label' => 'One donation'],
            'power' => ['label' => 'Power Red'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BV by Nadler</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
