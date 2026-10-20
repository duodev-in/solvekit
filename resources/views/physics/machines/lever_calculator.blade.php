<x-calc.page
    title="Lever Calculator - SolveKit"
    description="Free lever calculator: solve F_e d_e = F_l d_l for the effort, load or either arm, for all lever classes."
    lede="Solve a lever."
    about="All levers obey the same moment balance: effort × effort arm = load × load arm."
    :calc="['engine' => 'ph-mach', 'tool' => 'lever', 'fields' => ['solve', 'Fe', 'de', 'Fl', 'dl', 'out_Fe', 'out_de', 'out_Fl', 'out_dl'], 'unitFields' => ['Fe' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'de' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'Fl' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'dl' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What effort lifts 600 N with arms of 1.5 m and 0.5 m?', 'answer' => '200 N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Fe' => 'Effort force', 'de' => 'Effort arm', 'Fl' => 'Load force', 'dl' => 'Load arm']" selected="Fe" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:de,Fl,dl" hidden>
            <x-calc.field name="Fe" label="Effort force" value="200" placeholder="Effort force">
                <label for="calc-Fe-unit" class="sr-only">Effort force unit</label>
                <select id="calc-Fe-unit" name="Fe-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Fe,Fl,dl">
            <x-calc.field name="de" label="Effort arm" value="1.5" placeholder="Effort arm">
                <label for="calc-de-unit" class="sr-only">Effort arm unit</label>
                <select id="calc-de-unit" name="de-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Fe,de,dl">
            <x-calc.field name="Fl" label="Load force" value="600" placeholder="Load force">
                <label for="calc-Fl-unit" class="sr-only">Load force unit</label>
                <select id="calc-Fl-unit" name="Fl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Fe,de,Fl">
            <x-calc.field name="dl" label="Load arm" value="0.5" placeholder="Load arm">
                <label for="calc-dl-unit" class="sr-only">Load arm unit</label>
                <select id="calc-dl-unit" name="dl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Fe">
            <x-calc.select name="out_Fe" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:de" hidden>
            <x-calc.select name="out_de" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:Fl" hidden>
            <x-calc.select name="out_Fl" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:dl" hidden>
            <x-calc.select name="out_dl" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
    </div>

    <x-calc.result label="Effort force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Fe', 'Fe' => 200, 'Fe-unit' => 'n', 'out_Fe' => 'n', 'de' => 1.5, 'de-unit' => 'm', 'out_de' => 'm', 'Fl' => 600, 'Fl-unit' => 'n', 'out_Fl' => 'n', 'dl' => 0.5, 'dl-unit' => 'm', 'out_dl' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ma' => ['label' => 'Mechanical advantage'],
            'classes' => ['label' => 'Lever classes'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F_e d_e = F_l d_l</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
