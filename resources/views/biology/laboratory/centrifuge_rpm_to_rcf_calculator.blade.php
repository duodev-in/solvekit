<x-calc.page
    title="Centrifuge RPM to RCF Calculator - SolveKit"
    description="Free centrifuge calculator: convert RPM to relative centrifugal force (× g) and back from the rotor radius."
    lede="Convert rotor speed (RPM) to g-force (RCF) and back."
    about="Relative centrifugal force depends on speed and on the rotor radius, so protocols should give × g, not RPM. Use the radius in centimeters from the rotor axis to the bottom of the tube (r max), found in the rotor manual."
    :calc="['engine' => 'lab', 'tool' => 'centrifuge', 'fields' => ['mode', 'speed', 'radius']]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'RPM to × g or × g to RPM.'],
        ['name' => 'Enter the speed', 'text' => 'RPM or × g depending on the direction.'],
        ['name' => 'Enter the rotor radius', 'text' => 'r max in cm from the rotor manual.'],
    ]"
    :faqs="[
        ['question' => 'Why use × g instead of RPM?', 'answer' => 'The same RPM gives a different force in a bigger rotor; × g is the same on any centrifuge.'],
        ['question' => 'Where do I find the rotor radius?', 'answer' => 'In the rotor manual or on the rotor lid, usually as r max.'],
        ['question' => 'What is 13,000 RPM in × g?', 'answer' => 'About 15,900 × g with an 8.4 cm rotor, typical of a microcentrifuge.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Convert" :options="['rpm' => 'RPM → × g', 'rcf' => '× g → RPM']" selected="rpm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="speed" label="Speed (RPM, or × g)" value="13000" min="0" />
        <x-calc.field name="radius" label="Rotor radius" value="8.4" min="0" suffix="cm" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Microfuge 13,000 RPM' => ['mode' => 'rpm', 'speed' => 13000, 'radius' => 8.4],
        '500 × g in 15 cm rotor' => ['mode' => 'rcf', 'speed' => 500, 'radius' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Common speeds at this radius" name="quick-ref" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RCF = 1.118 × 10⁻⁵ × r (cm) × RPM²</li>
            <li>RPM = √(RCF ÷ (1.118 × 10⁻⁵ × r))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
