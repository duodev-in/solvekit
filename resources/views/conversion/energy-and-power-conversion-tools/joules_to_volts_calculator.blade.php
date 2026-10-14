<x-tool-page-layout
    title="Joules to Volts Calculator - SolveKit"
    description="Professional joules to volts calculator for energy to electrical potential conversion. Calculate voltage from energy and charge for electrical engineering applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Joules to Volts Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                            <!-- Energy Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="energyValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Energy Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="energyValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter energy (e.g., 10)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Energy</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter energy value for conversion</p>
                                                                            </div>

                                                                            <!-- Energy Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="energyUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Energy Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="energyUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="joule" selected>Joule (J)</option>
                                                                                    <option value="kilojoule">Kilojoule (kJ)</option>
                                                                                    <option value="watt_hour">Watt Hour (Wh)</option>
                                                                                    <option value="kilowatt_hour">Kilowatt Hour (kWh)</option>
                                                                                    <option value="calorie">Calorie (cal)</option>
                                                                                    <option value="btu">BTU</option>
                                                                                    <option value="erg">Erg</option>
                                                                                    <option value="electron_volt">Electron Volt (eV)</option>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                            <!-- Charge Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="chargeValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Charge Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="chargeValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter charge (e.g., 1)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Charge</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter charge value (required for voltage calculation)</p>
                                                                            </div>

                                                                            <!-- Charge Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="chargeUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Charge Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="chargeUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="coulomb" selected>Coulomb (C)</option>
                                                                                    <option value="millicoulomb">Millicoulomb (mC)</option>
                                                                                    <option value="microcoulomb">Microcoulomb (μC)</option>
                                                                                    <option value="nanocoulomb">Nanocoulomb (nC)</option>
                                                                                    <option value="ampere_hour">Ampere Hour (Ah)</option>
                                                                                    <option value="milliampere_hour">Milliampere Hour (mAh)</option>
                                                                                    <option value="elementary_charge">Elementary Charge (e)</option>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <!-- Application Context -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Application Context
                                                                                </label>
                                                                                <select 
                                                                                    id="applicationContext" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">General calculation</option>
                                                                                    <option value="battery">Battery Systems</option>
                                                                                    <option value="capacitor">Capacitor Energy</option>
                                                                                    <option value="electric_field">Electric Field Work</option>
                                                                                    <option value="electronics">Electronics Design</option>
                                                                                    <option value="physics">Physics Problems</option>
                                                                                    <option value="power_systems">Power Systems</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Voltage Calculation Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Calculated Voltage</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Voltage result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-yellow-600 hover:text-yellow-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Voltage Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Common Voltages -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Common Voltages</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Volts</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="voltsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Standard voltage</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Millivolts</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="millivoltsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Small signals</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Kilovolts</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="kilovoltsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">High voltage</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Electrical Parameters -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Electrical Parameters</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Energy</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="energyJoulesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Joules</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Charge</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="chargeCoulombsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Coulombs</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Power Density</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="powerDensityDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">J/C (V)</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Applications -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Applications</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Battery Type</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="batteryTypeDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Typical battery</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Logic Level</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="logicLevelDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Digital logic</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Safety Class</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="safetyClassDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Electrical safety</div>
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
                                                            Quick Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-energy="12" data-energy-unit="joule" data-charge="1" data-charge-unit="coulomb">12V Battery</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-energy="5" data-energy-unit="joule" data-charge="1" data-charge-unit="coulomb">5V Logic</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-energy="3.3" data-energy-unit="joule" data-charge="1" data-charge-unit="coulomb">3.3V MCU</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-energy="1.5" data-energy-unit="electron_volt" data-charge="1" data-charge-unit="elementary_charge">1.5 eV</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Electrical Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Volt</strong> = 1 J/C</div>
                                                        <div><strong>Elementary charge</strong> = 1.602×10⁻¹⁹ C</div>
                                                        <div><strong>1 eV</strong> = 1.602×10⁻¹⁹ J</div>
                                                        <div><strong>AA battery</strong> ≈ 1.5V</div>
                                                        <div><strong>Car battery</strong> ≈ 12V</div>
                                                        <div><strong>Household AC</strong> ≈ 120V/240V</div>
                                                        <div><strong>High voltage</strong> > 1000V</div>
                                                        <div><strong>Logic low</strong> ≈ 0-0.8V</div>
                                                        <div><strong>Logic high</strong> ≈ 2-5V</div>
                                                        <div><strong>USB power</strong> = 5V</div>
                                                        <div><strong>Lightning</strong> ≈ 100MV</div>
                                                        <div><strong>Neural signal</strong> ≈ 70mV</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const energyValue = document.getElementById('energyValue');
                        const energyUnit = document.getElementById('energyUnit');
                        const chargeValue = document.getElementById('chargeValue');
                        const chargeUnit = document.getElementById('chargeUnit');
                        const applicationContext = document.getElementById('applicationContext');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const voltsDisplay = document.getElementById('voltsDisplay');
                        const millivoltsDisplay = document.getElementById('millivoltsDisplay');
                        const kilovoltsDisplay = document.getElementById('kilovoltsDisplay');
                        const energyJoulesDisplay = document.getElementById('energyJoulesDisplay');
                        const chargeCoulombsDisplay = document.getElementById('chargeCoulombsDisplay');
                        const powerDensityDisplay = document.getElementById('powerDensityDisplay');
                        const batteryTypeDisplay = document.getElementById('batteryTypeDisplay');
                        const logicLevelDisplay = document.getElementById('logicLevelDisplay');
                        const safetyClassDisplay = document.getElementById('safetyClassDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Conversion factors to base units
                        const energyToJoules = {
                            joule: 1,
                            kilojoule: 1000,
                            watt_hour: 3600,
                            kilowatt_hour: 3600000,
                            calorie: 4.184,
                            btu: 1055.06,
                            erg: 1e-7,
                            electron_volt: 1.602176634e-19
                        };

                        const chargeToCoulombs = {
                            coulomb: 1,
                            millicoulomb: 0.001,
                            microcoulomb: 1e-6,
                            nanocoulomb: 1e-9,
                            ampere_hour: 3600,
                            milliampere_hour: 3.6,
                            elementary_charge: 1.602176634e-19
                        };

                        const energySymbols = {
                            joule: 'J',
                            kilojoule: 'kJ',
                            watt_hour: 'Wh',
                            kilowatt_hour: 'kWh',
                            calorie: 'cal',
                            btu: 'BTU',
                            erg: 'erg',
                            electron_volt: 'eV'
                        };

                        const chargeSymbols = {
                            coulomb: 'C',
                            millicoulomb: 'mC',
                            microcoulomb: 'μC',
                            nanocoulomb: 'nC',
                            ampere_hour: 'Ah',
                            milliampere_hour: 'mAh',
                            elementary_charge: 'e'
                        };

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

                        function getBatteryType(voltage) {
                            if (voltage < 0.001) return 'Ultra-low voltage';
                            if (voltage < 0.1) return 'Signal level';
                            if (voltage < 1.0) return 'Logic level';
                            if (voltage < 2.0) return 'AA/AAA battery';
                            if (voltage < 6.0) return 'Small battery';
                            if (voltage < 15.0) return 'Car battery';
                            if (voltage < 50.0) return 'Low voltage';
                            if (voltage < 1000) return 'Medium voltage';
                            return 'High voltage';
                        }

                        function getLogicLevel(voltage) {
                            if (voltage < 0.8) return 'Logic LOW';
                            if (voltage < 2.0) return 'Undefined';
                            if (voltage < 5.5) return 'Logic HIGH';
                            if (voltage < 12.0) return 'TTL/CMOS';
                            return 'Power level';
                        }

                        function getSafetyClass(voltage) {
                            if (voltage < 12) return 'Extra low voltage';
                            if (voltage < 50) return 'Low voltage';
                            if (voltage < 1000) return 'Medium voltage';
                            if (voltage < 35000) return 'High voltage';
                            return 'Extra high voltage';
                        }

                        function calculate() {
                            const energy = parseFloat(energyValue.value);
                            const charge = parseFloat(chargeValue.value);
                            const eUnit = energyUnit.value;
                            const cUnit = chargeUnit.value;

                            if (!isNaN(energy) && !isNaN(charge) && energy >= 0 && charge > 0) {
                                // Convert to base units
                                const energyJoules = energy * energyToJoules[eUnit];
                                const chargeCoulombs = charge * chargeToCoulombs[cUnit];
                                
                                // Calculate voltage: V = E / Q
                                const voltage = energyJoules / chargeCoulombs;
                                
                                // Update primary output
                                output.textContent = formatNumber(voltage) + ' V';
                                resultTitle.textContent = 'Voltage (V)';
                                resultDescription.textContent = `${energy} ${energySymbols[eUnit]} ÷ ${charge} ${chargeSymbols[cUnit]} = ${formatNumber(voltage)} V`;

                                // Display in different voltage units
                                voltsDisplay.textContent = formatNumber(voltage) + ' V';
                                millivoltsDisplay.textContent = formatNumber(voltage * 1000) + ' mV';
                                kilovoltsDisplay.textContent = formatNumber(voltage / 1000) + ' kV';

                                // Display electrical parameters
                                energyJoulesDisplay.textContent = formatNumber(energyJoules) + ' J';
                                chargeCoulombsDisplay.textContent = formatNumber(chargeCoulombs) + ' C';
                                powerDensityDisplay.textContent = formatNumber(voltage) + ' J/C';

                                // Applications
                                batteryTypeDisplay.textContent = getBatteryType(voltage);
                                logicLevelDisplay.textContent = getLogicLevel(voltage);
                                safetyClassDisplay.textContent = getSafetyClass(voltage);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Calculated Voltage';
                            resultDescription.textContent = 'Voltage result';
                            voltsDisplay.textContent = '--';
                            millivoltsDisplay.textContent = '--';
                            kilovoltsDisplay.textContent = '--';
                            energyJoulesDisplay.textContent = '--';
                            chargeCoulombsDisplay.textContent = '--';
                            powerDensityDisplay.textContent = '--';
                            batteryTypeDisplay.textContent = '--';
                            logicLevelDisplay.textContent = '--';
                            safetyClassDisplay.textContent = '--';
                        }

                        function clearAll() {
                            energyValue.value = '';
                            energyUnit.value = 'joule';
                            chargeValue.value = '';
                            chargeUnit.value = 'coulomb';
                            applicationContext.value = '';
                            clearOutputs();
                            energyValue.focus();
                        }

                        // Event listeners
                        energyValue.addEventListener('input', calculate);
                        energyUnit.addEventListener('change', calculate);
                        chargeValue.addEventListener('input', calculate);
                        chargeUnit.addEventListener('change', calculate);
                        applicationContext.addEventListener('change', calculate);

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
                                const energy = this.getAttribute('data-energy');
                                const eUnit = this.getAttribute('data-energy-unit');
                                const charge = this.getAttribute('data-charge');
                                const cUnit = this.getAttribute('data-charge-unit');
                                
                                energyValue.value = energy;
                                energyUnit.value = eUnit;
                                chargeValue.value = charge;
                                chargeUnit.value = cUnit;
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
                            });
                        });

                        // Initialize
                        energyValue.focus();

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
