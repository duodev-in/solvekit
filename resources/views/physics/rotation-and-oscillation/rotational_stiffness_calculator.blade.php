<x-calc.page
    title="Rotational Stiffness Calculator - SolveKit"
    description="Free rotational stiffness calculator: k = M/θ for torsional springs and joints."
    lede="Solve k = M ÷ θ."
    about="Rotational stiffness is the moment needed per radian of rotation, used for torsion springs, shafts and semi-rigid connections."
    :calc="['engine' => 'ph-mech', 'tool' => 'rot_stiffness', 'fields' => ['solve', 'k', 'M', 'th', 'out_k', 'out_M', 'out_th'], 'unitFields' => ['k' => collect(config('units.rotational_stiffness'))->only(['nmrad', 'nmdeg', 'knmrad', 'lbfinrad', 'lbfindeg'])->all(), 'M' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all(), 'th' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'k', 'length', 'mass', 'rotational_stiffness', 'speed', 'torque'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What stiffness gives 1° under 100 N·m?', 'answer' => '5,729.58 N·m/rad.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['k' => 'Rotational stiffness', 'M' => 'Torque (moment)', 'th' => 'Rotation']" selected="k" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:M,th" hidden>
            <x-calc.field name="k" label="Rotational stiffness" value="5729.6" min="0" placeholder="Rotational stiffness">
                <label for="calc-k-unit" class="sr-only">Rotational stiffness unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.rotational_stiffness'))->only(['nmrad', 'nmdeg', 'knmrad', 'lbfinrad', 'lbfindeg']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nmrad')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:k,th">
            <x-calc.field name="M" label="Torque (moment)" value="100" placeholder="Torque (moment)">
                <label for="calc-M-unit" class="sr-only">Torque (moment) unit</label>
                <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:k,M">
            <x-calc.field name="th" label="Rotation" value="1" placeholder="Rotation">
                <label for="calc-th-unit" class="sr-only">Rotation unit</label>
                <select id="calc-th-unit" name="th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:k">
            <x-calc.select name="out_k" label="Show the result in" :options="['nmrad' => 'N·m/rad', 'nmdeg' => 'N·m/°', 'knmrad' => 'kN·m/rad', 'lbfinrad' => 'lbf·in/rad', 'lbfindeg' => 'lbf·in/°']" selected="nmrad" />
        </div>
        <div data-show-when="solve:M" hidden>
            <x-calc.select name="out_M" label="Show the result in" :options="['nm' => 'N·m', 'knm' => 'kN·m', 'ncm' => 'N·cm', 'nmm' => 'N·mm', 'lbfft' => 'ft·lbf', 'lbfin' => 'in·lbf', 'kgfm' => 'kgf·m']" selected="nm" />
        </div>
        <div data-show-when="solve:th" hidden>
            <x-calc.select name="out_th" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
    </div>

    <x-calc.result label="Rotational stiffness" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'k', 'k' => 5729.6, 'k-unit' => 'nmrad', 'out_k' => 'nmrad', 'M' => 100, 'M-unit' => 'nm', 'out_M' => 'nm', 'th' => 1, 'th-unit' => 'deg', 'out_th' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>k = M ÷ θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
