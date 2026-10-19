<x-calc.page
    title="Body Frame Size Calculator - SolveKit"
    description="Free body frame size calculator: small, medium or large frame from height and wrist circumference."
    lede="Find your body frame size."
    about="Frame size uses the ratio of height to wrist circumference (Grant 1980): men are small above 10.4, medium 9.6–10.4 and large below 9.6; women small above 11.0, medium 10.1–11.0 and large below 10.1. Measure the wrist just beyond the wrist bone. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'frame', 'fields' => ['height', 'wrist', 'sex'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'wrist' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure the wrist', 'text' => ''],
        ['name' => 'Enter height and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What frame is 175 cm with a 17 cm wrist?', 'answer' => 'Medium.'],
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
        <x-calc.field name="wrist" label="Wrist circumference" value="17" min="0" placeholder="Wrist circumference">
            <label for="calc-wrist-unit" class="sr-only">Wrist circumference unit</label>
            <select id="calc-wrist-unit" name="wrist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Body frame" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['height' => 175, 'height-unit' => 'cm', 'wrist' => 17, 'wrist-unit' => 'cm', 'sex' => 'male'],
        'Woman' => ['height' => 163, 'height-unit' => 'cm', 'wrist' => 14.5, 'wrist-unit' => 'cm', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Height ÷ wrist'],
            'cutoffs' => ['label' => 'Cut-offs'],
            'use' => ['label' => 'Use'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = height ÷ wrist</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
