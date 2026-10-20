<x-calc.page
    title="Trigonometry Calculator - SolveKit"
    description="Free trigonometry calculator: evaluate any expression with sin, cos, tan and their inverses in degrees or radians, with exact results recognised."
    lede="Evaluate a trig expression."
    about="Type an expression such as sin(30) + cos(45)^2 or 2 tan(π/8). Angles are read in the mode you choose. When the answer is a simple fraction or square root it is shown exactly. Also known as trig calculator."
    :calc="['engine' => 'mt-trig', 'tool' => 'expression', 'fields' => ['mode', 'expr', 'angle_mode', 'question', 'answer'], 'practice' => 'trig']"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is sin 30° + cos²45°?', 'answer' => '1.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch Mode to Practice questions: each question asks for an exact unit-circle value such as sin 150° or tan 225°. Type it as a fraction or root (√3/2) or a decimal to check it.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <x-calc.field name="expr" label="Expression" value="sin(30) + cos(45)^2" type="text" inputmode="text" />
    </div>

    <div data-show-when="mode:calculate">
        <x-calc.select name="angle_mode" label="Angles in" :options="['deg' => 'Degrees', 'rad' => 'Radians']" selected="deg" />
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'expr' => 'sin(30) + cos(45)^2', 'angle_mode' => 'deg'],
        'Radians' => ['mode' => 'calculate', 'expr' => '2tan(pi/8)', 'angle_mode' => 'rad'],
        'Practice' => ['expr' => 'sin(30) + cos(45)^2', 'angle_mode' => 'deg', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'decimal' => ['label' => 'Decimal'],
                'exact' => ['label' => 'Exact form'],
                'mode' => ['label' => 'Angle mode'],
                'scientific' => ['label' => 'Scientific'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
        </div>
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>any trig expression</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
