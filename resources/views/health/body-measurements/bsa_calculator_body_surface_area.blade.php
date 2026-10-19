<x-calc.page
    title="BSA Calculator – Body Surface Area - SolveKit"
    description="Free BSA calculator: body surface area by the Mosteller, DuBois, Haycock, Gehan and George and Boyd formulas."
    lede="Calculate body surface area."
    about="Body surface area is used to index cardiac output, kidney function and other measures to body size. Mosteller: √(height cm × weight kg ÷ 3600). DuBois: 0.007184 × height^0.725 × weight^0.425. The formulas agree closely for average adults and differ more for children and very large adults. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bsa', 'fields' => ['height', 'weight', 'formula'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => ''],
        ['name' => 'Choose a formula', 'text' => 'All are shown in the table.'],
    ]"
    :faqs="[
        ['question' => 'What is the BSA of 175 cm and 80 kg?', 'answer' => '1.97 m² m² (Mosteller).'],
    ]"
>
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

    <x-calc.select name="formula" label="Formula" :options="['mosteller' => 'Mosteller', 'dubois' => 'DuBois & DuBois', 'haycock' => 'Haycock (children)', 'gehan' => 'Gehan & George', 'boyd' => 'Boyd']" selected="mosteller" />

    <x-calc.result label="Body surface area" />

    <x-calc.options :decimals="false" :examples="[
        'Adult' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'formula' => 'mosteller'],
        'Child' => ['height' => 120, 'height-unit' => 'cm', 'weight' => 23, 'weight-unit' => 'kg', 'formula' => 'haycock'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="All formulas" name="formulas" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Mosteller = √(cm × kg ÷ 3600)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
