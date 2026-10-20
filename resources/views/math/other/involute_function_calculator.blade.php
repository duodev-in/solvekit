<x-calc.page
    title="Involute Function Calculator - SolveKit"
    description="Free involute function calculator: inv α = tan α − α for gear pressure angles, and the inverse by Newton's method."
    lede="Evaluate the involute function."
    about="The involute function inv α = tan α − α (radians) describes the curve of gear teeth. For the standard 20° pressure angle inv α = 0.0149044. Gear designers also need the inverse, solved here by Newton's method to full precision."
    :calc="['engine' => 'mt-other', 'tool' => 'involute', 'fields' => ['dir', 'alpha', 'inv']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'What is inv 20°?', 'answer' => '0.014904383867336.'],
    ]"
>
    <x-calc.select name="dir" label="Find" :options="['to' => 'inv α from the angle', 'from' => 'The angle from inv α']" selected="to" />

    <div data-show-when="dir:to" hidden>
        <x-calc.field name="alpha" label="Pressure angle α (°)" value="20" min="0" step="any" />
    </div>

    <div data-show-when="dir:from" hidden>
        <x-calc.field name="inv" label="inv α" value="0.0149043838673" min="0" step="any" />
    </div>

    <x-calc.result label="inv α" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'alpha' => 20, 'inv' => 0.0149043838673],
        'Inverse' => ['dir' => 'from', 'alpha' => 20, 'inv' => 0.02],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'inv' => ['label' => 'inv α'],
            'alpha' => ['label' => 'Angle'],
            'tan' => ['label' => 'tan α'],
            'use' => ['label' => 'Use'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>inv α = tan α − α</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
