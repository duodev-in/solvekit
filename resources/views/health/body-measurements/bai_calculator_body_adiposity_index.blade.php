<x-calc.page
    title="BAI Calculator - Body Adiposity Index - SolveKit"
    description="Free BAI calculator: body adiposity index, an estimate of body fat percentage from hip circumference and height."
    lede="Estimate body fat from hip and height."
    about="Body adiposity index = hip circumference (cm) ÷ height (m)^1.5 − 18 (Bergman et al. 2011). It estimates body fat percentage without weighing; the result is compared with American Council on Exercise categories. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bai', 'fields' => ['hip', 'height', 'sex'], 'unitFields' => ['hip' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure your hips at the widest point', 'text' => ''],
        ['name' => 'Enter height', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the BAI for 100 cm hips and 1.70 m?', 'answer' => '27.1%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hip" label="Hip circumference" value="100" min="0" placeholder="Hip circumference">
            <label for="calc-hip-unit" class="sr-only">Hip circumference unit</label>
            <select id="calc-hip-unit" name="hip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
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

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="Body adiposity index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hip' => 100, 'hip-unit' => 'cm', 'height' => 170, 'height-unit' => 'cm', 'sex' => 'male'],
        'Woman' => ['hip' => 105, 'hip-unit' => 'cm', 'height' => 163, 'height-unit' => 'cm', 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'category' => ['label' => 'ACE category'],
            'note' => ['label' => 'Limits'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BAI = hip ÷ height^1.5 − 18</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
