<x-calc.page
    title="Navy Body Fat Calculator - SolveKit"
    description="Free Navy body fat calculator: the US Navy circumference method (neck, abdomen or waist and hips, height) with the OPNAVINST 6110.1 body fat standards."
    lede="Check the Navy body fat standard."
    about="The Navy estimates body fat from circumferences (Hodgdon & Beckett): men use neck and abdomen at the navel, women neck, natural waist and hips, plus height. OPNAVINST 6110.1J allows up to 26% for men and 36% for women aged 17–39, and 27% and 37% from 40. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'navy_bodyfat', 'fields' => ['height', 'age', 'neck', 'waist', 'hip', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'neck' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'hip' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure as described', 'text' => 'Three times and average.'],
        ['name' => 'Enter height, age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What body fat does a 70 in man with a 15.5 in neck and 34 in abdomen have?', 'answer' => '16.5%: Within the 26% Navy standard for your age and sex.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="70" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="25" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="neck" label="Neck" value="15.5" min="0" placeholder="Neck">
            <label for="calc-neck-unit" class="sr-only">Neck unit</label>
            <select id="calc-neck-unit" name="neck-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waist" label="Abdomen (men) or waist (women)" value="34" min="0" placeholder="Abdomen (men) or waist (women)">
            <label for="calc-waist-unit" class="sr-only">Abdomen (men) or waist (women) unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hip" label="Hips (women)" value="38" min="0" placeholder="Hips (women)">
            <label for="calc-hip-unit" class="sr-only">Hips (women) unit</label>
            <select id="calc-hip-unit" name="hip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Navy body fat (circumference)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 70, 'height-unit' => 'in', 'age' => 25, 'neck' => 15.5, 'neck-unit' => 'in', 'waist' => 34, 'waist-unit' => 'in', 'hip' => 38, 'hip-unit' => 'in', 'sex' => 'male'],
        'Woman' => ['height' => 65, 'height-unit' => 'in', 'age' => 30, 'neck' => 13, 'neck-unit' => 'in', 'waist' => 29, 'waist-unit' => 'in', 'hip' => 39, 'hip-unit' => 'in', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'limit' => ['label' => 'Standard'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Navy circumference equations</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
