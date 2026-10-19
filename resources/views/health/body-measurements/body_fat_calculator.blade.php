<x-calc.page
    title="Body Fat Calculator - SolveKit"
    description="Free body fat calculator: body fat percentage by the US Navy tape method or from BMI, with fat and lean mass and the ACE category."
    lede="Estimate your body fat percentage."
    about="The US Navy method uses neck and waist (plus hip for women) and height (Hodgdon & Beckett 1984); it is usually within about 3–4% of lab methods. The BMI method (Deurenberg 1991) needs only height, weight, age and sex but is rougher. Categories are the American Council on Exercise ranges. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'body_fat', 'fields' => ['method', 'height', 'weight', 'sex', 'age', 'neck', 'waist', 'hip'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'neck' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'hip' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Measure as described', 'text' => 'Tape level and snug, not tight.'],
    ]"
    :faqs="[
        ['question' => 'What is the body fat of a 175 cm man with a 38 cm neck and 86 cm waist?', 'answer' => '17.7% (Fitness (American Council on Exercise) by the US Navy tape method).'],
        ['question' => 'And from BMI?', 'answer' => '23.2%.'],
    ]"
>
    <x-calc.segmented name="method" legend="Method" :options="['navy' => 'US Navy tape', 'bmi' => 'From BMI']" selected="navy" />

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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="method:navy">
            <x-calc.field name="neck" label="Neck" value="38" min="0" placeholder="Neck">
                <label for="calc-neck-unit" class="sr-only">Neck unit</label>
                <select id="calc-neck-unit" name="neck-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="method:navy">
            <x-calc.field name="waist" label="Waist (at the navel for men)" value="86" min="0" placeholder="Waist (at the navel for men)">
                <label for="calc-waist-unit" class="sr-only">Waist (at the navel for men) unit</label>
                <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="method:navy">
            <x-calc.field name="hip" label="Hip (women)" value="100" min="0" placeholder="Hip (women)">
                <label for="calc-hip-unit" class="sr-only">Hip (women) unit</label>
                <select id="calc-hip-unit" name="hip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Body fat" />

    <x-calc.options :decimals="false" :examples="[
        'Navy man' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'method' => 'navy', 'sex' => 'male', 'age' => 35, 'neck' => 38, 'neck-unit' => 'cm', 'waist' => 86, 'waist-unit' => 'cm', 'hip' => 100, 'hip-unit' => 'cm'],
        'Navy woman' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'method' => 'navy', 'sex' => 'female', 'age' => 35, 'neck' => 33, 'neck-unit' => 'cm', 'waist' => 76, 'waist-unit' => 'cm', 'hip' => 98, 'hip-unit' => 'cm'],
        'BMI method' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'method' => 'bmi', 'sex' => 'male', 'age' => 35, 'neck' => 38, 'neck-unit' => 'cm', 'waist' => 86, 'waist-unit' => 'cm', 'hip' => 100, 'hip-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fatMass' => ['label' => 'Fat mass'],
            'lean' => ['label' => 'Lean mass'],
            'category' => ['label' => 'ACE category'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Navy (men) = 495 ÷ (1.0324 − 0.19077 log(waist − neck) + 0.15456 log(height)) − 450</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
