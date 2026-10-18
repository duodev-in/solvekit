<x-calc.page
    title="True Position Calculator - SolveKit"
    description="Free true position calculator: GD&T position from X and Y deviations, with MMC bonus tolerance and a pass or fail result (ASME Y14.5)."
    lede="Work out true position and check it against the tolerance."
    about="Position (diametral) = 2 × √(Δx² + Δy²), where Δx and Δy are the measured deviations from the true (basic) location. With an MMC modifier, the tolerance grows by how far the feature's actual size departs from its maximum material size (ASME Y14.5)."
    :calc="['engine' => 'con-mech', 'tool' => 'true_position', 'fields' => ['units', 'dx', 'dy', 'tolerance', 'mmc', 'mmc_size', 'actual']]"
    :how-to="[
        ['name' => 'Enter the deviations', 'text' => 'Measured minus basic, in X and Y.'],
        ['name' => 'Enter the tolerance', 'text' => 'And MMC sizes if the callout has Ⓜ.'],
    ]"
    :faqs="[
        ['question' => 'How is true position calculated?', 'answer' => '2 × √(Δx² + Δy²).'],
        ['question' => 'What is bonus tolerance?', 'answer' => 'Extra position tolerance as a hole gets bigger (or a pin smaller) than its MMC size.'],
        ['question' => 'Why multiply by 2?', 'answer' => 'Position tolerance is a diameter around the true location.'],
    ]"
>
    <x-calc.select name="units" label="Units" :options="['in' => 'Inches', 'mm' => 'Millimeters']" selected="in" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="dx" label="X deviation" value="0.003" />
        <x-calc.field name="dy" label="Y deviation" value="0.004" />
        <x-calc.field name="tolerance" label="Position tolerance ⌀" value="0.01" min="0" />
    </div>

    <x-calc.segmented name="mmc" legend="MMC modifier" :options="['no' => 'No', 'yes' => 'Yes (bonus)']" selected="no" />

    <div data-show-when="mmc:yes" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="mmc_size" label="Size at MMC" value="0.25" min="0" />
            <x-calc.field name="actual" label="Actual size" value="0.254" min="0" />
        </div>
    </div>

    <x-calc.result label="True position" />

    <x-calc.options :examples="[
        '0.003, 0.004 in ⌀0.010' => ['units' => 'in', 'dx' => 0.003, 'dy' => 0.004, 'tolerance' => 0.01, 'mmc' => 'no'],
        'With MMC bonus' => ['units' => 'in', 'dx' => 0.005, 'dy' => 0.004, 'tolerance' => 0.01, 'mmc' => 'yes', 'mmc_size' => 0.25, 'actual' => 0.254],
        'Metric 0.05, 0.08 mm' => ['units' => 'mm', 'dx' => 0.05, 'dy' => 0.08, 'tolerance' => 0.2, 'mmc' => 'no'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'allowed' => ['label' => 'Tolerance allowed'],
            'radial' => ['label' => 'Radial offset'],
            'result' => ['label' => 'Result'],
            'used' => ['label' => 'Tolerance used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>position = 2 √(Δx² + Δy²)</li>
            <li>allowed = tolerance + |actual − MMC|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
