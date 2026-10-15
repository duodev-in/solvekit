@php
    $units = config('units.angle');
@endphp

<x-calc.page
    title="Angle Conversion Calculator - SolveKit"
    description="Professional angle conversion calculator for degrees, radians, gradians, and other angular measurements. Perfect for engineering, mathematics, and scientific calculations."
    lede="Convert between degrees, radians, gradians, turns, mils and other angle units."
    about="Every unit converts through the radian. A full turn is 360°, 2π rad, 400 gradians, 6,400 NATO mils or 32 compass points."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter an angle', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert degrees to radians?', 'answer' => 'Multiply by π/180. 90° is π/2, about 1.5708 rad.'],
        ['question' => 'What is a gradian?', 'answer' => '1/400 of a turn, so a right angle is 100 gradians. It is used in some surveying.'],
        ['question' => 'What is a mil?', 'answer' => 'NATO mils divide a turn into 6,400, used for aiming. 1 mil is about 1 m at 1 km.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="deg" to="rad" value="90" label="Angle" />

    <x-calc.result label="Radians">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Right angle 90°' => ['value' => 90, 'from' => 'deg'],
        'One radian' => ['value' => 1, 'from' => 'rad'],
        'Half turn' => ['value' => 0.5, 'from' => 'turn'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="90° in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rad = deg × π ÷ 180</li>
            <li>1 turn = 360° = 2π rad = 400 gon</li>
            <li>1 NATO mil = 2π ÷ 6,400 rad</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
