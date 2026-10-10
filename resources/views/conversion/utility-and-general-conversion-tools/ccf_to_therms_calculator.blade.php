<x-tool-page-layout
    title="CCF to Therms Calculator - SolveKit"
    description="Professional CCF to therms calculator for gas volume to energy conversion. Convert hundred cubic feet to therms for utility billing and energy consumption analysis."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">CCF to Therms Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <select 
                                                                                    id="conversionDirection" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="ccf_to_therms" selected>CCF to Therms</option>
                                                                                    <option value="therms_to_ccf">Therms to CCF</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    CCF Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter gas volume (e.g., 100)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">CCF</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHint">Enter hundred cubic feet value</p>
                                                                            </div>

                                                                            <!-- Gas Type/Quality -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Gas Type
                                                                                </label>
                                                                                <select 
                                                                                    id="gasType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="standard" selected>Standard Natural Gas (1.037 Therms/CCF)</option>
                                                                                    <option value="high_heating">High Heating Value Gas (1.10 Therms/CCF)</option>
                                                                                    <option value="low_heating">Low Heating Value Gas (0.95 Therms/CCF)</option>
                                                                                    <option value="propane">Propane (2.5 Therms/CCF)</option>
                                                                                    <option value="custom">Custom Heating Value</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Heating Value -->
                                                                            <div class="space-y-2" id="customHeatingContainer" style="display: none;">
                                                                                <label for="customHeating" class="block text-sm font-semibold text-gray-700">
                                                                                    Heating Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customHeating" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter heating value"
                                                                                        step="0.001"
                                                                                        min="0"
                                                                                        value="1.037"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Therms/CCF</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Custom heating value ratio</p>
                                                                            </div>

                                                                            <!-- Gas Price (optional) -->
                                                                            <div class="space-y-2">
                                                                                <label for="gasPrice" class="block text-sm font-semibold text-gray-700">
                                                                                    Gas Price (Optional)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="gasPrice" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Price per therm (e.g., 1.25)"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">$/therm</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">For cost calculation (leave blank to skip)</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Gas Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Value</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Conversion result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Gas Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Volume Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Volume Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">CCF</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="ccfDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Hundred cubic feet</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cubic Feet</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="cubicFeetDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Total cubic feet</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cubic Meters</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="cubicMetersDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI volume unit</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Energy Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Energy Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Therms</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="thermsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Energy content</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">BTU</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="btuDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">British thermal units</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">kWh</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="kwhDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilowatt hours</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Cost Analysis -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Cost Analysis</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Total Cost</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="totalCostDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Based on price per therm</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg border-l-4 border-amber-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cost per CCF</h5>
                                                                                            <div class="text-lg font-bold text-amber-600 font-mono" id="costPerCcfDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Price per hundred cubic feet</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Monthly Avg</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="monthlyAvgDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Average monthly cost</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Gas Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Gas Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="100" data-direction="ccf_to_therms">100 CCF</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="50" data-direction="ccf_to_therms">50 CCF</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="100" data-direction="therms_to_ccf">100 therms</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="200" data-direction="ccf_to_therms">200 CCF</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Gas Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 CCF</strong> = 100 cubic feet</div>
                                                        <div><strong>1 Therm</strong> = 100,000 BTU</div>
                                                        <div><strong>Standard gas</strong> = 1.037 Therms/CCF</div>
                                                        <div><strong>1 CCF</strong> = 2.83 cubic meters</div>
                                                        <div><strong>1 Therm</strong> = 29.3 kWh</div>
                                                        <div><strong>Propane</strong> = 2.5 Therms/CCF</div>
                                                        <div><strong>Average home</strong> = 80-100 Therms/month</div>
                                                        <div><strong>Heating season</strong> = Oct-Apr peak usage</div>
                                                        <div><strong>1 MCF</strong> = 10 CCF</div>
                                                        <div><strong>STP conditions</strong> = 60°F, 14.73 psia</div>
                                                        <div><strong>HHV</strong> = Higher heating value</div>
                                                        <div><strong>LHV</strong> = Lower heating value</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const conversionDirection = document.getElementById('conversionDirection');
                        const inputValue = document.getElementById('inputValue');
                        const gasType = document.getElementById('gasType');
                        const customHeating = document.getElementById('customHeating');
                        const gasPrice = document.getElementById('gasPrice');
                        const clearButton = document.getElementById('clearButton');

                        // Container elements
                        const customHeatingContainer = document.getElementById('customHeatingContainer');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const inputHint = document.getElementById('inputHint');

                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const ccfDisplay = document.getElementById('ccfDisplay');
                        const cubicFeetDisplay = document.getElementById('cubicFeetDisplay');
                        const cubicMetersDisplay = document.getElementById('cubicMetersDisplay');
                        const thermsDisplay = document.getElementById('thermsDisplay');
                        const btuDisplay = document.getElementById('btuDisplay');
                        const kwhDisplay = document.getElementById('kwhDisplay');
                        const totalCostDisplay = document.getElementById('totalCostDisplay');
                        const costPerCcfDisplay = document.getElementById('costPerCcfDisplay');
                        const monthlyAvgDisplay = document.getElementById('monthlyAvgDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Gas heating values (therms per CCF)
                        const gasHeatingValues = {
                            standard: 1.037,
                            high_heating: 1.10,
                            low_heating: 0.95,
                            propane: 2.5,
                            custom: 1.037
                        };

                        function formatNumber(num, decimals = 3) {
                            if (num === 0) {
                                return '0';
                            }

                            const absolute = Math.abs(num);

                            if (absolute >= 1e15 || absolute < 1e-6) {
                                return num.toExponential(3);
                            }

                            if (absolute < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return num.toLocaleString(undefined, { maximumFractionDigits: decimals });
                        }

                        function formatCurrency(amount) {
                            return '$' + amount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }

                        function updateInputLabels() {
                            if (conversionDirection.value === 'therms_to_ccf') {
                                inputLabel.textContent = 'Therms Value';
                                inputUnit.textContent = 'therms';
                                inputHint.textContent = 'Enter the energy in therms';
                            } else {
                                inputLabel.textContent = 'CCF Value';
                                inputUnit.textContent = 'CCF';
                                inputHint.textContent = 'Enter hundred cubic feet value';
                            }
                        }

                        function updateCustomHeatingVisibility() {
                            customHeatingContainer.style.display = gasType.value === 'custom' ? 'block' : 'none';
                        }

                        function getHeatingValue() {
                            if (gasType.value === 'custom') {
                                const customValue = parseFloat(customHeating.value);

                                return customValue > 0 ? customValue : 1.037;
                            }

                            return gasHeatingValues[gasType.value] || 1.037;
                        }

                        function calculate() {
                            const direction = conversionDirection.value;
                            const value = parseFloat(inputValue.value);
                            const heatingValue = getHeatingValue();
                            const price = parseFloat(gasPrice.value) || 0;

                            if (isNaN(value) || value < 0) {
                                clearOutputs();
                                return;
                            }

                            const ccf = direction === 'therms_to_ccf' ? value / heatingValue : value;
                            const therms = direction === 'therms_to_ccf' ? value : value * heatingValue;
                            const totalCost = therms * price;
                            const costSuffix = price > 0 ? ` (estimated cost ${formatCurrency(totalCost)})` : '';

                            if (direction === 'therms_to_ccf') {
                                output.textContent = formatNumber(ccf) + ' CCF';
                                resultTitle.textContent = 'CCF';
                                resultDescription.textContent = `${formatNumber(value)} ${value === 1 ? 'therm' : 'therms'} = ${formatNumber(ccf)} CCF${costSuffix}`;
                            } else {
                                output.textContent = formatNumber(therms) + ' therms';
                                resultTitle.textContent = 'Therms';
                                resultDescription.textContent = `${formatNumber(value)} CCF = ${formatNumber(therms)} ${therms === 1 ? 'therm' : 'therms'}${costSuffix}`;
                            }

                            ccfDisplay.textContent = formatNumber(ccf) + ' CCF';
                            cubicFeetDisplay.textContent = formatNumber(ccf * 100) + ' ft³';
                            cubicMetersDisplay.textContent = formatNumber(ccf * 2.83168) + ' m³';
                            thermsDisplay.textContent = formatNumber(therms) + ' therms';
                            btuDisplay.textContent = formatNumber(therms * 100000) + ' BTU';
                            kwhDisplay.textContent = formatNumber(therms * 29.3071) + ' kWh';

                            if (price > 0) {
                                totalCostDisplay.textContent = formatCurrency(totalCost);
                                costPerCcfDisplay.textContent = formatCurrency(heatingValue * price);
                                monthlyAvgDisplay.textContent = formatCurrency(totalCost);
                            } else {
                                totalCostDisplay.textContent = 'Enter price';
                                costPerCcfDisplay.textContent = 'Enter price';
                                monthlyAvgDisplay.textContent = 'Enter price';
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = conversionDirection.value === 'therms_to_ccf' ? 'CCF' : 'Therms';
                            resultDescription.textContent = 'Enter a value to convert';
                            [ccfDisplay, cubicFeetDisplay, cubicMetersDisplay, thermsDisplay, btuDisplay, kwhDisplay, totalCostDisplay, costPerCcfDisplay, monthlyAvgDisplay].forEach(element => {
                                element.textContent = '--';
                            });
                        }

                        function clearAll() {
                            inputValue.value = '';
                            conversionDirection.value = 'ccf_to_therms';
                            gasType.value = 'standard';
                            customHeating.value = '1.037';
                            gasPrice.value = '';
                            updateInputLabels();
                            updateCustomHeatingVisibility();
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        conversionDirection.addEventListener('change', function() {
                            updateInputLabels();
                            calculate();
                        });

                        inputValue.addEventListener('input', calculate);

                        gasType.addEventListener('change', function() {
                            updateCustomHeatingVisibility();
                            calculate();
                        });

                        customHeating.addEventListener('input', calculate);
                        gasPrice.addEventListener('input', calculate);
                        clearButton.addEventListener('click', clearAll);

                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                inputValue.value = this.getAttribute('data-value');
                                conversionDirection.value = this.getAttribute('data-direction');
                                updateInputLabels();
                                calculate();

                                exampleBtns.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
                            });
                        });

                        // Initialize
                        updateInputLabels();
                        updateCustomHeatingVisibility();
                        clearOutputs();
                        inputValue.focus();

                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
