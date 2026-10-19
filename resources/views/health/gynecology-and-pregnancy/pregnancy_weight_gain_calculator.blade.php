<x-calc.page
    title="Pregnancy Weight Gain Calculator - SolveKit"
    description="Free pregnancy weight gain calculator: the recommended total and weekly gain for your pre-pregnancy BMI (IOM 2009), for one baby or twins, and where you are now."
    lede="See the recommended pregnancy weight gain."
    about="The Institute of Medicine (2009) recommends total gains of 12.5–18 kg for underweight, 11.5–16 kg for healthy weight, 7–11.5 kg for overweight and 5–9 kg for obesity (BMI before pregnancy), with about 0.5–2 kg in the first trimester and the weekly rates shown after that. For twins the provisional ranges are 17–25, 14–23 and 11–19 kg. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'weight_gain', 'fields' => ['height', 'weight', 'weeks', 'current', 'twins'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'current' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and weight before pregnancy', 'text' => ''],
        ['name' => 'Enter weeks and current weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much should a 165 cm, 62 kg woman gain?', 'answer' => '11.5–16 kg (Healthy weight (18.5–24.9), BMI 22.8; 25–35 lb).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="165" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="62" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weeks" label="Weeks pregnant" value="24" min="0" max="42" step="1" suffix="weeks" />
        <x-calc.field name="current" label="Current weight (optional)" value="68" min="0" placeholder="Current weight (optional)">
            <label for="calc-current-unit" class="sr-only">Current weight (optional) unit</label>
            <select id="calc-current-unit" name="current-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.segmented name="twins" legend="Babies" :options="['single' => 'One', 'twins' => 'Twins']" selected="single" />
    </div>

    <x-calc.result label="Recommended total gain" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 62, 'weight-unit' => 'kg', 'weeks' => 24, 'current' => 68, 'current-unit' => 'kg', 'twins' => 'single'],
        'Twins' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 75, 'weight-unit' => 'kg', 'weeks' => 30, 'current' => 88, 'current-unit' => 'kg', 'twins' => 'twins'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'now' => ['label' => 'Expected by now'],
            'weekly' => ['label' => 'Weekly rate'],
            'gained' => ['label' => 'Your gain'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BMI = kg ÷ m²</li>
            <li>IOM 2009 ranges</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
