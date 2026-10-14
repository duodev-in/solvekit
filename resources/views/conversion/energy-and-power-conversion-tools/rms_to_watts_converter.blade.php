<x-tool-page-layout
    title="RMS to Watts Converter - SolveKit"
    description="Professional RMS to watts converter for AC power calculations. Convert RMS voltage and current to power for electrical engineering and power system analysis."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">RMS to Watts Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Calculation Method -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Method
                                                                                </label>
                                                                                <select 
                                                                                    id="calculationMethod" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="voltage_resistance" selected>Voltage & Resistance (P = V²/R)</option>
                                                                                    <option value="current_resistance">Current & Resistance (P = I²R)</option>
                                                                                    <option value="voltage_current">Voltage & Current (P = VI)</option>
                                                                                    <option value="impedance_power">Impedance & Power Factor</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Primary Input -->
                                                                            <div class="space-y-2" id="primaryInputContainer">
                                                                                <label for="primaryValue" class="block text-sm font-semibold text-gray-700" id="primaryLabel">
                                                                                    RMS Voltage (V)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="primaryValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter voltage (e.g., 120)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="primaryUnit">V</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="primaryHint">Enter RMS voltage value</p>
                                                                            </div>

                                                                            <!-- Secondary Input -->
                                                                            <div class="space-y-2" id="secondaryInputContainer">
                                                                                <label for="secondaryValue" class="block text-sm font-semibold text-gray-700" id="secondaryLabel">
                                                                                    Resistance (Ω)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="secondaryValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter resistance (e.g., 50)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="secondaryUnit">Ω</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="secondaryHint">Enter resistance value</p>
                                                                            </div>

                                                                            <!-- Power Factor (for impedance method) -->
                                                                            <div class="space-y-2" id="powerFactorContainer" style="display: none;">
                                                                                <label for="powerFactor" class="block text-sm font-semibold text-gray-700">
                                                                                    Power Factor (cos φ)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="powerFactor" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter power factor (0-1)"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                        max="1"
                                                                                        value="1"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">cos φ</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Power factor (1.0 for resistive load)</p>
                                                                            </div>

                                                                            <!-- Circuit Type -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Circuit Type
                                                                                </label>
                                                                                <select 
                                                                                    id="circuitType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="single_phase" selected>Single Phase AC</option>
                                                                                    <option value="three_phase_wye">Three Phase (Wye/Star)</option>
                                                                                    <option value="three_phase_delta">Three Phase (Delta)</option>
                                                                                    <option value="dc">DC Circuit</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Power Calculation Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Calculated Power</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Power result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-purple-600 hover:text-purple-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Power Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Power Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Power Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Watts</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="wattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Real power</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Kilowatts</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="kilowattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1000 watts</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Horsepower</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="horsepowerDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Mechanical equivalent</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Electrical Parameters -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Electrical Parameters</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">RMS Voltage</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="rmsVoltageDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Effective voltage</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">RMS Current</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="rmsCurrentDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Effective current</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Impedance</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="impedanceDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Circuit impedance</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- AC Power Analysis -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">AC Power Analysis</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Apparent Power</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="apparentPowerDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">VA (Volt-Amperes)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Reactive Power</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="reactivePowerDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">VAR (Reactive)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Power Factor</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="powerFactorDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">cos φ</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden">
                                                                                <!-- Formula Display -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border border-cyan-200">
                                                                                    <h4 class="text-sm font-semibold text-cyan-800 mb-2 text-center">Power Calculation Formula</h4>
                                                                                    <div class="text-sm text-cyan-700 text-center">
                                                                                        <div class="font-mono bg-white px-3 py-2 rounded border inline-block" id="formulaDisplay">
                                                                                            Select method to see formula
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Energy Consumption -->
                                                                                <div class="p-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg border border-amber-200">
                                                                                    <h4 class="text-sm font-semibold text-amber-800 mb-2 text-center">Energy Consumption</h4>
                                                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Per Hour:</span>
                                                                                            <span class="font-mono text-amber-700" id="energyHourDisplay">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Per Day:</span>
                                                                                            <span class="font-mono text-amber-700" id="energyDayDisplay">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Per Month:</span>
                                                                                            <span class="font-mono text-amber-700" id="energyMonthDisplay">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Annual Cost:</span>
                                                                                            <span class="font-mono text-amber-700" id="annualCostDisplay">--</span>
                                                                                        </div>
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
                <!-- Quick Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Power Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-method="voltage_resistance" data-primary="120" data-secondary="60">120V, 60Ω</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-method="current_resistance" data-primary="10" data-secondary="50">10A, 50Ω</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-method="voltage_current" data-primary="240" data-secondary="5">240V, 5A</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-method="voltage_resistance" data-primary="12" data-secondary="4">12V, 4Ω</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">RMS & Power Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>RMS</strong> = Root Mean Square</div>
                                                        <div><strong>P = V²/R</strong> (Voltage & Resistance)</div>
                                                        <div><strong>P = I²R</strong> (Current & Resistance)</div>
                                                        <div><strong>P = VI cos φ</strong> (AC Power)</div>
                                                        <div><strong>Household AC</strong> = 120V/240V RMS</div>
                                                        <div><strong>European AC</strong> = 230V RMS</div>
                                                        <div><strong>Industrial 3φ</strong> = 480V RMS</div>
                                                        <div><strong>RMS = Peak ÷ √2</strong></div>
                                                        <div><strong>Apparent Power</strong> = VI (VA)</div>
                                                        <div><strong>Real Power</strong> = VI cos φ (W)</div>
                                                        <div><strong>Reactive Power</strong> = VI sin φ (VAR)</div>
                                                        <div><strong>Power Factor</strong> = cos φ</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const calculationMethod = document.getElementById('calculationMethod');
                        const primaryValue = document.getElementById('primaryValue');
                        const secondaryValue = document.getElementById('secondaryValue');
                        const powerFactor = document.getElementById('powerFactor');
                        const circuitType = document.getElementById('circuitType');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Labels and containers
                        const primaryLabel = document.getElementById('primaryLabel');
                        const secondaryLabel = document.getElementById('secondaryLabel');
                        const primaryUnit = document.getElementById('primaryUnit');
                        const secondaryUnit = document.getElementById('secondaryUnit');
                        const primaryHint = document.getElementById('primaryHint');
                        const secondaryHint = document.getElementById('secondaryHint');
                        const powerFactorContainer = document.getElementById('powerFactorContainer');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const wattsDisplay = document.getElementById('wattsDisplay');
                        const kilowattsDisplay = document.getElementById('kilowattsDisplay');
                        const horsepowerDisplay = document.getElementById('horsepowerDisplay');
                        const rmsVoltageDisplay = document.getElementById('rmsVoltageDisplay');
                        const rmsCurrentDisplay = document.getElementById('rmsCurrentDisplay');
                        const impedanceDisplay = document.getElementById('impedanceDisplay');
                        const apparentPowerDisplay = document.getElementById('apparentPowerDisplay');
                        const reactivePowerDisplay = document.getElementById('reactivePowerDisplay');
                        const powerFactorDisplay = document.getElementById('powerFactorDisplay');
                        const formulaDisplay = document.getElementById('formulaDisplay');
                        const energyHourDisplay = document.getElementById('energyHourDisplay');
                        const energyDayDisplay = document.getElementById('energyDayDisplay');
                        const energyMonthDisplay = document.getElementById('energyMonthDisplay');
                        const annualCostDisplay = document.getElementById('annualCostDisplay');
                        const copyResult = document.getElementById('copyResult');

                        function formatNumber(num, decimals = 3) {
                            const absolute = Math.abs(num);
                            if (absolute >= 1e15 || (absolute < 1e-6 && num !== 0)) {
                                return num.toExponential(3).replace(/\.?0+e/, 'e');
                            } else if (absolute >= 1e6) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            } else if (absolute < 1 && num !== 0) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            } else {
                                return num.toLocaleString(undefined, { maximumFractionDigits: decimals, minimumFractionDigits: 0 });
                            }
                        }

                        function updateInputLabels() {
                            const method = calculationMethod.value;
                            
                            switch(method) {
                                case 'voltage_resistance':
                                    primaryLabel.textContent = 'RMS Voltage (V)';
                                    secondaryLabel.textContent = 'Resistance (Ω)';
                                    primaryUnit.textContent = 'V';
                                    secondaryUnit.textContent = 'Ω';
                                    primaryHint.textContent = 'Enter RMS voltage value';
                                    secondaryHint.textContent = 'Enter resistance value';
                                    powerFactorContainer.style.display = 'none';
                                    formulaDisplay.textContent = 'P = V² / R';
                                    break;
                                case 'current_resistance':
                                    primaryLabel.textContent = 'RMS Current (A)';
                                    secondaryLabel.textContent = 'Resistance (Ω)';
                                    primaryUnit.textContent = 'A';
                                    secondaryUnit.textContent = 'Ω';
                                    primaryHint.textContent = 'Enter RMS current value';
                                    secondaryHint.textContent = 'Enter resistance value';
                                    powerFactorContainer.style.display = 'none';
                                    formulaDisplay.textContent = 'P = I² × R';
                                    break;
                                case 'voltage_current':
                                    primaryLabel.textContent = 'RMS Voltage (V)';
                                    secondaryLabel.textContent = 'RMS Current (A)';
                                    primaryUnit.textContent = 'V';
                                    secondaryUnit.textContent = 'A';
                                    primaryHint.textContent = 'Enter RMS voltage value';
                                    secondaryHint.textContent = 'Enter RMS current value';
                                    powerFactorContainer.style.display = 'none';
                                    formulaDisplay.textContent = 'P = V × I';
                                    break;
                                case 'impedance_power':
                                    primaryLabel.textContent = 'RMS Voltage (V)';
                                    secondaryLabel.textContent = 'Impedance (Ω)';
                                    primaryUnit.textContent = 'V';
                                    secondaryUnit.textContent = 'Ω';
                                    primaryHint.textContent = 'Enter RMS voltage value';
                                    secondaryHint.textContent = 'Enter impedance value';
                                    powerFactorContainer.style.display = 'block';
                                    formulaDisplay.textContent = 'P = (V² / Z) × cos φ';
                                    break;
                            }
                        }

                        function getCalculationSummary(method, primary, secondary, pf, totalPower) {
                            const result = `${formatNumber(totalPower)} W`;

                            switch(method) {
                                case 'current_resistance':
                                    return `(${formatNumber(primary)} A)² × ${formatNumber(secondary)} Ω = ${result}`;
                                case 'voltage_current':
                                    return `${formatNumber(primary)} V × ${formatNumber(secondary)} A = ${result}`;
                                case 'impedance_power':
                                    return `(${formatNumber(primary)} V)² ÷ ${formatNumber(secondary)} Ω × ${formatNumber(pf, 2)} = ${result}`;
                                default:
                                    return `(${formatNumber(primary)} V)² ÷ ${formatNumber(secondary)} Ω = ${result}`;
                            }
                        }

                        function calculate() {
                            const method = calculationMethod.value;
                            const primary = parseFloat(primaryValue.value);
                            const secondary = parseFloat(secondaryValue.value);
                            const pf = parseFloat(powerFactor.value) || 1;
                            const circuit = circuitType.value;

                            if (!isNaN(primary) && !isNaN(secondary) && primary >= 0 && secondary > 0) {
                                let power = 0;
                                let voltage = 0;
                                let current = 0;
                                let impedance = 0;
                                
                                switch(method) {
                                    case 'voltage_resistance':
                                        voltage = primary;
                                        impedance = secondary;
                                        power = (voltage * voltage) / impedance;
                                        current = voltage / impedance;
                                        break;
                                    case 'current_resistance':
                                        current = primary;
                                        impedance = secondary;
                                        power = current * current * impedance;
                                        voltage = current * impedance;
                                        break;
                                    case 'voltage_current':
                                        voltage = primary;
                                        current = secondary;
                                        power = voltage * current;
                                        impedance = voltage / current;
                                        break;
                                    case 'impedance_power':
                                        voltage = primary;
                                        impedance = secondary;
                                        power = (voltage * voltage / impedance) * pf;
                                        current = voltage / impedance;
                                        break;
                                }

                                // Apply circuit type multiplier
                                let circuitMultiplier = 1;
                                switch(circuit) {
                                    case 'three_phase_wye':
                                    case 'three_phase_delta':
                                        circuitMultiplier = 3;
                                        break;
                                }
                                
                                const totalPower = power * circuitMultiplier;
                                
                                // Update primary output
                                output.textContent = formatNumber(totalPower) + ' W';
                                resultTitle.textContent = 'Real Power in Watts (W)';
                                resultDescription.textContent = getCalculationSummary(method, primary, secondary, pf, totalPower);

                                // Display power units
                                wattsDisplay.textContent = formatNumber(totalPower) + ' W';
                                kilowattsDisplay.textContent = formatNumber(totalPower / 1000) + ' kW';
                                horsepowerDisplay.textContent = formatNumber(totalPower / 745.7) + ' hp';

                                // Display electrical parameters
                                rmsVoltageDisplay.textContent = formatNumber(voltage) + ' V';
                                rmsCurrentDisplay.textContent = formatNumber(current) + ' A';
                                impedanceDisplay.textContent = formatNumber(impedance) + ' Ω';

                                // AC power analysis
                                const apparentPower = voltage * current * circuitMultiplier;
                                const reactivePower = Math.sqrt(Math.pow(apparentPower, 2) - Math.pow(totalPower, 2));
                                
                                apparentPowerDisplay.textContent = formatNumber(apparentPower) + ' VA';
                                reactivePowerDisplay.textContent = formatNumber(reactivePower) + ' VAR';
                                powerFactorDisplay.textContent = formatNumber(pf, 2);

                                // Energy consumption (assuming $0.12/kWh)
                                const kWh = totalPower / 1000;
                                energyHourDisplay.textContent = formatNumber(kWh) + ' kWh';
                                energyDayDisplay.textContent = formatNumber(kWh * 24) + ' kWh';
                                energyMonthDisplay.textContent = formatNumber(kWh * 24 * 30) + ' kWh';
                                annualCostDisplay.textContent = '$' + formatNumber(kWh * 24 * 365 * 0.12, 0);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Calculated Power';
                            resultDescription.textContent = 'Power result';
                            wattsDisplay.textContent = '--';
                            kilowattsDisplay.textContent = '--';
                            horsepowerDisplay.textContent = '--';
                            rmsVoltageDisplay.textContent = '--';
                            rmsCurrentDisplay.textContent = '--';
                            impedanceDisplay.textContent = '--';
                            apparentPowerDisplay.textContent = '--';
                            reactivePowerDisplay.textContent = '--';
                            powerFactorDisplay.textContent = '--';
                            energyHourDisplay.textContent = '--';
                            energyDayDisplay.textContent = '--';
                            energyMonthDisplay.textContent = '--';
                            annualCostDisplay.textContent = '--';
                        }

                        function clearAll() {
                            primaryValue.value = '';
                            secondaryValue.value = '';
                            powerFactor.value = '1';
                            calculationMethod.value = 'voltage_resistance';
                            circuitType.value = 'single_phase';
                            updateInputLabels();
                            clearOutputs();
                            primaryValue.focus();
                        }

                        // Event listeners
                        calculationMethod.addEventListener('change', function() {
                            updateInputLabels();
                            calculate();
                        });
                        
                        primaryValue.addEventListener('input', calculate);
                        secondaryValue.addEventListener('input', calculate);
                        powerFactor.addEventListener('input', calculate);
                        circuitType.addEventListener('change', calculate);

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
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

                        // Example buttons
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const method = this.getAttribute('data-method');
                                const primary = this.getAttribute('data-primary');
                                const secondary = this.getAttribute('data-secondary');
                                
                                calculationMethod.value = method;
                                primaryValue.value = primary;
                                secondaryValue.value = secondary;
                                updateInputLabels();
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
                            });
                        });

                        // Initialize
                        updateInputLabels();
                        primaryValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
