@php
    $extra = config('units.cgs_extra');
    $pick = fn (string $table, array $keys) => collect(config("units.{$table}"))->only($keys)->all();
    $tables = [
        'Length' => $pick('length', ['cm', 'm', 'in']),
        'Mass' => collect(config('units.mass'))->only(['g', 'kg', 'lb'])->all(),
        'Force' => $pick('force', ['dyn', 'n', 'lbf']),
        'Energy' => $pick('energy', ['erg', 'j', 'ftlbf']),
        'Pressure' => $pick('pressure', ['ba', 'pa', 'psi']),
        'Dynamic viscosity' => collect($extra)->only(['p', 'cp', 'pas'])->all(),
        'Kinematic viscosity' => collect($extra)->only(['st', 'cst', 'm2s'])->all(),
        'Acceleration' => collect($extra)->only(['gal', 'ms2', 'g0'])->all(),
        'Magnetic flux density' => collect($extra)->only(['gauss', 'tesla'])->all(),
        'Magnetic flux' => collect($extra)->only(['mx', 'wb'])->all(),
        'Magnetic field strength' => collect($extra)->only(['oe', 'am'])->all(),
        'Electric charge' => collect($extra)->only(['statc', 'coulomb'])->all(),
        'Power' => collect($extra)->only(['ergs', 'watt'])->all(),
    ];
    // Keys repeat across tables (e.g. "m"), so prefix them with their quantity.
    $units = [];
    $groups = [];
    foreach ($tables as $quantity => $table) {
        foreach ($table as $key => $unit) {
            $units[Str::slug($quantity).'.'.$key] = $unit;
            $groups[$quantity][] = Str::slug($quantity).'.'.$key;
        }
    }
@endphp

<x-calc.page
    title="CGS System of Units Converter - SolveKit"
    description="Professional CGS system converter for scientific calculations. Convert between Centimeter-Gram-Second units and SI, Imperial systems with precision for physics and chemistry applications."
    lede="Convert centimeter-gram-second units such as dynes, ergs, poise and gauss to SI and imperial units."
    about="The CGS system builds units from the centimeter, gram and second. Each quantity converts within itself only: 1 dyne = 10⁻⁵ N, 1 erg = 10⁻⁷ J, 1 poise = 0.1 Pa·s, 1 gauss = 10⁻⁴ T. Electromagnetic CGS units here are the Gaussian ones."
    :calc="['engine' => 'units', 'units' => $units, 'groups' => $groups, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Pick the unit you have', 'text' => 'Units are grouped by quantity; the target stays in the same quantity.'],
        ['name' => 'Enter the value', 'text' => 'The CGS, SI and imperial units of that quantity are listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How many newtons is a dyne?', 'answer' => '10⁻⁵ N. A dyne is the force that accelerates 1 g at 1 cm/s².'],
        ['question' => 'What is a poise?', 'answer' => 'The CGS unit of dynamic viscosity: 0.1 Pa·s. Water at 20 °C is about 1 centipoise.'],
        ['question' => 'How many tesla is a gauss?', 'answer' => '10⁻⁴ T. The Earth\'s magnetic field is about 0.25 to 0.65 gauss.'],
    ]"
>
    <x-calc.unit-pair :units="$units" :groups="$groups" from="force.dyn" to="force.n" value="1000" label="Value" />

    <x-calc.result label="Newtons">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Water viscosity 1 cP' => ['value' => 1, 'from' => 'dynamic-viscosity.cp', 'to' => 'dynamic-viscosity.pas'],
        'Fridge magnet 50 G' => ['value' => 50, 'from' => 'magnetic-flux-density.gauss', 'to' => 'magnetic-flux-density.tesla'],
        'Energy 1 erg' => ['value' => 1, 'from' => 'energy.erg', 'to' => 'energy.j'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="In other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>1 dyn = 10⁻⁵ N</li>
            <li>1 erg = 10⁻⁷ J</li>
            <li>1 Ba = 0.1 Pa</li>
            <li>1 P = 0.1 Pa·s</li>
            <li>1 St = 10⁻⁴ m²/s</li>
            <li>1 G = 10⁻⁴ T</li>
            <li>1 Oe = 1000/4π A/m</li>
            <li>1 statC ≈ 3.336 × 10⁻¹⁰ C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
