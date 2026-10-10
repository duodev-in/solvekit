<x-tool-page-layout
    title="Nm to Joules Calculator - SolveKit"
    description="Professional newton-meter to joules calculator for torque to energy conversion. Calculate rotational energy from torque and angular displacement for mechanical engineering."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Nm to Joules Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                            <!-- Torque Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="torqueValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Torque Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="torqueValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter torque (e.g., 100)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Torque</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter torque value for energy calculation</p>
                                                                            </div>

                                                                            <!-- Torque Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="torqueUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Torque Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="torqueUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="newton_meter" selected>Newton-meter (N⋅m)</option>
                                                                                    <option value="kilonewton_meter">Kilonewton-meter (kN⋅m)</option>
                                                                                    <option value="foot_pound">Foot-pound (ft⋅lb)</option>
                                                                                    <option value="inch_pound">Inch-pound (in⋅lb)</option>
                                                                                    <option value="dyne_centimeter">Dyne-centimeter (dyn⋅cm)</option>
                                                                                    <option value="kilogram_meter">Kilogram-force meter (kgf⋅m)</option>
                                                                                    <option value="pound_inch">Pound-inch (lb⋅in)</option>
                                                                                    <option value="ounce_inch">Ounce-inch (oz⋅in)</option>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                            <!-- Angular Displacement Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="angleValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Angular Displacement
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="angleValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter angle (e.g., 1)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Angle</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter angular displacement (required for energy calculation)</p>
                                                                            </div>

                                                                            <!-- Angle Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="angleUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Angle Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="angleUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="radian" selected>Radian (rad)</option>
                                                                                    <option value="degree">Degree (°)</option>
                                                                                    <option value="revolution">Revolution (rev)</option>
                                                                                    <option value="gradian">Gradian (gon)</option>
                                                                                    <option value="milliradian">Milliradian (mrad)</option>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <!-- Application Type -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Application Type
                                                                                </label>
                                                                                <select 
                                                                                    id="applicationType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">General calculation</option>
                                                                                    <option value="motor">Electric Motor</option>
                                                                                    <option value="engine">Internal Combustion Engine</option>
                                                                                    <option value="wrench">Wrench/Fastener</option>
                                                                                    <option value="turbine">Turbine/Generator</option>
                                                                                    <option value="gearbox">Gearbox/Transmission</option>
                                                                                    <option value="robotics">Robotics/Automation</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Rotational Energy Calculation Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Calculated Energy</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Energy result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-green-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-green-600 hover:text-green-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Energy Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Energy Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Energy Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Joules</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="joulesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI energy unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Watt-hours</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="wattHoursDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Electrical energy</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Calories</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="caloriesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Thermal energy</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mechanical Parameters -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Mechanical Parameters</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Torque</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="torqueNmDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Newton-meters</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Angle</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="angleRadDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Radians</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Work Done</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="workDoneDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Rotational work</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Applications -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Applications</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Motor Power</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="motorPowerDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Equivalent power</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Fastener Type</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="fastenerTypeDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Bolt/nut category</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Energy Class</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="energyClassDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Energy magnitude</div>
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
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-torque="100" data-torque-unit="newton_meter" data-angle="1" data-angle-unit="radian">100 N⋅m, 1 rad</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-torque="50" data-torque-unit="foot_pound" data-angle="90" data-angle-unit="degree">50 ft⋅lb, 90°</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-torque="200" data-torque-unit="newton_meter" data-angle="1" data-angle-unit="revolution">200 N⋅m, 1 rev</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-torque="25" data-torque-unit="kilogram_meter" data-angle="180" data-angle-unit="degree">25 kgf⋅m, 180°</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Torque & Energy Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 N⋅m</strong> = 1 J/rad</div>
                                                        <div><strong>1 ft⋅lb</strong> = 1.356 N⋅m</div>
                                                        <div><strong>1 revolution</strong> = 2π radians</div>
                                                        <div><strong>1 degree</strong> = π/180 radians</div>
                                                        <div><strong>Car lug nuts</strong> ≈ 100 N⋅m</div>
                                                        <div><strong>Bike pedal</strong> ≈ 40 N⋅m</div>
                                                        <div><strong>Electric drill</strong> ≈ 50 N⋅m</div>
                                                        <div><strong>Engine torque</strong> ≈ 300 N⋅m</div>
                                                        <div><strong>Small motor</strong> ≈ 1-10 N⋅m</div>
                                                        <div><strong>Hand wrench</strong> ≈ 20 N⋅m</div>
                                                        <div><strong>Impact wrench</strong> ≈ 500 N⋅m</div>
                                                        <div><strong>Industrial motor</strong> > 1000 N⋅m</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const torqueValue = document.getElementById('torqueValue');
                        const torqueUnit = document.getElementById('torqueUnit');
                        const angleValue = document.getElementById('angleValue');
                        const angleUnit = document.getElementById('angleUnit');
                        const applicationType = document.getElementById('applicationType');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const joulesDisplay = document.getElementById('joulesDisplay');
                        const wattHoursDisplay = document.getElementById('wattHoursDisplay');
                        const caloriesDisplay = document.getElementById('caloriesDisplay');
                        const torqueNmDisplay = document.getElementById('torqueNmDisplay');
                        const angleRadDisplay = document.getElementById('angleRadDisplay');
                        const workDoneDisplay = document.getElementById('workDoneDisplay');
                        const motorPowerDisplay = document.getElementById('motorPowerDisplay');
                        const fastenerTypeDisplay = document.getElementById('fastenerTypeDisplay');
                        const energyClassDisplay = document.getElementById('energyClassDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Conversion factors to base units
                        const torqueToNm = {
                            newton_meter: 1,
                            kilonewton_meter: 1000,
                            foot_pound: 1.355818,
                            inch_pound: 0.112985,
                            dyne_centimeter: 1e-7,
                            kilogram_meter: 9.80665,
                            pound_inch: 0.112985,
                            ounce_inch: 0.007062
                        };

                        const angleToRadians = {
                            radian: 1,
                            degree: Math.PI / 180,
                            revolution: 2 * Math.PI,
                            gradian: Math.PI / 200,
                            milliradian: 0.001
                        };

                        const torqueSymbols = {
                            newton_meter: 'N⋅m',
                            kilonewton_meter: 'kN⋅m',
                            foot_pound: 'ft⋅lb',
                            inch_pound: 'in⋅lb',
                            dyne_centimeter: 'dyn⋅cm',
                            kilogram_meter: 'kgf⋅m',
                            pound_inch: 'lb⋅in',
                            ounce_inch: 'oz⋅in'
                        };

                        const angleSymbols = {
                            radian: 'rad',
                            degree: '°',
                            revolution: 'rev',
                            gradian: 'gon',
                            milliradian: 'mrad'
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

                        function getFastenerType(torqueNm) {
                            if (torqueNm < 5) return 'Small screws';
                            if (torqueNm < 20) return 'Machine screws';
                            if (torqueNm < 50) return 'Standard bolts';
                            if (torqueNm < 100) return 'Automotive bolts';
                            if (torqueNm < 300) return 'Heavy-duty bolts';
                            if (torqueNm < 1000) return 'Industrial fasteners';
                            return 'Massive fasteners';
                        }

                        function getEnergyClass(joules) {
                            if (joules < 0.001) return 'Micro-energy';
                            if (joules < 1) return 'Low energy';
                            if (joules < 100) return 'Moderate energy';
                            if (joules < 10000) return 'High energy';
                            if (joules < 1000000) return 'Very high energy';
                            return 'Extreme energy';
                        }

                        function getMotorPower(joules, angleRad) {
                            // Assume 1 second for power calculation (P = E/t)
                            if (angleRad === 0) return 'N/A';
                            const power = joules; // For 1 second duration
                            if (power < 1) return formatNumber(power * 1000) + ' mW';
                            if (power < 1000) return formatNumber(power) + ' W';
                            return formatNumber(power / 1000) + ' kW';
                        }

                        function calculate() {
                            const torque = parseFloat(torqueValue.value);
                            const angle = parseFloat(angleValue.value);
                            const tUnit = torqueUnit.value;
                            const aUnit = angleUnit.value;

                            if (!isNaN(torque) && !isNaN(angle) && torque >= 0 && angle >= 0) {
                                // Convert to base units
                                const torqueNm = torque * torqueToNm[tUnit];
                                const angleRad = angle * angleToRadians[aUnit];
                                
                                // Calculate energy: E = τ × θ
                                const energy = torqueNm * angleRad;
                                
                                // Update primary output
                                output.textContent = formatNumber(energy) + ' J';
                                resultTitle.textContent = 'Energy in Joules (J)';
                                resultDescription.textContent = `${torque} ${torqueSymbols[tUnit]} × ${angle} ${angleSymbols[aUnit]} = ${formatNumber(energy)} J`;

                                // Display in different energy units
                                joulesDisplay.textContent = formatNumber(energy) + ' J';
                                wattHoursDisplay.textContent = formatNumber(energy / 3600) + ' Wh';
                                caloriesDisplay.textContent = formatNumber(energy / 4.184) + ' cal';

                                // Display mechanical parameters
                                torqueNmDisplay.textContent = formatNumber(torqueNm) + ' N⋅m';
                                angleRadDisplay.textContent = formatNumber(angleRad) + ' rad';
                                workDoneDisplay.textContent = formatNumber(energy) + ' J';

                                // Applications
                                motorPowerDisplay.textContent = getMotorPower(energy, angleRad);
                                fastenerTypeDisplay.textContent = getFastenerType(torqueNm);
                                energyClassDisplay.textContent = getEnergyClass(energy);


                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Calculated Energy';
                            resultDescription.textContent = 'Energy result';
                            joulesDisplay.textContent = '--';
                            wattHoursDisplay.textContent = '--';
                            caloriesDisplay.textContent = '--';
                            torqueNmDisplay.textContent = '--';
                            angleRadDisplay.textContent = '--';
                            workDoneDisplay.textContent = '--';
                            motorPowerDisplay.textContent = '--';
                            fastenerTypeDisplay.textContent = '--';
                            energyClassDisplay.textContent = '--';
                        }

                        function clearAll() {
                            torqueValue.value = '';
                            torqueUnit.value = 'newton_meter';
                            angleValue.value = '';
                            angleUnit.value = 'radian';
                            applicationType.value = '';
                            clearOutputs();
                            torqueValue.focus();
                        }

                        // Event listeners
                        torqueValue.addEventListener('input', calculate);
                        torqueUnit.addEventListener('change', calculate);
                        angleValue.addEventListener('input', calculate);
                        angleUnit.addEventListener('change', calculate);
                        applicationType.addEventListener('change', calculate);

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
                                const torque = this.getAttribute('data-torque');
                                const tUnit = this.getAttribute('data-torque-unit');
                                const angle = this.getAttribute('data-angle');
                                const aUnit = this.getAttribute('data-angle-unit');
                                
                                torqueValue.value = torque;
                                torqueUnit.value = tUnit;
                                angleValue.value = angle;
                                angleUnit.value = aUnit;
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-green-100', 'text-green-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-green-100', 'text-green-700');
                            });
                        });

                        // Initialize
                        torqueValue.focus();

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
