<x-calc.page
    title="FFMI Calculator (Fat-Free Mass Index) - SolveKit"
    description="Free FFMI calculator: fat-free mass index and the height-normalised FFMI from body fat, or with a guided tape-measure estimate."
    lede="Work out your fat-free mass index."
    about="FFMI = lean mass (kg) ÷ height (m)²; the normalised value adds 6.1 × (1.8 − height) to compare people of different heights (Kouri et al. 1995). Kouri found that men not using steroids rarely exceeded about 25. The guided mode estimates body fat with the US Navy tape method if you do not know it. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'ffmi', 'fields' => ['mode', 'height', 'weight', 'sex', 'body_fat', 'neck', 'waist', 'hip'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'neck' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'hip' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Choose how to give body fat', 'text' => 'Or let the tape method estimate it.'],
        ['name' => 'Enter height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the FFMI of 175 cm, 80 kg and 15% body fat?', 'answer' => '22.5 kg/m² (Excellent; FFMI 22.2 with 15.0% body fat).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Body fat" :options="['known' => 'I know my body fat %', 'tape' => 'Guide me (tape measure)']" selected="known" />

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

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <div data-show-when="mode:known">
        <x-calc.field name="body_fat" label="Body fat" value="15" min="1" max="70" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:tape" hidden>
            <x-calc.field name="neck" label="Neck" value="38" min="0" placeholder="Neck">
                <label for="calc-neck-unit" class="sr-only">Neck unit</label>
                <select id="calc-neck-unit" name="neck-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tape" hidden>
            <x-calc.field name="waist" label="Waist" value="84" min="0" placeholder="Waist">
                <label for="calc-waist-unit" class="sr-only">Waist unit</label>
                <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tape" hidden>
            <x-calc.field name="hip" label="Hip (women)" value="98" min="0" placeholder="Hip (women)">
                <label for="calc-hip-unit" class="sr-only">Hip (women) unit</label>
                <select id="calc-hip-unit" name="hip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Normalised FFMI" />

    <x-calc.options :decimals="false" :examples="[
        'Known' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'mode' => 'known', 'sex' => 'male', 'body_fat' => 15, 'neck' => 38, 'neck-unit' => 'cm', 'waist' => 84, 'waist-unit' => 'cm', 'hip' => 98, 'hip-unit' => 'cm'],
        'Guided' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 80, 'weight-unit' => 'kg', 'mode' => 'tape', 'sex' => 'male', 'body_fat' => 15, 'neck' => 40, 'neck-unit' => 'cm', 'waist' => 82, 'waist-unit' => 'cm', 'hip' => 98, 'hip-unit' => 'cm'],
        'Woman' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 60, 'weight-unit' => 'kg', 'mode' => 'known', 'sex' => 'female', 'body_fat' => 24, 'neck' => 33, 'neck-unit' => 'cm', 'waist' => 72, 'waist-unit' => 'cm', 'hip' => 96, 'hip-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ffmi' => ['label' => 'FFMI'],
            'lean' => ['label' => 'Lean mass'],
            'fat' => ['label' => 'Fat mass'],
            'band' => ['label' => 'Band'],
            'kouri' => ['label' => 'Context'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FFMI = lean kg ÷ m²</li>
            <li>normalised = FFMI + 6.1 × (1.8 − h)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
