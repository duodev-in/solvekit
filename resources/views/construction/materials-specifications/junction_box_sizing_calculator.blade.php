<x-calc.page
    title="Junction Box Sizing Calculator - SolveKit"
    description="Free junction and pull box sizing calculator: minimum box length for straight, angle and U pulls by NEC 314.28 for conductors 4 AWG and larger."
    lede="Work out the minimum size of a pull or junction box (NEC 314.28)."
    about="For conductors 4 AWG and larger, NEC 314.28(A) sets box size from the raceway trade sizes: a straight pull needs a length of at least 8 × the largest raceway; an angle or U pull needs at least 6 × the largest raceway plus the sum of the other raceways on the same wall and row, and raceway entries enclosing the same conductor must be 6 × the larger raceway apart."
    :calc="['engine' => 'con-elec', 'tool' => 'pull_box', 'fields' => ['pull', 'largest', 'others']]"
    :how-to="[
        ['name' => 'Choose the pull', 'text' => 'Straight, angle or U.'],
        ['name' => 'Enter the raceway sizes', 'text' => 'Trade sizes in inches.'],
    ]"
    :faqs="[
        ['question' => 'How big a box for a straight pull with 2 in conduit?', 'answer' => 'At least 16 in long.'],
        ['question' => 'Angle pull with 2 in and two 1½ in conduits on a wall?', 'answer' => '6 × 2 + 1½ + 1½ = 15 in to the opposite wall.'],
        ['question' => 'Does this apply to small wires?', 'answer' => 'No: 314.28 applies to 4 AWG and larger; smaller conductors use box fill (314.16).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="pull" label="Pull" :options="['straight' => 'Straight', 'angle' => 'Angle', 'u' => 'U']" selected="angle" />
        <x-calc.field name="largest" label="Largest raceway" value="2" min="0" step="0.25" suffix="in" />
        <x-calc.field name="others" label="Other raceways on that wall" value="3" min="0" step="0.25" suffix="in total" />
    </div>

    <x-calc.result label="Minimum distance" />

    <x-calc.options :examples="[
        'Angle pull, 2 in + 3 in more' => ['pull' => 'angle', 'largest' => 2, 'others' => 3],
        'Straight pull, 3 in' => ['pull' => 'straight', 'largest' => 3, 'others' => 0],
        'U pull, 4 in' => ['pull' => 'u', 'largest' => 4, 'others' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'length' => ['label' => 'Minimum size'],
            'rule' => ['label' => 'Rule'],
            'spacing' => ['label' => 'Raceway spacing'],
            'note' => ['label' => 'Scope'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>straight: L ≥ 8 × largest</li>
            <li>angle or U: L ≥ 6 × largest + Σ others</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
