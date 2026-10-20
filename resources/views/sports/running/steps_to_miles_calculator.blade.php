<x-calc.page
    title="Steps to Miles Calculator - SolveKit"
    description="Free steps to miles calculator: distance in miles from steps and height."
    lede="Convert steps to miles."
    about="About 2,000–2,500 walking steps make a mile for most adults."
    :calc="['engine' => 'sp-run', 'tool' => 'steps_miles', 'fields' => ['steps', 'mode', 'h', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many miles are 10,000 steps?', 'answer' => '4.38842 mi.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Steps" value="10000" min="1" step="any" />
        <x-calc.select name="mode" label="Activity" :options="['walk' => 'Walking', 'run' => 'Running']" selected="walk" />
        <x-calc.field name="h" label="Height" value="67" placeholder="Height">
            <label for="calc-h-unit" class="sr-only">Height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mi" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mi', 'steps' => 10000, 'mode' => 'walk', 'h' => 67, 'h-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'per' => ['label' => 'Steps per mile'],
            'step' => ['label' => 'Step length used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
