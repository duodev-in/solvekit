@php
    $units = config('units.capacitance');
@endphp

<x-calc.page
    title="Capacitance Converter - SolveKit"
    description="Professional capacitance converter for electrical engineering and electronics. Convert between farads, millifarads, microfarads, nanofarads, and picofarads with detailed calculations."
    lede="Convert between farads, microfarads, nanofarads, picofarads and other capacitance units."
    about="Every unit converts through the farad. Each SI prefix step is a factor of 1,000: 1 µF = 1,000 nF = 1,000,000 pF."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a capacitance', 'text' => 'Type the value printed on the component or datasheet.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
    ]"
    :faqs="[
        ['question' => 'How many picofarads are in a microfarad?', 'answer' => '1,000,000 pF. A nanofarad is 1,000 pF.'],
        ['question' => 'What does 104 on a ceramic capacitor mean?', 'answer' => '10 followed by four zeros in picofarads: 100,000 pF = 100 nF = 0.1 µF.'],
        ['question' => 'Is mF millifarads or microfarads?', 'answer' => 'mF is millifarads (10⁻³ F). Older labels sometimes used mF or MFD for microfarads, so check the context.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="uf" to="nf" value="0.1" min="0" label="Capacitance" />

    <x-calc.result label="Nanofarads">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Code 104 (100,000 pF)' => ['value' => 100000, 'from' => 'pf'],
        'Electrolytic 470 µF' => ['value' => 470, 'from' => 'uf'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="0.1 µF in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 F = 1,000 mF = 1,000,000 µF</li>
            <li>1 µF = 1,000 nF = 1,000,000 pF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
