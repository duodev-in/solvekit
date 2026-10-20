<x-calc.page
    title="Quaternion Calculator - SolveKit"
    description="Free quaternion calculator: add, subtract, multiply (Hamilton product) and divide quaternions, with norm, conjugate, inverse and unit quaternion."
    lede="Calculate with quaternions."
    about="Quaternions w + xi + yj + zk extend complex numbers with i² = j² = k² = ijk = −1. Multiplication is not commutative (ij = k but ji = −k). Unit quaternions represent 3D rotations without gimbal lock."
    :calc="['engine' => 'mt-alg2', 'tool' => 'quaternion', 'fields' => ['q1', 'op', 'q2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is (1 + 2i + 3j + 4k)(2 − i + j)?', 'answer' => '1 − i + 3j + 13k.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="q1" label="Quaternion a" value="1 + 2i + 3j + 4k" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['*' => '×', '/' => '÷', '+' => '+', '-' => '−']" selected="*" />
        <x-calc.field name="q2" label="Quaternion b" value="2 - i + j" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => '1 + 2i + 3j + 4k', 'op' => '*', 'q2' => '2 - i + j'],
        'Divide' => ['q1' => '1 + i', 'op' => '/', 'q2' => 'j + k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'norm' => ['label' => 'Norm |a|'],
            'conj' => ['label' => 'Conjugate of a'],
            'inverse' => ['label' => 'Inverse of a'],
            'unit' => ['label' => 'Unit quaternion of a'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Hamilton product</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
