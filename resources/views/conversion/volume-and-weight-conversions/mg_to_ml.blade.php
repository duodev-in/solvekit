<x-tool-page-layout
    title="mg to mL Converter - SolveKit"
    description="Professional mg to mL converter for concentration-based calculations. Convert between weight and volume using substance concentration values."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">mg to mL</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Substance Type Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="substanceType" class="block text-sm font-semibold text-slate-700">
                                                                                    Substance Type
                                                                                </label>
                                                                                <select 
                                                                                    id="substanceType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option selected disabled>Select substance type</option>
                                                                                    <option value="common-liquids">Common Liquids</option>
                                                                                    <option value="solutions">Laboratory Solutions</option>
                                                                                    <option value="custom">Custom Concentration</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Common Liquids Field -->
                                                                            <div id="commonLiquidsField" class="space-y-2 hidden">
                                                                                <label for="commonLiquid" class="block text-sm font-semibold text-slate-700">
                                                                                    Select Liquid
                                                                                </label>
                                                                                <select 
                                                                                    id="commonLiquid" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option selected disabled>Select liquid</option>
                                                                                    <option value="1000">Water (1000 mg/mL)</option>
                                                                                    <option value="1030">Milk (1030 mg/mL)</option>
                                                                                    <option value="920">Cooking oil (920 mg/mL)</option>
                                                                                    <option value="1420">Honey (1420 mg/mL)</option>
                                                                                    <option value="1370">Maple syrup (1370 mg/mL)</option>
                                                                                    <option value="790">Ethanol (790 mg/mL)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Laboratory Solutions Field -->
                                                                            <div id="solutionsField" class="space-y-2 hidden">
                                                                                <label for="solution" class="block text-sm font-semibold text-slate-700">
                                                                                    Select Solution
                                                                                </label>
                                                                                <select 
                                                                                    id="solution" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option selected disabled>Select solution</option>
                                                                                    <option value="10">10% Solution (100 mg/mL)</option>
                                                                                    <option value="25">25% Solution (250 mg/mL)</option>
                                                                                    <option value="50">50% Solution (500 mg/mL)</option>
                                                                                    <option value="75">75% Solution (750 mg/mL)</option>
                                                                                    <option value="100">Pure substance (1000 mg/mL)</option>
                                                                                    <option value="custom-solution">Custom solution</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Concentration Field -->
                                                                            <div id="customField" class="space-y-2 hidden">
                                                                                <label for="customConcentration" class="block text-sm font-semibold text-slate-700">
                                                                                    Custom Concentration
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customConcentration" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter concentration (e.g., 75)"
                                                                                        step="any"
                                                                                        min="0.001"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">mg/mL</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Current Concentration Display -->
                                                                            <div class="p-3 bg-pink-50 rounded-lg border border-pink-200">
                                                                                <div class="flex items-center justify-between">
                                                                                    <span class="text-sm font-semibold text-pink-800">Current Concentration:</span>
                                                                                    <span class="text-lg font-bold text-pink-700" id="concentrationDisplay">-- mg/mL</span>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Values -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="space-y-2">
                                                                                    <label for="mgInput" class="block text-sm font-semibold text-slate-700">
                                                                                        Weight
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="mgInput" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                            placeholder="Enter weight (e.g., 100)"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium">mg</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="space-y-2">
                                                                                    <label for="mlInput" class="block text-sm font-semibold text-slate-700">
                                                                                        Volume
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="mlInput" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                            placeholder="Enter volume (e.g., 5)"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium">mL</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Bidirectional Results -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Weight</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mgOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">mg</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Volume</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mlOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">mL</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Volume Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Liters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="litersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Fluid Ounces</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="flOzOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Teaspoons</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="tspOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Step-by-Step Calculation -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-2 text-center">Calculation Steps</h4>
                                                                                <div class="text-center text-[11px] text-slate-500 font-mono" id="calculationSteps">
                                                                                    Enter values to see calculation steps
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-sm font-semibold text-slate-700 mb-2">Conversion Formula</h4>
                        <div class="text-[11px] text-slate-500 font-mono" id="formulaDisplay">
                            Volume (mL) = Weight (mg) ÷ Concentration (mg/mL)
                        </div>
                    </div>
                </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Concentration Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• Water: 1000 mg/mL</div>
                                                        <div>• 10% solution: 100 mg/mL</div>
                                                        <div>• 50% solution: 500 mg/mL</div>
                                                        <div>• Pure substance: 1000 mg/mL</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About mg to mL Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Concentration-Based Conversion</h4>
                                    <p>Converting between milligrams (weight) and milliliters (volume) requires knowing the substance's concentration or density. Different substances have different concentrations, so the same weight can occupy different volumes.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Essential for laboratory work, solution preparation, quality control, manufacturing processes, and any application where precise weight-to-volume conversions are needed based on substance concentration.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Important Note:</strong> Concentration values may vary with temperature and purity. Use appropriate values for your specific application!
                                </p>
                            </div>
                        </div>

                        <!-- Common Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Conversion Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water Sample</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="common-liquids" data-liquid="1000" data-mg="100">100 mg</div>
                                    <div class="text-[11px] text-slate-500">0.1 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">50% Solution</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="solutions" data-solution="50" data-mg="250">250 mg</div>
                                    <div class="text-[11px] text-slate-500">0.5 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Honey Sample</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="common-liquids" data-liquid="1420" data-mg="710">710 mg</div>
                                    <div class="text-[11px] text-slate-500">0.5 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Oil Sample</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="common-liquids" data-liquid="920" data-mg="460">460 mg</div>
                                    <div class="text-[11px] text-slate-500">0.5 mL</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const substanceType = document.getElementById('substanceType');
                        const commonLiquidsField = document.getElementById('commonLiquidsField');
                        const solutionsField = document.getElementById('solutionsField');
                        const customField = document.getElementById('customField');
                        const commonLiquid = document.getElementById('commonLiquid');
                        const solution = document.getElementById('solution');
                        const customConcentration = document.getElementById('customConcentration');
                        const concentrationDisplay = document.getElementById('concentrationDisplay');
                        const mgInput = document.getElementById('mgInput');
                        const mlInput = document.getElementById('mlInput');
                        const clearButton = document.getElementById('clearButton');
                        const mgOutput = document.getElementById('mgOutput');
                        const mlOutput = document.getElementById('mlOutput');
                        const litersOutput = document.getElementById('litersOutput');
                        const flOzOutput = document.getElementById('flOzOutput');
                        const tspOutput = document.getElementById('tspOutput');
                        const calculationSteps = document.getElementById('calculationSteps');

                        let currentConcentration = 1;

                        function formatNumber(num) {
                            if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function updateConcentration() {
                            const type = substanceType.value;

                            // Hide all fields
                            commonLiquidsField.classList.add('hidden');
                            solutionsField.classList.add('hidden');
                            customField.classList.add('hidden');

                            if (type === 'common-liquids') {
                                commonLiquidsField.classList.remove('hidden');
                                const liquidValue = commonLiquid.value;
                                if (liquidValue && liquidValue !== 'Select liquid') {
                                    currentConcentration = parseFloat(liquidValue);
                                }
                            } else if (type === 'solutions') {
                                solutionsField.classList.remove('hidden');
                                const solutionValue = solution.value;
                                if (solutionValue === 'custom-solution') {
                                    customField.classList.remove('hidden');
                                    currentConcentration = parseFloat(customConcentration.value) || 1;
                                } else if (solutionValue && solutionValue !== 'Select solution') {
                                    // Convert percentage to mg/mL (assuming water base)
                                    currentConcentration = parseFloat(solutionValue) * 10;
                                }
                            } else if (type === 'custom') {
                                customField.classList.remove('hidden');
                                currentConcentration = parseFloat(customConcentration.value) || 1;
                            }

                            concentrationDisplay.textContent = formatNumber(currentConcentration) + ' mg/mL';
                        }

                        function convertFromMg() {
                            const mg = parseFloat(mgInput.value);
                            if (!isNaN(mg) && currentConcentration > 0) {
                                const ml = mg / currentConcentration;
                                mlInput.value = formatNumber(ml);
                                updateOutputs(mg, ml);
                                updateCalculationSteps(mg, ml, 'mg-to-ml');
                            } else {
                                clearOutputs();
                            }
                        }

                        function convertFromMl() {
                            const ml = parseFloat(mlInput.value);
                            if (!isNaN(ml) && currentConcentration > 0) {
                                const mg = ml * currentConcentration;
                                mgInput.value = formatNumber(mg);
                                updateOutputs(mg, ml);
                                updateCalculationSteps(mg, ml, 'ml-to-mg');
                            } else {
                                clearOutputs();
                            }
                        }

                        function updateOutputs(mg, ml) {
                            mgOutput.textContent = formatNumber(mg);
                            mlOutput.textContent = formatNumber(ml);
                            
                            // Additional conversions
                            const liters = ml / 1000;
                            const flOz = ml * 0.033814;
                            const tsp = ml * 0.202884;

                            litersOutput.textContent = formatNumber(liters) + ' L';
                            flOzOutput.textContent = formatNumber(flOz) + ' fl oz';
                            tspOutput.textContent = formatNumber(tsp) + ' tsp';
                        }

                        function updateCalculationSteps(mg, ml, direction) {
                            if (direction === 'mg-to-ml') {
                                calculationSteps.textContent = `${formatNumber(mg)} mg ÷ ${formatNumber(currentConcentration)} mg/mL = ${formatNumber(ml)} mL`;
                            } else {
                                calculationSteps.textContent = `${formatNumber(ml)} mL × ${formatNumber(currentConcentration)} mg/mL = ${formatNumber(mg)} mg`;
                            }
                        }

                        function clearOutputs() {
                            mgOutput.textContent = '--';
                            mlOutput.textContent = '--';
                            litersOutput.textContent = '--';
                            flOzOutput.textContent = '--';
                            tspOutput.textContent = '--';
                            calculationSteps.textContent = 'Enter values to see calculation steps';
                        }

                        function clearAll() {
                            mgInput.value = '';
                            mlInput.value = '';
                            substanceType.selectedIndex = 0;
                            commonLiquid.selectedIndex = 0;
                            solution.selectedIndex = 0;
                            customConcentration.value = '';
                            commonLiquidsField.classList.add('hidden');
                            solutionsField.classList.add('hidden');
                            customField.classList.add('hidden');
                            currentConcentration = 1;
                            concentrationDisplay.textContent = '-- mg/mL';
                            clearOutputs();
                            mgInput.focus();
                        }

                        // Event listeners
                        substanceType.addEventListener('change', () => {
                            updateConcentration();
                            convertFromMg();
                        });

                        commonLiquid.addEventListener('change', () => {
                            updateConcentration();
                            convertFromMg();
                        });

                        solution.addEventListener('change', () => {
                            updateConcentration();
                            convertFromMg();
                        });

                        customConcentration.addEventListener('input', () => {
                            updateConcentration();
                            convertFromMg();
                        });

                        mgInput.addEventListener('input', convertFromMg);
                        mlInput.addEventListener('input', convertFromMl);
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-substance]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const substance = this.getAttribute('data-substance');
                                const liquid = this.getAttribute('data-liquid');
                                const solutionVal = this.getAttribute('data-solution');
                                const mg = this.getAttribute('data-mg');
                                
                                substanceType.value = substance;
                                updateConcentration();
                                
                                if (substance === 'common-liquids' && liquid) {
                                    commonLiquid.value = liquid;
                                } else if (substance === 'solutions' && solutionVal) {
                                    solution.value = solutionVal;
                                }
                                
                                updateConcentration();
                                mgInput.value = mg;
                                convertFromMg();
                                mgInput.focus();
                            });
                        });

                        // Initialize
                        mgInput.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            }
                        });

                        // Initialize outputs
                        clearOutputs();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
