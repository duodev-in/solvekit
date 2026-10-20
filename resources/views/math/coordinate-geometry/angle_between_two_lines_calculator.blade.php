<x-calc.page
    title="Angle Between Two Lines Calculator - SolveKit"
    description="Free angle between two lines calculator: the acute and obtuse angles between two lines from their equations."
    lede="Find the angle between lines."
    about="Two crossing lines make an acute angle θ and its supplement. With slopes m₁ and m₂, tan θ = |(m₁ − m₂) ÷ (1 + m₁m₂)|; perpendicular lines have m₁m₂ = −1 and parallel lines 0°."
    :calc="['engine' => 'mt-coord', 'tool' => 'intersection', 'fields' => ['eq1', 'eq2'], 'want' => 'angle']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What angle do y = 2x + 1 and y = −x/3 make?', 'answer' => '81.86989765 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="eq1" label="Line 1" value="y = 2x + 1" type="text" inputmode="text" />
        <x-calc.field name="eq2" label="Line 2" value="y = -x/3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Acute angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq1' => 'y = 2x + 1', 'eq2' => 'y = -x/3'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'lines' => ['label' => 'Lines'],
            'angle' => ['label' => 'Angles'],
            'relation' => ['label' => 'Formula'],
            'radians' => ['label' => 'Radians'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tan θ = |(m₁ − m₂) ÷ (1 + m₁m₂)|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
