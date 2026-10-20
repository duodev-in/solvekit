<x-calc.page
    title="Cyclomatic Complexity Calculator - SolveKit"
    description="Free cyclomatic complexity calculator: McCabe's M = E − N + 2P from a control-flow graph, or decision points + 1."
    lede="Measure code complexity."
    about="Cyclomatic complexity counts the independent paths through code: M = E − N + 2P for a control-flow graph with E edges, N nodes and P components, or simply the number of decisions + 1. It is also the minimum number of tests for full branch coverage. Also known as McCabe complexity calculator."
    :calc="['engine' => 'mt-other', 'tool' => 'cyclomatic', 'fields' => ['mode', 'edges', 'nodes', 'parts', 'decisions']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'A graph has 9 edges and 8 nodes. What is M?', 'answer' => '3.'],
    ]"
>
    <x-calc.select name="mode" label="I know" :options="['graph' => 'Edges, nodes and components', 'decisions' => 'The number of decision points']" selected="graph" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:graph" hidden>
            <x-calc.field name="edges" label="Edges E" value="9" min="0" step="1" />
        </div>
        <div data-show-when="mode:graph" hidden>
            <x-calc.field name="nodes" label="Nodes N" value="8" min="0" step="1" />
        </div>
        <div data-show-when="mode:graph" hidden>
            <x-calc.field name="parts" label="Components P" value="1" min="1" step="1" />
        </div>
    </div>

    <div data-show-when="mode:decisions" hidden>
        <x-calc.field name="decisions" label="Decision points" value="4" min="0" step="1" />
    </div>

    <x-calc.result label="Cyclomatic complexity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'graph', 'edges' => 9, 'nodes' => 8, 'parts' => 1, 'decisions' => 4],
        'Decisions' => ['mode' => 'decisions', 'edges' => 9, 'nodes' => 8, 'parts' => 1, 'decisions' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'band' => ['label' => 'Risk'],
            'tests' => ['label' => 'Tests needed'],
            'rule' => ['label' => 'Guideline'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = E − N + 2P</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
