<x-calc.page
    title="Waist to Height Ratio Calculator - SolveKit"
    description="Free waist to height ratio calculator: WHtR and the NICE advice to keep your waist under half your height."
    lede="Check your waist-to-height ratio."
    about="Waist-to-height ratio = waist ÷ height. NICE (2022) advises keeping it under 0.5: 0.4–0.49 is healthy, 0.5–0.59 increased risk and 0.6 or more high risk. It works across sexes and ethnic groups, and for children over 5. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'whtr', 'fields' => ['waist', 'height'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the waist', 'text' => 'Halfway between the lowest rib and the top of the hip bone.'],
    ]"
    :faqs="[
        ['question' => 'What is the WHtR of an 86 cm waist and 175 cm?', 'answer' => '0.49 (0.4–0.49: healthy (NICE 2022)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waist" label="Waist" value="86" min="0" placeholder="Waist">
            <label for="calc-waist-unit" class="sr-only">Waist unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Waist-to-height ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['waist' => 86, 'waist-unit' => 'cm', 'height' => 175, 'height-unit' => 'cm'],
        'Higher' => ['waist' => 100, 'waist-unit' => 'cm', 'height' => 170, 'height-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'target' => ['label' => 'Target waist'],
            'guideline' => ['label' => 'Guideline'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WHtR = waist ÷ height</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
