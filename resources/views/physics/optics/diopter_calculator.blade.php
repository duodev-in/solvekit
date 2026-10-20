<x-calc.page
    title="Diopter Calculator - SolveKit"
    description="Free diopter calculator: lens power in dioptres from focal length, or focal length from power."
    lede="Convert focal length to dioptres."
    about="A lens’s power in dioptres is 1 ÷ focal length in metres. Reading glasses of +2.5 D focus at 40 cm."
    :calc="['engine' => 'ph-wave', 'tool' => 'diopter', 'fields' => ['solve', 'P', 'f', 'out_f'], 'unitFields' => ['f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['P', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What power has a 40 cm focal length?', 'answer' => '2.5 D.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['P' => 'Lens power (dioptres)', 'f' => 'Focal length']" selected="P" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:f" hidden>
            <x-calc.field name="P" label="Lens power (dioptres)" value="2.5" step="any" />
        </div>
        <div data-show-when="solve:P">
            <x-calc.field name="f" label="Focal length" value="40" placeholder="Focal length">
                <label for="calc-f-unit" class="sr-only">Focal length unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f" hidden>
            <x-calc.select name="out_f" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <x-calc.result label="Lens power (dioptres)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'P', 'P' => 2.5, 'f' => 40, 'f-unit' => 'cm', 'out_f' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'kind' => ['label' => 'Lens type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = 1 ÷ f (f in metres)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
