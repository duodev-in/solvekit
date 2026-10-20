<x-calc.page
    title="Steps to km Calculator - SolveKit"
    description="Free steps to km calculator: distance from steps and height or step length."
    lede="Convert steps to kilometres."
    about="Distance is steps times step length; walking steps are about 0.415 × height."
    :calc="['engine' => 'sp-run', 'tool' => 'steps_km', 'fields' => ['steps', 'mode', 'by', 'h', 's', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 's' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far are 10,000 steps at 170 cm?', 'answer' => '7.055 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Steps" value="10000" min="1" step="any" />
        <x-calc.select name="mode" label="Activity" :options="['walk' => 'Walking', 'run' => 'Running']" selected="walk" />
        <x-calc.select name="by" label="Stride from" :options="['height' => 'My height', 'stride' => 'My measured step length']" selected="height" />
        <div data-show-when="by:height">
            <x-calc.field name="h" label="Height" value="170" placeholder="Height">
                <label for="calc-h-unit" class="sr-only">Height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:stride">
            <x-calc.field name="s" label="Step length" value="70" placeholder="Step length">
                <label for="calc-s-unit" class="sr-only">Step length unit</label>
                <select id="calc-s-unit" name="s-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="km" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'steps' => 10000, 'mode' => 'walk', 'by' => 'height', 'h' => 170, 'h-unit' => 'cm', 's' => 70, 's-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'step' => ['label' => 'Step length used'],
            'per' => ['label' => 'Steps per km'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
