<x-calc.page
    title="Dimensional Analysis Calculator - SolveKit"
    description="Professional dimensional analysis calculator for complex unit conversions and dimensional relationships. Analyze compound units, verify dimensional consistency, and perform advanced unit calculations."
    lede="Break a unit or expression down into base dimensions and name the quantity."
    about="Every physical unit is a product of powers of seven base dimensions: mass M, length L, time T, current I, temperature Θ, amount N and luminous intensity J. Newtons are kg·m/s², which is [M L T⁻²]. Two expressions describe the same kind of quantity only if their dimensions match. Units after a slash are treated as the denominator."
    :calc="['engine' => 'dimensional-analysis']"
    :how-to="[
        ['name' => 'Type a unit or expression', 'text' => 'For example N·m, kg*m/s^2 or 9.8 m/s². Use * or · to multiply, / to divide and ^ or ² for powers.'],
        ['name' => 'Read the dimensions', 'text' => 'The exponent of each base dimension is listed, with the quantity name when it is a known one.'],
    ]"
    :faqs="[
        ['question' => 'Why do torque and energy have the same dimensions?', 'answer' => 'Both are force × distance, [M L² T⁻²]. Torque uses a perpendicular distance and energy a distance moved, so they are named differently.'],
        ['question' => 'What does dimensionless mean?', 'answer' => 'All exponents are zero, as in a ratio, an angle in radians or a strain.'],
        ['question' => 'Which units can I use?', 'answer' => 'SI base and derived units (kg, m, s, A, K, mol, cd, N, J, W, Pa, Hz, C, V, Ω, F, T, Wb, H) and common ones such as ft, in, mi, lb, lbf, psi, h, min, L, gal and kWh.'],
    ]"
>
    <x-calc.field name="value" type="text" label="Unit or expression" value="kg*m/s^2" placeholder="e.g. N·m or kg·m/s²" spellcheck="false" autocapitalize="off" />

    <x-calc.result label="Dimensions" />

    <x-calc.options :decimals="false" :examples="[
        'Joule J' => ['value' => 'J'],
        'Pressure N/m^2' => ['value' => 'N/m^2'],
        'Density kg/m³' => ['value' => 'kg/m³'],
        'Ohm Ω' => ['value' => 'Ω'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Base dimension exponents" hint="" :rows="[
            'd0' => ['label' => 'Mass (M)'],
            'd1' => ['label' => 'Length (L)'],
            'd2' => ['label' => 'Time (T)'],
            'd3' => ['label' => 'Electric current (I)'],
            'd4' => ['label' => 'Temperature (Θ)'],
            'd5' => ['label' => 'Amount of substance (N)'],
            'd6' => ['label' => 'Luminous intensity (J)'],
        ]" />
        <x-calc.rows heading="Quantity" hint="" :rows="[
            'quantity' => ['label' => 'Named quantity'],
            'dimensionless' => ['label' => 'Dimensionless'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = kg·m·s⁻² → [M L T⁻²]</li>
            <li>J = N·m → [M L² T⁻²]</li>
            <li>W = J/s → [M L² T⁻³]</li>
            <li>V = W/A → [M L² T⁻³ I⁻¹]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
